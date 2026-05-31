@extends('layout.app')

{{-- @section('title', 'Create Engagement') --}}

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
            <h4>Create Engagement</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('engagements.store') }}" method="POST">
                @csrf


                {{-- Stagiaire --}}
                <div class="mb-3">
                    <label class="form-label">Stagiaire</label>

                    <input 
                        type="text" 
                        name="stagiaire_id" 
                        class="form-control"
                        placeholder="Enter stagiaire id"
                    >
                </div>

                {{-- Motif --}}
                <div class="mb-3">
                    <label class="form-label">Motif</label>

                    <select name="motif" class="form-select">
                        <option value="">-- Select Motif --</option>
                        <option value="Absence">Absence</option>
                        <option value="Retrais Bac">Retrais Bac</option>
                        <option value="Comportement">Comportement</option>
                    </select>
                </div>

                

                {{-- Date --}}
                <div class="mb-3">
                    <label class="form-label">Date</label>

                    <input 
                        type="date" 
                        name="date" 
                        class="form-control"
                    >
                </div>

                <button type="submit" class="btn btn-primary">
                    Save
                </button>

            </form>

        </div>
    </div>
</div>

@endsection

