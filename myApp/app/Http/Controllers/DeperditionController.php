<?php

namespace App\Http\Controllers;

use App\Models\Deperdition;
use App\Models\Stagiaire;
use Illuminate\Http\Request;

class DeperditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $deperditions = Deperdition::simplePaginate(10);

        if($request->cef) {
            $stagiaire = Stagiaire::withTrashed()
                ->where('cef', $request->cef)
                ->first();
            if($stagiaire){
                $deperditions = $stagiaire->deperditions;
            }
            $_stagiaire = Stagiaire::find($request->cef);
            if($_stagiaire){
                return redirect()->route('deperditions.index')->with('success', 'this Stagiaire does not have any Deperdition');
            }

        }

        return view('deperditions.index', compact('deperditions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('deperditions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $stagiaire = Stagiaire::find($request->stagiaire_id);
        if($stagiaire && $stagiaire->deleted_at == null){
    
            Deperdition::create([
                'stagiaire_id'=>$request->stagiaire_id,
                'raison_deperdition' => $request->raison_deperdition,
                'date_deperdition' => $request->date_deperdition,
            ]);
            $stagiaire->delete();
            return redirect()->route('deperditions.index')->with('success','Ajouter Deperdition avec success');
        }
        return redirect()->route('deperditions.create')->with('error', 'this CEF of the stagiaire does not existe !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Deperdition $deperdition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $deperdition = Deperdition::find($id);
        return view('deperditions.edit',compact('deperdition'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
        // return $request;
        $deperdition = Deperdition::find($id);
        $deperdition->update($request->all());
        if($request->raison_retour && !empty($request->raison_retour)){
            // 1. Crucial fix: Added ->withTrashed() so Laravel can find soft-deleted records
        $stagiaire = Stagiaire::withTrashed()->where('cef', $request->stagiaire_id)->first();

        // 2. Safety check: Make sure a stagiaire was actually found
        if ($stagiaire) {
            // 3. Modern Laravel shortcut to restore instead of manually setting null
            $stagiaire->restore();
        }
        }

        return redirect()->route('deperditions.index')->with('success', 'Modifier Deperdition avec success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deperdition $deperdition)
    {
        //
    }
}
