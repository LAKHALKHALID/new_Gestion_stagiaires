@extends('layout.app')

@section('content')
<div class="container mt-5">

    <div class="card shadow rounded-4 border-0">

        <div class="card-header bg-warning text-dark rounded-top-4 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Modifier Filière</h4>
            <a href="{{ route('filiers.index') }}" class="btn btn-sm btn-outline-dark">
                ← Retour
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('filiers.update', $filiere->code_f) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">Code</label>
                    <input type="text" name="code_f" readonly
                           value="{{ old('code_f', $filiere->code_f) }}"
                           class="form-control bg-light">
                </div>

                {{-- <div class="mb-3">
                    <label class="form-label fw-bold">Niveau</label>
                    <select name="niveau"
                            class="form-select @error('niveau') is-invalid @enderror">
                        <option value="">Choisir niveau</option>
                        <option value="Technicien"
                            {{ old('niveau', $filiere->niveau) == 'Technicien' ? 'selected' : '' }}>
                            Technicien
                        </option>
                        <option value="Technicien Spécialisé"
                            {{ old('niveau', $filiere->niveau) == 'Technicien Spécialisé' ? 'selected' : '' }}>
                            Technicien Spécialisé
                        </option>
                    </select>
                    @error('niveau')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Mode de formation</label>
                    <select name="mode_f"
                            class="form-select @error('mode_f') is-invalid @enderror">
                        <option value="">Choisir mode de formation</option>

                        <option value="Qualifiant"
                            {{ old('mode_formation',$filiere->mode_formation) == 'Qualifiant' ? 'selected' : '' }}>
                            Qualifiant
                        </option>

                        <option value="Diploma"
                            {{ old('mode_formation',$filiere->mode_formation) == 'Diploma' ? 'selected' : '' }}>
                            Diploma
                        </option>
                    </select>
                    @error('mode_f')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Nom (Français)</label>
                    <input type="text" name="nom_filiere_francais"
                           value="{{ old('nom_filiere_francais', $filiere->nom_filiere_francais) }}"
                           class="form-control @error('nom_filiere_francais') is-invalid @enderror">

                    @error('nom_filiere_francais')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-end d-block" dir="rtl">الاسم بالعربية</label>
                    <input type="text" name="nom_filiere_arabe"
                           value="{{ old('nom_filiere_arabe', $filiere->nom_filiere_arabe) }}"
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
                              rows="3">{{ old('desc', $filiere->desc) }}</textarea>

                    @error('desc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold  d-block">Secteur</label>
                    <input type="text" name="secteur"
                           value="{{ old('secteur', $filiere->secteur) }}"
                           class="form-control @error('secteur') is-invalid @enderror"
                           dir="rtl">

                    @error('secteur')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-start gap-2">
                    <button class="btn btn-warning px-4">
                         Modifier
                    </button>
                    <a href="{{ route('filiers.index') }}" class="btn btn-secondary">
                        Annuler
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection