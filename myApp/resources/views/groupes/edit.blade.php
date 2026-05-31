@extends('layout.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Modifier Groupe</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('groupes.update', $groupe->code_g) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- CODE G --}}
                <div class="mb-3">
                    <input type="text" name="code_g"
                           value="{{ old('code_g', $groupe->code_g) }}"
                           class="form-control @error('code_g') is-invalid @enderror"
                           placeholder="Code Groupe">

                    @error('code_g')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <select name="filiere_id"
                            class="form-control @error('filiere_id') is-invalid @enderror">

                        <option value="">Choisir filière</option>

                        @foreach($filiers as $f)
                            <option value="{{ $f->code_f }}"
                                {{ old('filiere_id', $groupe->filiere_id) == $f->code_f ? 'selected' : '' }}>
                                {{ $f->nom_filiere_francais }}
                            </option>
                        @endforeach

                    </select>

                    @error('filiere_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="text" name="nom_g"
                           value="{{ old('nom_g', $groupe->nom_g) }}"
                           class="form-control @error('nom_g') is-invalid @enderror"
                           placeholder="Nom Groupe">

                    @error('nom_g')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="number" name="capacite"
                           value="{{ old('capacite', $groupe->capacite) }}"
                           class="form-control @error('capacite') is-invalid @enderror"
                           placeholder="Capacité">

                    @error('capacite')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <textarea name="desc"
                            class="form-control @error('desc') is-invalid @enderror"
                            placeholder="Description">{{ old('desc', $groupe->desc) }}</textarea>

                    @error('desc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-warning">
                    Modifier
                </button>

                <a href="{{ route('groupes.index') }}" class="btn btn-secondary">
                    Annuler
                </a>

            </form>

        </div>
    </div>

</div>

@endsection