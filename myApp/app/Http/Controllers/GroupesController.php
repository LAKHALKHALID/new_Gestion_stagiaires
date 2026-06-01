<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Groupe;
use Illuminate\Http\Request;

class GroupesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filiers = Filiere::all();

        $query = Groupe::query();

        if ($request->filled('filiere_id')) {
            $query->where('filiere_id', $request->filiere_id);
        }
        $groupes = $query->paginate(10);
        $nb = $query->count(); 
        return view('groupes.index', compact('groupes', 'filiers', 'nb'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filiers = Filiere::all();
        return view('groupes.create',compact('filiers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code_g' => 'required|unique:groupes,code_g',
            'filiere_id' => 'required',
            'nom_g' => 'required',
            'capacite' => 'required|integer',
        ], [
            'code_g.required' => 'Le code du groupe est obligatoire',
            'code_g.unique' => 'Ce code existe déjà',
            'filiere_id.required' => 'La filière est obligatoire',
            'nom_g.required' => 'Le nom du groupe est obligatoire',
            'capacite.required' => 'La capacité est obligatoire',
            'capacite.integer' => 'La capacité doit être un nombre',
        ]);

        Groupe::create($request->all());

        return redirect()->route('groupes.index')
            ->with('success', 'Groupe ajouté avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $groupe = Groupe::findOrFail($id);
        return view('groupes.show', compact('groupe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $groupe = Groupe::findOrFail($id);
        $filiers = Filiere::all();

        return view('groupes.edit', compact('groupe', 'filiers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'filiere_id' => 'required',
        'nom_g' => 'required',
        'capacite' => 'required|integer',
        ], [
            'filiere_id.required' => 'La filière est obligatoire',
            'nom_g.required' => 'Le nom du groupe est obligatoire',
            'capacite.required' => 'La capacité est obligatoire',
            'capacite.integer' => 'La capacité doit être un nombre',
        ]);
        $groupe = Groupe::findOrFail($id);
        $groupe->update($request->all());
        return redirect()->route('groupes.index')
            ->with('success', 'Groupe modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $groupe = Groupe::findOrFail($id);
        $groupe->delete();
        return redirect()->route('groupes.index')
            ->with('success', 'Groupe supprimé avec succès');
    }

    public function toImport()
    {
        return view('groupes.import');
    }

    public function import(Request $request)
    {
        $file = $request->file('file');

        if (!$file) {
            return back()->with('error', 'No file uploaded');
        }

        $handle = fopen($file->getRealPath(), 'r');

        $header = true;




        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            
            // skip header row
            if ($header) {
                $header = false;
                continue;
            }
            if ($file && $file->extension() !== 'csv') {
                return back()->with('error', 'You should upload a csv file !');
            }
            $code_g = $row[0] ?? null;
            $nom_g = $row[1] ?? null;
            $filiere_id = $row[2] ?? null;
            if(!Filiere::find($filiere_id)){
                return redirect()->back()->with('error','you should import first Filiers');
            }
            if(empty($code_g) || empty($nom_g) || empty($filiere_id)){
                continue; // Skip if any of the required fields are missing
            }
            if (Groupe::where('code_g', $code_g)->exists()) {
                continue; // Skip if code_g already exists in the database
            }
            Groupe::create([
                'code_g' => $row[0] ?? null,
                'nom_g' => $row[1] ?? null,
                'filiere_id' => $row[2] ?? null,
                'desc' => $row[3] ?? null,
                'capacite' => $row[4] ?? null,
                
            ]);
        }

        fclose($handle);

        return back()->with('success', 'Data imported successfully!');
    }
}
