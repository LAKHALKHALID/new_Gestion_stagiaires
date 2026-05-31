@extends('layout.app')

@section('content')
<div class="container mt-5">


    <div class="card shadow border-0 rounded-4">

        <div class="card-header bg-primary text-white rounded-top-4">
            <h5 class="mb-0">Informations générales</h5>
        </div>

        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4 fw-bold text-muted">Code :</div>
                <div class="col-md-8">{{ $filiere->code_f }}</div>
            </div>

            {{-- <div class="row mb-3">
                <div class="col-md-4 fw-bold text-muted">Niveau :</div>
                <div class="col-md-8">
                    <span class="badge bg-info text-dark px-3 py-2">
                        {{ $filiere->niveau }}
                    </span>
                </div>
            </div> --}}

            <div class="row mb-3">
                <div class="col-md-4 fw-bold text-muted">Mode de formation :</div>
                <div class="col-md-8">
                    <span class="badge bg-info text-dark px-3 py-2">
                        {{ $filiere->mode_f }}
                    </span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold text-muted">Nom (Français) :</div>
                <div class="col-md-8 text-primary">
                    {{ $filiere->nom_filiere_francais }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold text-muted">Nom (Arabe) :</div>
                <div class="col-md-8" style="direction: rtl;">
                    {{ $filiere->nom_filiere_arabe }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold text-muted">Description :</div>
                <div class="col-md-8">
                    <div class="p-2 bg-light rounded">
                        {{ $filiere->desc }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 fw-bold text-muted">Secteur :</div>
                <div class="col-md-8">
                    <span class="badge bg-success px-3 py-2">
                        {{ $filiere->secteur }}
                    </span>
                </div>
            </div>

        </div>

        <div class="card-footer text-start bg-white">
            <a href="{{ route('filiers.index') }}" class="btn btn-secondary">
              Retour
            </a>
            <a href="{{ route('filiers.edit', $filiere->code_f) }}" class="btn btn-warning">
                 Modifier
            </a>
            
        </div>

    </div>

</div>
@endsection