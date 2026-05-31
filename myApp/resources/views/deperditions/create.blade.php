@extends('layout.app')

{{-- @section('title','create') --}}

@section('content')

<div class="container mt-4">
  @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    
    <div class="card shadow">
        
        <div class="card-header">
            <h3>Create Deperdition</h3>
        </div>

        <div class="card-body">

            <form action="{{ route('deperditions.store') }}" method="POST">
                @csrf

                {{-- Stagiaire --}}
                <div class="mb-3">
                    <label class="form-label">Stagiaire ID</label>

                    <input 
                        type="text"
                        name="stagiaire_id"
                        class="form-control"
                        placeholder="Enter stagiaire CEF"
                        value="{{ old('stagiaire_id') }}"
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
                        value="{{ old('raison_deperdition') }}"
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
                        value="{{ old('date_deperdition') }}"
                    >

                    @error('date_deperdition')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                

                {{-- Buttons --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Save
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