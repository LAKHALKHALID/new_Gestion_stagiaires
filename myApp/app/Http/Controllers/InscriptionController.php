<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Groupe;
use App\Models\Stagiaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $f = Filiere::all();
        $g = Groupe::all();
        return view('inscription.index',compact('f','g'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        $stagiaire = Stagiaire::find($req->cef);
        if($stagiaire){
            $stagiaire->groupes()->attach($req->code_g);
            $stagiaire->filieres()->attach($req->code_f);
            return redirect()->route('inscription.index')->with('success', 'Ajouter Stagiaire avec succée !');
        }
        else{
            Session::flash('refuse','the cef of the Stagiaire incorrect try again !');
            return to_route('inscription.index');
        }
        

    }

    
   

    public function toImport()
    {
        return view('inscription.import');
    }

    

    public function import(Request $request)
    {
        $file = $request->file('file');

        if (!$file) {
            return back()->with('error', 'No file uploaded');
        }
        if ($file && $file->extension() !== 'csv') {
            return back()->with('error', 'You should upload a csv file !');
        }

        $handle = fopen($file->getRealPath(), 'r');
        $header = true;

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            // Skip header row
            if ($header) {
                $header = false;
                continue;
            }

            $cef           = $row[0] ?? null;
            $groupeCode    = $row[1] ?? null; 
            $filiereCode   = $row[2] ?? null; 

            if (!$cef) {
                continue; // Skip if no CEF identifier
            }
            

            // 2. Find or Create the Stagiaire so we don't duplicate records
            $stagiaire = Stagiaire::find($cef);

            $groupe = Groupe::where('code_g', $groupeCode)->first();
            if ($groupe && $stagiaire) {
                $stagiaire->groupes()->syncWithoutDetaching([$groupeCode]);
            }

            $filiere = Filiere::where('code_f', $filiereCode)->first(); 
            if ($filiere && $stagiaire) {
                $stagiaire->filieres()->syncWithoutDetaching([$filiereCode]);
            }
        }

        fclose($handle);

        return back()->with('success', 'Stagiaires and relationships imported successfully!');
    }
}
