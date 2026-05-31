<?php

namespace App\Http\Controllers;

use App\Models\Engagement;
use App\Models\Stagiaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EngagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $engagements = Engagement::all();
        return view('engagements.index',compact('engagements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('engagements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $stagiaire = Stagiaire::find($request->stagiaire_id);
        // return $stagiaire;
        if($stagiaire){
            Engagement::create($request->all());
            return redirect()->route('engagements.index')->with('success','Ajouter avec succée');
        }
        return redirect()->route('engagements.create')->with('error', 'c\'est cef né pas exist ');
    }

    /**
     * Display the specified resource.
     */
    public function show(Engagement $engagement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $engagement = Engagement::findOrFail($id);

        return view('engagements.edit', compact('engagement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $engagement = Engagement::findOrFail($id);

        $engagement->update([
            'stagiaire_id' => $request->stagiaire_id,
            'motif' => $request->motif,
            'date' => $request->date,
        ]);

        return redirect()
            ->route('engagements.index')
            ->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $engagement = Engagement::find($id);
        $engagement->delete();
        Session::flash('success','Delelte engagement avec succée');
        return to_route('engagements.index');
    }
}
