@extends('layout.app')

@section('content')
<div class="container mt-5">

    <div class="card shadow rounded-4 border-0">
        <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Ajouter Groupe</h4>
            <a href="{{ route('groupes.index') }}" class="btn btn-sm btn-outline-light">
                ← Retour
            </a>
        </div>

        <div class="card-body">

            <form action="{{ route('groupes.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Code Groupe</label>
                    <input type="text" name="code_g"
                           value="{{ old('code_g') }}"
                           class="form-control @error('code_g') is-invalid @enderror"
                           placeholder="Ex: GRP101">

                    @error('code_g')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Filière</label>
                    <select name="filiere_id"
                            class="form-select @error('filiere_id') is-invalid @enderror">

                        <option value="">Choisir filière</option>

                        @foreach($filiers as $f)
                            <option value="{{ $f->code_f }}"
                                {{ old('filiere_id') == $f->code_f ? 'selected' : '' }}>
                                {{ $f->nom_filiere_francais }}
                            </option>
                        @endforeach

                    </select>
                    @error('filiere_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Nom du Groupe</label>
                    <input type="text" name="nom_g"
                           value="{{ old('nom_g') }}"
                           class="form-control @error('nom_g') is-invalid @enderror">

                    @error('nom_g')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Capacité</label>
                    <input type="number" name="capacite"
                           value="{{ old('capacite') }}"
                           class="form-control @error('capacite') is-invalid @enderror">

                    @error('capacite')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- DESCRIPTION --}}
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

                <div class="d-flex justify-content-start gap-2">
                    <button class="btn btn-success px-4">
                        Ajouter
                    </button>

                    <a href="{{ route('groupes.index') }}" class="btn btn-secondary">
                        Annuler
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection