@extends('layout.app')
@php($cities = [
    "Zagora",
    "Youssoufia",
    "Tiznit",
    "Tinghir",
    "Tétouan",
    "Témara",
    "Taza",
    "Taourirt",
    "Taroudant",
    "Tanger",
    "Tan-Tan",
    "Taounate",
    "Tata",
    "Sidi Slimane",
    "Sidi Kacem",
    "Sidi Bennour",
    "Skhirat",
    "Settat",
    "Sefrou",
    "Salé",
    "Safi",
    "Rhamna",
    "Rabat",
    "Ouezzane",
    "Ouarzazate",
    "Oujda",
    "Nouaceur",
    "Nador",
    "M'diq",
    "Midelt",
    "Meknès",
    "Mohammedia",
    "Marrakech",
    "Larache",
    "Laâyoune",
    "Khouribga",
    "Kénitra",
    "Jerada",
    "Imouzzer Kandar",
    "Ifrane",
    "Guelmim",
    "Fnideq",
    "Fquih Ben Salah",
    "Fès",
    "Errachidia",
    "Essaouira",
    "Es-Semara",
    "El Kelaa des Sraghna",
    "El Jadida",
    "Driouch",
    "Dakhla",
    "Chichaoua",
    "Chefchaouen",
    "Chtouka Ait Baha",
    "Casablanca",
    "Boulemane",
    "Berkane",
    "Berrechid",
    "Benslimane",
    "Beni Mellal",
    "Azrou",
    "Azilal",
    "Al Hoceima",
    "Agadir"
])

@section('content')

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Create New Stagiaire</h4>
        </div>

        <div class="card-body">
            <form action="{{route('stagiaires.store')}}" method="POST">
                @csrf

                <div class="row">
                    <!-- CEF -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">CEF</label>
                        <input type="text" name="cef" value="{{ old('cef') }}" class="form-control" >
                        @error('cef')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- CIN -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">CIN</label>
                        <input type="text" name="cin" value="{{ old('cin') }}" class="form-control" >
                        @error('cin')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nom Français -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom (Français)</label>
                        <input type="text" name="nom_francais" value="{{ old('nom_francais') }}" class="form-control" >
                        @error('nom_francais')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Prénom Français -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prénom (Français)</label>
                        <input type="text" name="prenom_francais" value="{{ old('prenom_francais') }}" class="form-control" >
                        @error('prenom_francais')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nom Arabe -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom (Arabe)</label>
                        <input type="text" name="nom_arabe" value="{{ old('nom_arabe') }}" class="form-control" dir="rtl">
                        @error('nom_arabe')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Prénom Arabe -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prénom (Arabe)</label>
                        <input type="text" name="prenom_arabe" value="{{ old('prenom_arabe') }}" class="form-control" dir="rtl">
                        @error('prenom_arabe')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Année scolaire -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Année Scolaire</label>
                        <select name="nom_annee_scolaire" class="form-control" >
                            @for ($i = date('Y'); $i >= date('Y')-4; $i--)
                                <option value="{{($i-1).'/'.$i}}">{{($i-1).'/'.$i}}</option>
                            @endfor
                        </select>
                        @error('nom_annee_scolaire')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Date naissance -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date de Naissance</label>
                        <input type="date" name="date_naissance" value="{{ old('date_naissance') }}" class="form-control">
                        @error('date_naissance')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Lieu naissance -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lieu de Naissance</label>
                        {{-- <input type="text" name="lieu_naissance" class="form-control"> --}}
                        <select name="lieu_naissance"  class="form-control" >
                            <option value="">-- Select City --</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ old('lieu_naissance') == $city ?'selected':'' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                        @error('lieu_naissance')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    
                    <!-- Niveau formation -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Niveau Formation</label>
                        <select name="niveau_formation" class="form-control" >
                            <option value="Technicien" {{ old('niveau_formation') == 'Technicien' ?'selected':'' }}>Technicien</option>
                            <option value="Technicien spécialisé" {{ old('niveau_formation') == 'Technicien' ?'selected':'' }}>Technicien spécialisé</option>
                            
                        </select>
                        @error('niveau_formation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Type formation -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Type Formation</label>
                        <input type="text" name="type_formation" value="{{ old('type_formation') }}" class="form-control">
                        @error('type_formation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Année étude -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Année Étude</label>
                        <select name="annee_etude" class="form-control" >
                            <option value="1ère année" {{ old('annee_etude') == '1ère année' ?'selected':'' }}>1ère année</option>
                            <option value="2ème année" {{ old('annee_etude') == '2ème année' ?'selected':'' }}>2ème année</option>
                            <option value="3ème année"{{ old('annee_etude') == '3ème année' ?'selected':'' }}>3ème année</option>
                        </select>
                        @error('annee_etude')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Date démarrage -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date Démarrage Formation</label>
                        <input type="date" name="date_demarrage_formation" value="{{ old('date_demarrage_formation') }}" class="form-control">
                        @error('date_demarrage_formation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="tel" name="tel" value="{{ old('tel') }}" placeholder="+212 6 12 34 56 78" class="form-control">
                        @error('tel')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        Save
                    </button>
                    <a href="{{ route('stagiaires.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
