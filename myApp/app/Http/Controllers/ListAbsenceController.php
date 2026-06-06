<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Groupe;
use App\Models\Stagiaire;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ListAbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $req)
    {
        $groupe = Groupe::where('nom_g', $req->groupe)->first();
        $startOfWeek =  Carbon::parse($req->date)->startOfWeek();

        $stagiaires = '';

        if ($req->groupe) $stagiaires = $groupe->stagiaires;


        return view('listAbsences.index', compact('stagiaires', 'startOfWeek'));
    }

    
    public function store(Request $req)
    {
        $absences = $req->absences ?? [];
        $groupe = Groupe::where('nom_g', $req->group_name)->first();
        $dateWeek = \Carbon\Carbon::parse($req->start_date)->format('Y-m-d');

        // Track point changes per stagiaire across all calculated days in this request
        $pointsDeltaMap = [];

        /*
        |--------------------------------------------------------------------------
        | 1. CLEANUP: Handle Removed Absences (Unchecked Days)
        |--------------------------------------------------------------------------
        */
        $groupe->stagiaires->each(function ($stagiaire) use ($absences, $dateWeek, &$pointsDeltaMap) {
            $submittedDates = isset($absences[$stagiaire->cef]) ? array_keys($absences[$stagiaire->cef]) : [];

            // Find existing database records for this week
            $oldAbsences = Absence::where('stagiaire_id', $stagiaire->cef)
                ->where('startWeek', $dateWeek)
                ->get();

            foreach ($oldAbsences as $old) {
                // If a previously checked date is completely missing now, it means it was unchecked!
                if (!in_array($old->date, $submittedDates)) {
                    $oldSeanceCount = $old->seance ? count(explode(' ;', $old->seance)) : 0;
                    $refundAmount = $oldSeanceCount * 0.5;

                    // Mark this value as points to subtract (-) from their history
                    $pointsDeltaMap[$stagiaire->cef] = ($pointsDeltaMap[$stagiaire->cef] ?? 0) - $refundAmount;

                    $old->delete();
                }
            }
        });

        /*
        |--------------------------------------------------------------------------
        | 2. MERGE: Process Added or Updated Dates
        |--------------------------------------------------------------------------
        */
        foreach ($absences as $stagiaireId => $absenceDates) {
            foreach ($absenceDates as $date => $seances) {
                $dateFormatted = \Carbon\Carbon::parse($date)->format('Y-m-d');

                $newSeanceCount = count($seances);
                $newPenalty = $newSeanceCount * 0.5;

                // Look up what they originally owed for this specific date
                $existingAbsence = Absence::where('stagiaire_id', $stagiaireId)
                    ->where('date', $dateFormatted)
                    ->first();

                $oldPenalty = 0;
                if ($existingAbsence) {
                    $oldSeanceCount = $existingAbsence->seance ? count(explode(' ;', $existingAbsence->seance)) : 0;
                    $oldPenalty = $oldSeanceCount * 0.5;
                }

                // Delta = New Penalty - Old Penalty
                $dayDelta = $newPenalty - $oldPenalty;
                $pointsDeltaMap[$stagiaireId] = ($pointsDeltaMap[$stagiaireId] ?? 0) + $dayDelta;

                // Perform your updateOrCreate on the Absence table safely
                Absence::updateOrCreate(
                    [
                        'stagiaire_id' => $stagiaireId,
                        'date'         => $dateFormatted,
                    ],
                    [
                        'status'    => 'absence',
                        'seance'    => implode(' ;', $seances),
                        'startWeek' => $dateWeek,
                    ]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 3. TRANSACTION LEDGER: Write unique rows for this weekly submission
        |--------------------------------------------------------------------------
        */
        foreach ($pointsDeltaMap as $stagiaireId => $totalDelta) {
            // return $totalDelta;
            // Only write a ledger record if their attendance configuration actually changed
            if ($totalDelta != 0) {
                Transaction::updateOrCreate(
                    [
                        'stagiaire_id' => $stagiaireId,
                        // Unique link constraint ensuring one historical record block per student per week
                        'motif'        => 'a',
                    ],
                    [
                        // Increment/Decrement logic using database values protection
                        'note'         => DB::raw("note + " . ($totalDelta == -1 ? 0 : $totalDelta)),
                        'created_at'   => now()->startOfDay(),
                        
                    ]
                );
                $data = Transaction::where('stagiaire_id', $stagiaireId)->where('motif', 'a')->first();
                if (floatval($data->note) > 2) {
                    $response = Http::post('http://localhost:5678/webhook/ac26f4e1-4904-4bfd-aab2-288d139fc1ee', [
                        "name" => Stagiaire::where('cef', $stagiaireId)->first()->nom_francais . ' ' . Stagiaire::where('cef', $stagiaireId)->first()->prenom_francais,
                        'Cef' => Stagiaire::where('cef', $stagiaireId)->first()->cef
                    ]);
                }
            }
            
        }

        $groupe_name = $req?->group_name ?? "";
        $date = $req?->start_date ?? "";

        return redirect()->route('listAbsences.index', ["groupe" => $groupe_name, "date" => $date])
            ->with('success', 'Absences et transactions mises à jour avec succès !');
    }

    


    


    

}
