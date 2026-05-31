<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use Illuminate\Http\Request;


class FiliersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        $query = Filiere::query()
        ->when($req->mode_f,function($query) use ($req){
            $query->where('mode_formation',$req->mode_f);
        });
        $nb = $query->count();
        $filieres = $query->get();
        return view('filiers.index',compact('filieres','nb'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('filiers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        $req->validate([
        'code_f' => 'required|',
        'mode_formation' => 'required',
        'nom_filiere_francais' => 'required', 
        'nom_filiere_arabe' => 'required',
        ]);
        Filiere::create($req->all());
        return to_route('filiers.index')->with('success','Filière ajoutée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $filiere = Filiere::findOrFail($id);
        return view("filiers.show",compact('filiere'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $filiere = Filiere::findOrFail($id);
        return view("filiers.edit",compact('filiere'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, Filiere $filiere)
{
        // $validated = $req->validate([
        //     'niveau' => 'required',
        //     'mode_formation' => 'required',
        //     'desc' => 'nullable|string',
        //     'secteur' => 'nullable|string',
        //     'nom_filiere_francais' => 'required|regex:/^[\p{L}\s]+$/u',
        //     'nom_filiere_arabe' => 'required|regex:/^[\p{Arabic}\s]+$/u',
        // ]);
        $req->validate([
            'code_f' => 'required|',
            'mode_formation' => 'required',
            'nom_filiere_francais' => 'required',
            'nom_filiere_arabe' => 'required',
        ]);

    $filiere->update($req->all());

    return to_route('filiers.index')
        ->with('success', 'Filière mise à jour avec succès');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $db = Filiere::findOrFail($id);
        $db->delete();
        return to_route('filiers.index');
    }

    public function toImport(){
        return view('filiers.import');
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

            $code_f= $row[0] ?? null;
            if ($file && $file->extension() !== 'csv') {
                return back()->with('error', 'You should upload a csv file !');
            }
            if ($file && $file->extension() !== 'csv') {
                return back()->with('error', 'You should upload a csv file !');
            }

            if (Filiere::where('code_f', $code_f)->exists()) {
                continue; // Skip if code_g already exists in the database
            }

            Filiere::create([
                'code_f'=> $row[0] ?? null,
                'nom_filiere_francais' => $row[1] ?? null,
                'nom_filiere_arabe' => $row[2] ?? null,
                'mode_formation'=> $row[3] ?? null,
                'desc'=> $row[4] ?? null,
                'secteur'=> $row[5] ?? null,
            ]);
        }

        fclose($handle);

        return back()->with('success', 'Data imported successfully!');
    }
}
