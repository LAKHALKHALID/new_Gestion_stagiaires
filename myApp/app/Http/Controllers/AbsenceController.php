<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Groupe;
use App\Models\Stagiaire;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AbsenceController extends Controller
{




    public function index(Request $req)
    {
        // 1. If a CEF is searched but doesn't exist, stop immediately and redirect back
        if ($req->filled('cef') && !Stagiaire::where('cef', $req->cef)->exists()) {
            return redirect()
                ->route('absences.index')
                ->with('error', 'CEF not found!');
        }

        // 2. Build the query cleanly using conditional constraints
        $absences = Absence::query()
            ->when($req->cef, function ($query, $cef) {
                $query->where('stagiaire_id', $cef);
                // Note: Use $cef directly if your foreign key matches the form input value!
            })
            ->latest() // Optional: Order by newest records first
            ->paginate(10);

        return view('absences.index', compact('absences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('absences.create');
    }

    /**
     * Store a newly created resource in storage.
     */




    // public function store(Request $req)
    // {
    //     // 1. Extract values from the flat form structure
    //     $stagiaireId = $req->cef;
    //     $dateSelected = \Carbon\Carbon::parse($req->date);
    //     $dateFormatted = $dateSelected->format('Y-m-d');

    //     // Calculate startWeek dynamically (Monday of that week) since it's not sent by the form
    //     $startWeek = $dateSelected->startOfWeek()->format('Y-m-d');

    //     // Checked sessions array (fallback to empty array if all checkboxes are unchecked)
    //     $seancesSubmitted = $req->seance ?? [];

    //     // 2. Calculate Penalties and Delta Points Balance
    //     $newSeanceCount = count($seancesSubmitted);
    //     $newPenalty = $newSeanceCount * 0.5;

    //     // Look up if an absence row already exists for this student on this exact day
    //     $existingAbsence = Absence::where('stagiaire_id', $stagiaireId)
    //         ->where('date', $dateFormatted)
    //         ->first();

    //     $oldPenalty = 0;
    //     if ($existingAbsence) {
    //         $oldSeanceCount = $existingAbsence->seance ? count(explode(' ;', $existingAbsence->seance)) : 0;
    //         $oldPenalty = $oldSeanceCount * 0.5;
    //     }

    //     // Delta = New Day State - Old Day State
    //     $totalDelta = $newPenalty - $oldPenalty;

    //     // 3. Handle File Upload (Chemin) if provided
    //     $cheminPath = $existingAbsence ? $existingAbsence->chemin : null;
    //     if ($req->hasFile('chemin')) {
    //         // Saves file to storage/app/public/absences
    //         $cheminPath = $req->file('chemin')->store('absences', 'public');
    //     }

    //     // 4. Update or Delete the Absence record
    //     if (empty($seancesSubmitted)) {
    //         // If all sessions are unchecked, delete the record entirely for this day
    //         if ($existingAbsence) {
    //             $existingAbsence->delete();
    //         }
    //     } else {
    //         // Otherwise, save or update the details
    //         Absence::updateOrCreate(
    //             [
    //                 'stagiaire_id' => $stagiaireId,
    //                 'date'         => $dateFormatted,
    //             ],
    //             [
    //                 'status'    => 'absence',
    //                 'seance'    => implode(' ;', $seancesSubmitted),
    //                 'startWeek' => $startWeek,
    //                 'medecin'   => $req->medecin,
    //                 'chemin'    => $cheminPath,
    //             ]
    //         );
    //     }

    //     // 5. Update the Transaction Ledger if point balance changed
    //     if ($totalDelta != 0) {
    //         Transaction::updateOrCreate(
    //             [
    //                 'stagiaire_id' => $stagiaireId,
    //                 'motif'        => 'a',
    //             ],
    //             [
    //                 // Adjusts existing ledger note safely via raw database mathematical operations
    //                 'note'         => DB::raw("note + $totalDelta"),
    //                 'created_at'   => now()->startOfDay(),
    //             ]
    //         );
    //     }



    //     return redirect()->route('absences.index')->with('success', 'Absence mise à jour avec succès !');
    // }

    public function store(Request $req)
    {
        // 1. Extract values from the flat form structure
        $stagiaireId = $req->cef;
        $dateSelected = \Carbon\Carbon::parse($req->date);
        $dateFormatted = $dateSelected->format('Y-m-d');

        // Calculate startWeek dynamically (Monday of that week) since it's not sent by the form
        $startWeek = $dateSelected->startOfWeek()->format('Y-m-d');

        // Checked sessions array (fallback to empty array if all checkboxes are unchecked)
        $seancesSubmitted = $req->seance ?? [];

        // Look up if an absence row already exists for this student on this exact day
        $existingAbsence = Absence::where('stagiaire_id', $stagiaireId)
            ->where('date', $dateFormatted)
            ->first();

        // 2. Handle File Upload (Chemin) first, so we know if it exists
        $cheminPath = $existingAbsence ? $existingAbsence->chemin : null;
        if ($req->hasFile('chemin')) {
            // Saves file to storage/app/public/absences
            $cheminPath = $req->file('chemin')->store('absences', 'public');
        }

        // 3. Calculate Penalties and Delta Points Balance
        $newSeanceCount = count($seancesSubmitted);

        // CONDITION: If a justification file exists, the penalty for today becomes 0 (Justified)
        if (!empty($cheminPath)) {
            $newPenalty = 0;
        } else {
            $newPenalty = $newSeanceCount * 0.5;
        }

        $oldPenalty = 0;
        if ($existingAbsence) {
            $oldSeanceCount = $existingAbsence->seance ? count(explode(' ;', $existingAbsence->seance)) : 0;

            // If the old record already had a file, its old applied penalty was already 0
            if (!empty($existingAbsence->chemin)) {
                $oldPenalty = 0;
            } else {
                $oldPenalty = $oldSeanceCount * 0.5;
            }
        }

        // Delta = New Day State - Old Day State
        // If a file was just added, $newPenalty is 0, so $totalDelta will be negative (subtracting points)
        $totalDelta = $newPenalty - $oldPenalty;

        // 4. Update or Delete the Absence record
        if (empty($seancesSubmitted)) {
            // If all sessions are unchecked, delete the record entirely for this day
            if ($existingAbsence) {
                $existingAbsence->delete();
            }
        } else {
            // Otherwise, save or update the details
            Absence::updateOrCreate(
                [
                    'stagiaire_id' => $stagiaireId,
                    'date'         => $dateFormatted,
                ],
                [
                    'status'    => 'absence',
                    'seance'    => implode(' ;', $seancesSubmitted),
                    'startWeek' => $startWeek,
                    'medecin'   => $req->medecin,
                    'chemin'    => $cheminPath,
                ]
            );
        }

        // 5. Update the Transaction Ledger if point balance changed
        if ($totalDelta != 0) {
            Transaction::updateOrCreate(
                [
                    'stagiaire_id' => $stagiaireId,
                    'motif'        => 'a',
                ],
                [
                    // Adjusts existing ledger note safely. 
                    // Adding a negative delta (e.g., + -1.5) mathematically subtracts the points!
                    'note'         => DB::raw("note + $totalDelta"),
                    'created_at'   => now()->startOfDay(),
                ]
            );
        }

        return redirect()->route('absences.index')->with('success', 'Absence mise à jour avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ab = Absence::find($id);
        // return $ab;
        $seance = $ab->seance;
        $data = explode(' ;',$seance);
        

        return view('absences.edit',compact('ab','data'));
    }


    // public function update(Request $req, string $id)
    // {
        
    //     $absence = Absence::findOrFail($id);

    //     // old seances count
    //     $oldCount = $absence->seance
    //         ? count(explode(' ;', $absence->seance))
    //         : 0;

    //     $seance = $req->seance;

    //     // transaction of this stagiaire
    //     $transaction = Transaction::where('stagiaire_id', $absence->stagiaire_id)
    //         ->where('motif', 'a')
    //         ->latest()
    //         ->first();

    //     /*
    //     |--------------------------------------------------------------------------
    //     | IF seance is NULL
    //     |--------------------------------------------------------------------------
    //     */
    //     if ($seance == null) {

    //         // remove absence effect
    //         if ($transaction) {

    //             // OPTION 1 : reset to 0
    //             // $transaction->note = 0;

    //             // OPTION 2 : reverse old note
    //             $transaction->note = $transaction->note - ($oldCount * 0.5);

    //             $transaction->save();
    //         }

    //         // clear absence seance
    //         $absence->seance = null;

    //         $absence->save();

    //         return redirect()->route('absences.index')
    //             ->with('success', 'Absence updated successfully!');
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | NORMAL UPDATE
    //     |--------------------------------------------------------------------------
    //     */
    //     $string = implode(' ;', $seance);

    //     $absence->seance = $string;
    //     $absence->status = 'absence';
    //     $absence->updated_at = now();

    //     if ($req->hasFile('chemin')) {

    //         $absence->justification = 'justifiée';

    //         $format = $req->file('chemin')->extension();
    //         $name = 'img_' . time() . '.' . $format;

    //         $absence->chemin = $req->file('chemin')
    //             ->storeAs('images', $name, 'public');

    //         $absence->medecin = $req->medecin;
    //         $transaction->note = 0;
    //         $transaction->save();
    //     }

    //     // update transaction
    //     $newNote = count($seance) * 0.5;

    //     if ($transaction) {

    //         $transaction->note = $newNote;
    //         $transaction->save();
    //     } else {

    //         Transaction::create([
    //             'stagiaire_id' => $absence->stagiaire_id,
    //             'note' => $newNote,
    //             'motif' => 'a',
    //         ]);
    //     }

    //     $absence->save();

    //     return redirect()->route('absences.index')
    //         ->with('success', 'Update absence avec success !');
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $absence = Absence::find($id);
        $absence->delete();
        return to_route('absences.index');
    }






    // public function store(Request $req)
    // {
    //     // 1. Validate that the stagiaire exists
    //     $st = Stagiaire::find($req->cef);
    //     if (!$st) {
    //         return redirect()->route('absences.create')->with('error', 'This Stagiaire does not exist !');
    //     }

    //     $seance = $req->seance;
    //     $dateFormatted = \Carbon\Carbon::parse($req->date ?? now())->format('Y-m-d');

    //     /*
    //     |--------------------------------------------------------------------------
    //     | CASE 1: IF seance is completely empty/null
    //     |--------------------------------------------------------------------------
    //     | If they sent an empty seance array, it means they are clearing an existing 
    //     | absence or submitted an invalid empty form.
    //     */
    //     if (empty($seance)) {
    //         // Look for an existing absence on this day to clean up points
    //         $existingAbsence = Absence::where('stagiaire_id', $st->cef)
    //             ->where('date', $dateFormatted)
    //             ->first();

    //         if ($existingAbsence) {
    //             $oldSeanceCount = $existingAbsence->seance ? count(explode(' ;', $existingAbsence->seance)) : 0;

    //             // Refund points in the transactions history
    //             $transaction = Transaction::where('stagiaire_id', $st->cef)->where('motif', 'a')->latest()->first();
    //             if ($transaction) {
    //                 $transaction->note = max(0, $transaction->note - ($oldSeanceCount * 0.5));
    //                 $transaction->save();
    //             }

    //             // Remove the absence record completely
    //             $existingAbsence->delete();
    //             return redirect()->route('absences.index')->with('success', 'Absence supprimée avec succès !');
    //         }

    //         return redirect()->route('absences.create')->with('error', 'It is required to select at least one checkbox!');
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | CASE 2: NORMAL OPERATION (CREATE OR UPDATE)
    //     |--------------------------------------------------------------------------
    //     */
    //     $stringSeances = implode(' ;', $seance);

    //     // Check if the student is justified via file upload or presence of metadata
    //     $isJustified = $req->hasFile('chemin') || !empty($req->medecin);

    //     // Calculate the point penalty for this specific submission
    //     $newPenalty = $isJustified ? 0 : (count($seance) * 0.5);

    //     // Look if an absence row already exists for this trainee on this exact date
    //     $absence = Absence::where('stagiaire_id', $st->cef)
    //         ->where('date', $dateFormatted)
    //         ->first();

    //     if ($absence) {
    //         /* * 👉 SUB-CASE A: UPDATE EXISTING ABSENCE
    //      * Calculate how many points we need to add or remove from their transaction ledger
    //      */
    //         $oldSeanceCount = $absence->seance ? count(explode(' ;', $absence->seance)) : 0;
    //         // If it was already justified in the DB before, its old penalty was 0
    //         $oldPenalty = ($absence->status === 'justifiée') ? 0 : ($oldSeanceCount * 0.5);

    //         // Delta calculation (How much the score shifts up or down)
    //         $delta = $newPenalty - $oldPenalty;

    //         // Update the absence attributes
    //         $absence->seance = $stringSeances;
    //         $absence->status = $isJustified ? 'justifiée' : 'absence';
    //         $absence->justification = $isJustified ? 'justifiée' : null;
    //         $absence->medecin = $req->medecin;

    //         if ($req->hasFile('chemin')) {
    //             $format = $req->file('chemin')->extension();
    //             $name = 'img_' . time() . '.' . $format;
    //             $absence->chemin = $req->file('chemin')->storeAs('images', $name, 'public');
    //         }
    //         $absence->save();

    //         // Adjust their Transaction entry by the difference (delta)
    //         if ($delta != 0) {
    //             $transaction = Transaction::where('stagiaire_id', $st->cef)->where('motif', 'a')->latest()->first();
    //             if ($transaction) {
    //                 $transaction->note = max(0, $transaction->note + $delta);
    //                 $transaction->save();
    //             }
    //         }

    //         $msg = 'Absence mise à jour avec succès !';
    //     } else {
    //         /* * 👉 SUB-CASE B: CREATE NEW ABSENCE
    //      */
    //         $cheminPath = null;
    //         if ($req->hasFile('chemin')) {
    //             $format = $req->file('chemin')->extension();
    //             $name = 'img_' . time() . '.' . $format;
    //             $cheminPath = $req->file('chemin')->storeAs('images', $name, 'public');
    //         }

    //         // 1. Write the new row to Absence Table
    //         Absence::create([
    //             'stagiaire_id'  => $st->cef,
    //             'seance'        => $stringSeances,
    //             'status'        => $isJustified ? 'justifiée' : 'absence',
    //             'justification' => $isJustified ? 'justifiée' : null,
    //             'medecin'       => $req->medecin,
    //             'chemin'        => $cheminPath,
    //             'date'          => $dateFormatted
    //         ]);

    //         // 2. Write a unique transaction history row for this absence incident
    //         $transaction = new Transaction();
    //         $transaction->stagiaire_id = $st->cef;
    //         $transaction->note = $newPenalty; // Will automatically log 0 if justified!
    //         $transaction->motif = 'a';
    //         $transaction->save();

    //         $msg = 'Absence ajoutée avec succès !';
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | 3. WEBHOOK TRIGGER CHECK
    //     |--------------------------------------------------------------------------
    //     */
    //     $totalAccumulatedPoints = Transaction::where('stagiaire_id', $st->cef)
    //         ->where('motif', 'a')
    //         ->sum('note');

        

    //     return redirect()->route('absences.index')->with('success', $msg);
    // }
}
