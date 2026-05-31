@extends('layout.app')

{{-- @section('title','Edit Deperdition') --}}

@section('content')

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header">
            <h3>Edit Deperdition</h3>
        </div>

        <div class="card-body">

            <form action="{{ route('deperditions.update', $deperdition->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Stagiaire ID --}}
                <div class="mb-3">
                    <label class="form-label">Stagiaire ID</label>

                    <input 
                        readonly
                        type="text"
                        name="stagiaire_id"
                        class="form-control"
                        value="{{ old('stagiaire_id', $deperdition->stagiaire_id) }}"
                    >

                    @error('stagiaire_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Raison Deperdition --}}
                <div class="mb-3">
                    <label class="form-label">Raison Deperdition</label>

                    <input 
                        type="text" 
                        name="raison_deperdition"
                        class="form-control"
                        value="{{ old('raison_deperdition', $deperdition->raison_deperdition) }}"
                    >

                    @error('raison_deperdition')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Date Deperdition --}}
                <div class="mb-3">
                    <label class="form-label">Date Deperdition</label>

                    <input 
                        type="date" 
                        name="date_deperdition"
                        class="form-control"
                        value="{{ old('date_deperdition', $deperdition->date_deperdition) }}"
                    >

                    @error('date_deperdition')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Raison Retour --}}
                <div class="mb-3">
                    <label class="form-label">Raison Retour</label>

                    <input 
                        type="text" 
                        name="raison_retour"
                        class="form-control"
                        value="{{ old('raison_retour', $deperdition->raison_retour) }}"
                    >

                    @error('raison_retour')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Date Retour --}}
                <div class="mb-3">
                    <label class="form-label">Date Retour</label>

                    <input 
                        type="date" 
                        name="date_retour"
                        class="form-control"
                        value="{{ old('date_retour', $deperdition->date_retour) }}"
                    >

                    @error('date_retour')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>

                    <a href="{{ route('deperditions.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>

@endsection