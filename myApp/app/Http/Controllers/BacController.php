<?php

namespace App\Http\Controllers;

use App\Models\Bac;
use App\Models\Stagiaire;
use Illuminate\Http\Request;

class BacController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // if($request->is_returned) return $request;
        if($request->cef ){
            $retraitBacs = Bac::where('stagiaire_id', $request->cef)->get();
        }
        $retraitBacs = Bac::all();
        return view('retraitBac.index',compact('retraitBacs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('retraitBac.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $stagiaire =  Stagiaire::find($request->stagiaire_id);
        if($stagiaire){
            if(Bac::where('cne', $request->cne)->exists()){
                return back()->with('error','this cne already exit, and already make retrait back before');
            }
            Bac::create($request->all());
            return redirect()->route('retraitBac.index')->with('success','Ajouter avec succée !');
        }
        return redirect()->route('retraitBac.create')->with('error', 'CEF is not correct !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bac $bac)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bac = Bac::find($id);
        return view('retraitBac.edit',compact('bac'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bac = Bac::find($id);
        $bac->update($request->all());

        return redirect()->route('retraitBac.index')->with('success','update avec succée ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        // $bac = Bac::find($id);
        // $bac->delete();
        // return redirect()->route('retraitBac.index')->with('success', 'Deleted avec succée ');


    }
}
