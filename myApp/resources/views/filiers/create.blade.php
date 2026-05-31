@extends('layout.app')

@section('content')
<div class="container mt-5">

    <div class="card shadow rounded-4 border-0">

        <div class="card-header bg-success text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <h4 class="mb-0"> Ajouter Filière</h4>
            <a href="{{ route('filiers.index') }}" class="btn btn-sm btn-outline-light">
                ← Retour
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('filiers.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Code</label>
                        <input type="text" name="code_f"
                            value="{{ old('code_f') }}"
                            class="form-control @error('code_f') is-invalid @enderror"
                            placeholder="Code">
                    @error('code_f')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- <div class="mb-3">
                    <label class="form-label fw-bold">Niveau</label>
                    <select name="niveau"
                            class="form-select @error('niveau') is-invalid @enderror">
                        <option value="">Choisir niveau</option>

                        <option value="Technicien"
                            {{ old('niveau') == 'Technicien' ? 'selected' : '' }}>
                            Technicien
                        </option>

                        <option value="Technicien Spécialisé"
                            {{ old('niveau') == 'Technicien Spécialisé' ? 'selected' : '' }}>
                            Technicien Spécialisé
                        </option>
                    </select>
                    @error('niveau')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Mode de formation</label>
                    <select name="mode_formation"
                            class="form-select @error('mode_f') is-invalid @enderror">
                        <option value="">Choisir mode de formation</option>

                        <option value="Qualifiant"
                            {{ old('mode_formation') == 'Qualifiant' ? 'selected' : '' }}>
                            Qualifiant
                        </option>

                        <option value="Diploma"
                            {{ old('mode_formation') == 'Diploma' ? 'selected' : '' }}>
                            Diploma
                        </option>
                    </select>
                    @error('mode_formation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
            
                <div class="mb-3">
                    <label class="form-label fw-bold">Nom (Français)</label>
                        <input type="text" name="nom_filiere_francais"
                            value="{{ old('nom_filiere_francais') }}"
                            class="form-control @error('nom_filiere_francais') is-invalid @enderror">
                    @error('nom_filiere_francais')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-end d-block" dir="rtl">الاسم بالعربية</label>
                    <input type="text" name="nom_filiere_arabe"
                           value="{{ old('nom_filiere_arabe') }}"
                           class="form-control text-end @error('nom_filiere_arabe') is-invalid @enderror"
                           dir="rtl">
                    @error('nom_filiere_arabe')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="desc"
                              class="form-control @error('desc') is-invalid @enderror"
                              rows="3"
                              placeholder="Description...">{{ old('desc') }}</textarea>
                    @error('desc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold  d-block" >Secteur</label>
                    <input type="text" name="secteur"
                           value="{{ old('secteur') }}"
                           class="form-control  @error('secteur') is-invalid @enderror"
                           >
                    @error('secteur')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-start">
                    <button class="btn btn-success px-4">
                         Ajouter
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection