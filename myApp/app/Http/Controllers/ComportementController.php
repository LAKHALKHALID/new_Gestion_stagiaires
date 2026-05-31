<?php

namespace App\Http\Controllers;

use App\Models\Comportement;
use App\Models\Stagiaire;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComportementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comp = Comportement::simplePaginate(10);
        return view('comportements.index',compact('comp'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('comportements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $req)
    // {
    //     // return $req;
    //     $stagiaire = Stagiaire::find($req->cef);

    //     if($stagiaire){

    //         $ct = new Comportement();
    //         $ct->sanction = $req->sanction;
    //         $ct->autorite_dec = $req->autorite_dec;
    //         $ct->miseEnGarde = $req->miseEnGarde;
    //         $ct->motife = $req->motif;
    //         $ct->date = $req->date;

    //         $ct->stagiaire_id = $req->cef;
    //         $ct->created_at = $req->date;
    //         $ct->updated_at = null;
    //         $ct->save();
    //         $transaction = new Transaction();
    //         $transaction->stagiaire_id = $stagiaire->cef;
    //         $transaction->motif = 'C';

    //         if ($ct->miseEnGarde == '1ère Mise en garde') {
    //             $transaction->note = 1;
    //         } elseif ($ct->miseEnGarde == '2ème Mise en garde') {
    //             $transaction->note = 2;
    //         } elseif ($ct->miseEnGarde == '3ème Mise en garde') {
    //             $transaction->note = 3;
    //         } elseif ($ct->miseEnGarde == '4ème Mise en garde') {
    //             $transaction->note = 4;
    //         } else {
    //             $transaction->note = 5;
    //         }
    //         $transaction->save();

    //         return redirect()->route('comportements.index')->with('success','Ajouter Comportement avec succée');

    //     }
    //     return redirect()->route('comportements.create')->with('error', 'C\'est CEF de Stagiaire ne pas exist ');



    //     // dd($ct->miseEnGarde);


    // }

    public function store(Request $req)
    {
       
        $stagiaire = Stagiaire::find($req->cef);

        if (!$stagiaire) {
            return redirect()->route('comportements.create')
                ->with('error', 'Ce CEF de Stagiaire n\'existe pas.');
        }

        $formattedDate = \Carbon\Carbon::parse($req->date)->format('Y-m-d');

        // 1. Helper function to map the warning string to its numeric penalty value
        $getPenaltyScore = function ($warningString) {
            return match ($warningString) {
                '1ère Mise en garde' => 1.0,
                '2ème Mise en garde' => 2.0,
                '3ème Mise en garde' => 3.0,
                '4ème Mise en garde' => 4.0,
                default               => 5.0, // Catch-all for higher/other sanctions
            };
        };

        // 2. Find if a behavioral entry already exists for this specific student on this date
        $existingComportement = Comportement::where('stagiaire_id', $req->cef)
            ->where('date', $formattedDate)
            ->first();

        // 3. Calculate the old penalty score if it exists
        $oldPenalty = $existingComportement ? $getPenaltyScore($existingComportement->miseEnGarde) : 0;

        // 4. Calculate the new incoming penalty score
        $newPenalty = $getPenaltyScore($req->miseEnGarde);

        // 5. Calculate the structural Delta (Difference)
        $comportementDelta = $newPenalty - $oldPenalty;

        // 6. Update or Create the Comportement record
        Comportement::updateOrCreate(
            [
                'stagiaire_id' => $req->cef,
                'date'         => $formattedDate,
            ],
            [
                'sanction'     => $req->sanction,
                'autorite_dec' => $req->autorite_dec,
                'miseEnGarde'  => $req->miseEnGarde,
                'motife'       => $req->motif,
                'created_at'   => $formattedDate, // Keeps timestamps matching historical entry date
                'updated_at'   => now(),
            ]
        );

        // 7. Apply the delta adjustment directly onto the Transaction table
        if ($comportementDelta != 0) {
            Transaction::updateOrCreate(
                [
                    'stagiaire_id' => $req->cef,
                    'motif'        => 'c',
                    // Scopes the unique constraint down to the day to prevent transaction duplicates
                    
                ],
                [
                    // Safe database mathematical adjustment (+ or -)
                    'note'         => DB::raw("note + $comportementDelta"),
                    'created_at'   => \Carbon\Carbon::parse($req->date)->startOfDay(),
                ]
            );
        }

        return redirect()->route('comportements.index')
            ->with('success', 'Comportement et transactions mis à jour avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comportement $comportement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $comportement = Comportement::findOrFail($id);

        return view('comportements.edit', compact('comportement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comportement $comportement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comportement $comportement)
    {
        //
    }
}
