@extends('layout.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Détails du Groupe</h4>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <strong>Code Groupe :</strong>
                <span>{{ $groupe->code_g }}</span>
            </div>

            <div class="mb-3">
                <strong>Nom Groupe :</strong>
                <span>{{ $groupe->nom_g }}</span>
            </div>

            <div class="mb-3">
                <strong>Filière :</strong>
                <span>{{ $groupe->filiere->nom_filiere_francais ?? 'N/A' }}</span>
            </div>

            <div class="mb-3">
                <strong>Capacité :</strong>
                <span>{{ $groupe->capacite }}</span>
            </div>

            <a href="{{ route('groupes.index') }}" class="btn btn-secondary">
                Retour
            </a>

            <a href="{{ route('groupes.edit', $groupe->code_g) }}" class="btn btn-warning">
                Modifier
            </a>

        </div>

    </div>

</div>

@endsection