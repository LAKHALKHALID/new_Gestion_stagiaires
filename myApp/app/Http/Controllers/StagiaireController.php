<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Filiere;
use App\Models\Groupe;
use App\Models\Stagiaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StagiaireController extends Controller
{

    

    public function index(Request $req)
    {
        
        
        $query = Stagiaire::query();

        if ($req->cef) {
            $query->where('cef', $req->cef);

        
            if (!Stagiaire::where('cef', $req->cef)->exists()) {
                return redirect()
                    ->route('stagiaires.index')
                    ->with('error', 'CEF of the stagiaire is not correct !');
            }
        }
        
        elseif ($req->code_g) {
            $code_g = $req->code_g;

            $query->whereHas('groupes', function ($q) use ($code_g) {
                $q->where('code_g', $code_g);
            });
        }

        
        $stagiaires = $query->paginate(10);

        $g = Groupe::all();
        $f = Filiere::all();

        return view('stagiaires.index', compact('stagiaires', 'g', 'f'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stagiaires.create');
    }

    public function badge(Request $request){
        if($request->cef != null){
            
            if(Stagiaire::find($request->cef)){
                $stagiaires = Stagiaire::where('cef',$request->cef)->get();
            }
            else{
                return back()->with('error', 'this cef of the stagiaire is not correct or does not exist');
            }
            
        }
        elseif($request->groupe){
            $groupe = Groupe::where('nom_g', $request->groupe)->first();
            if($groupe){
                $stagiaires = $groupe->stagiaires;
            }
            else{
                return back()->with('error','this groupe does not existe');
            }
        }
        else{
            $stagiaires = [];
        }
        return view('stagiaires.badge',compact('stagiaires'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        $req->validate([
            'cef'=>'required|min:13|max:13',
            'cin'=>'required|min:7|max:8',
            'nom_francais' => 'required|min:3',
            'prenom_francais' => 'required|min:3',
            'nom_annee_scolaire'=>'required',
            'date_naissance' => 'required',
            'lieu_naissance' => 'required',
            'niveau_formation' => 'required',
            'type_formation' => 'required',
            'annee_etude' => 'required',
            'date_demarrage_formation' => 'required',
            'tel' => 'required|regex:/^0[5-7]\d{8}$/',
        ]);
        Stagiaire::create($req->all());
        return redirect()->route('stagiaires.index')->with('success','Ajouter Stagiaire avec succée !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $stagiaire = Stagiaire::find($id);
        return view('stagiaires.show',compact('stagiaire'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $stagiaire = Stagiaire::find($id);
        
        return view('stagiaires.edit',compact('stagiaire'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, string $id)
    {
        $req->validate([
            'nom_francais' => 'required|min:3',
            'prenom_francais' => 'required|min:3',
            'nom_arabe' => 'required|min:3',
            'prenom_arabe' => 'required|min:3',
            'date_naissance' => 'required',
            'lieu_naissance' => 'required',
            'type_formation' => 'required',
            'date_demarrage_formation' => 'required',
            'tel' => 'required|regex:/^0[5-7]\d{8}$/',
        ]);

        $stagiaire = Stagiaire::find($id);
        $stagiaire->update($req->all());

        return redirect()->route('stagiaires.index')->with('success','Més a jour le Stagiaire avec succée !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stagiaire = Stagiaire::find($id);

        $stagiaire->delete();

        return redirect()->route('stagiaires.index')->with('success','Supprimer le Stagiaire avec succée !');

        
    }
    
    public function toImport(){
        return view('stagiaires.toImport');
    }

    

    public function import(Request $request)
    {
        $file = $request->file('file');
        // return $request->file('file')->extension();
        if (!$file) {
            return back()->with('error', 'No file uploaded');
        }
        if ($file && $file->extension() !== 'csv') {
            return back()->with('error', 'You should upload a csv file !');
        }


        $handle = fopen($file->getRealPath(), 'r');
        
        $header = true;
        

        

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {

            // skip header row
            if ($header) {
                $header = false;
                continue;
            }
            $cef = $row[0] ?? null;
            $cin = $row[1] ?? null;

            // 1. Check if the CEF already exists in the database
            if ($cef && Stagiaire::where('cef', $cef)->exists()) {
                continue; // Skip this row and move to the next one
            }
            // 2. Skip if CEF is null/empty OR if CIN is null/empty
            if (empty($cef) || empty($cin)) {
                continue;
            }

            Stagiaire::create([
                'cef' => $row[0] ?? null,
                'cin' => $row[1] ?? null,
                'nom_francais' => $row[2] ?? null,
                'prenom_francais' => $row[3] ?? null,
                'nom_arabe' => $row[4] ?? null,
                'prenom_arabe' => $row[5] ?? null,
                'date_naissance' => Carbon::parse($row[6])->format('Y-m-d') ?? null,
                'lieu_naissance' => $row[7] ?? null,
                'niveau_formation' => $row[8] ?? null,
                'type_formation' => $row[9] ?? null,
                'annee_etude' => $row[10] ?? null,
                'date_demarrage_formation' => Carbon::parse($row[11])->format('Y-m-d') ?? null,
                'tel' => $row[12] ?? null,
                'nom_annee_scolaire' => $row[13] ?? null,
                
            ]);
        }

        fclose($handle);

        return back()->with('success', 'Data imported successfully!');
    }

    public function updateAnnee(Request $request){
        // return  $request;
        $request->validate([
            'nom_annee_scolaire' => 'required|string'
        ]);

        // Store the selected year in the session
        session(['selected_annee' => $request->nom_annee_scolaire]);
        // Redirect back to the page the admin was looking at
        return redirect()->back();
    }
}
