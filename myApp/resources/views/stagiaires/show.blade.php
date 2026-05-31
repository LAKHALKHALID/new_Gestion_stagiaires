@extends('layout.app')

@section('content')
<!-- Include FontAwesome for beautiful modern icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Modern Dashboard Styling Extensions */
    .custom-card {
        border: none;
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        background: #ffffff;
    }
    .custom-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(149, 157, 165, 0.15) !important;
    }
    .profile-avatar {
        border: 4px solid #f8f9fa;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: transform 0.3s ease;
    }
    .profile-avatar:hover {
        transform: scale(1.05);
    }
    .info-row {
        padding: 10px 0;
        border-bottom: 1px dashed #edf2f7;
    }
    .info-row:last-child {
        border-bottom: none;
    }
    .badge-modern {
        padding: 6px 12px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.78rem;
        letter-spacing: 0.3px;
    }
    .btn-modern {
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }
    .btn-modern:hover {
        opacity: 0.9;
    }
</style>

<div class="container py-5">

    <!-- Header / Navigation Line -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="text-muted text-uppercase tracking-wider small fw-bold">Espace Administration</span>
            <h2 class="h3 fw-bold text-dark mb-0">Détails du Stagiaire</h2>
        </div>

        <a href="{{ route('stagiaires.index') }}" class="btn btn-modern btn-light border bg-white shadow-sm">
            <i class="fa-solid fa-arrow-left text-muted"></i> Retour à la liste
        </a>
    </div>

    <!-- Top Card / Profile Header -->
    <div class="card custom-card shadow-sm p-4 mb-4">
        <div class="row align-items-center g-4">
            
            <!-- Avatar + Name -->
            <div class="col-lg-5 col-md-6 d-flex align-items-center gap-4">
                <img src="https://ui-avatars.com/api/?name={{ $stagiaire->prenom_francais }}+{{ $stagiaire->nom_francais }}&size=100&background=eef2ff&color=4f46e5"
                    class="rounded-circle profile-avatar" alt="Avatar" />

                <div>
                    <h3 class="fw-bold text-dark mb-2">
                        {{ $stagiaire->prenom_francais }} {{ $stagiaire->nom_francais }}
                    </h3>
                    <div class="d-flex gap-2">
                        <span class="badge badge-modern bg-success-subtle text-success border border-success-subtle"><i class="fa-solid fa-circle shadow-sm me-1 small"></i> Actif</span>
                        <span class="badge badge-modern bg-primary-subtle text-primary border border-primary-subtle"><i class="fa-solid fa-graduation-cap me-1"></i> Inscrit</span>
                    </div>
                </div>
            </div>

            <!-- Core Metadata Info Grid -->
            <div class="col-lg-4 col-md-6 text-md-start">
                <div class="d-flex flex-column gap-2 text-secondary">
                    <div><i class="fa-solid fa-id-card text-muted me-2 width-20"></i><strong class="text-dark">CEF:</strong> <code class="bg-light px-2 py-1 rounded text-dark fs-6">{{ $stagiaire->cef }}</code></div>
                    <div><i class="fa-solid fa-fingerprint text-muted me-2 width-20"></i><strong class="text-dark">CIN:</strong> {{ $stagiaire->cin }}</div>
                    <div><i class="fa-solid fa-calendar-days text-muted me-2 width-20"></i><strong class="text-dark">Année:</strong> {{ $stagiaire->nom_annee_scolaire }}</div>
                </div>
            </div>

            <!-- Main Fast Actions -->
            <div class="col-lg-3 col-md-12 d-flex flex-md-row flex-lg-column gap-2 justify-content-end">
                <a href="{{ route('stagiaires.edit', $stagiaire->cef) }}" class="btn btn-modern btn-warning text-dark w-100 justify-content-center fw-bold">
                    <i class="fa-solid fa-pen-to-square"></i> Modifier
                </a>
                <button onclick="confirmDelete()" class="btn btn-modern btn-danger w-100 justify-content-center fw-bold">
                    <i class="fa-solid fa-trash"></i> Supprimer
                </button>
            </div>
        </div>
    </div>

    <!-- Details Grid Grid Info -->
    <div class="row g-4">

        <!-- Personal Info Card -->
        <div class="col-md-6">
            <div class="card custom-card shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                  <h5 class="text-primary fw-bold mb-0 d-flex align-items-center gap-2">
                      <i class="fa-solid fa-user-tie text-primary opacity-75"></i> Informations Personnelles
                  </h5>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="d-flex justify-content-between info-row">
                        <span class="text-muted fw-medium">Nom (Français)</span> 
                        <span class="fw-bold text-dark">{{ $stagiaire->nom_francais }}</span>
                    </div>
                    <div class="d-flex justify-content-between info-row">
                        <span class="text-muted fw-medium">Prénom (Français)</span>
                        <span class="fw-bold text-dark">{{ $stagiaire->prenom_francais }}</span>
                    </div>
                    <div class="d-flex justify-content-between info-row" dir="rtl">
                        <span class="fw-bold text-dark text-start w-50">{{ $stagiaire->nom_arabe }}</span>
                        <span class="text-muted fw-medium text-end w-50">(العربية) النسب</span>
                    </div>
                    <div class="d-flex justify-content-between info-row" dir="rtl">
                        <span class="fw-bold text-dark text-start w-50">{{ $stagiaire->prenom_arabe }}</span>
                        <span class="text-muted fw-medium text-end w-50">(العربية) الإسم</span>
                    </div>
                    <div class="d-flex justify-content-between info-row">
                        <span class="text-muted fw-medium">Date de naissance</span>
                        <span class="fw-bold text-dark"><i class="fa-regular fa-calendar text-muted me-1"></i> {{ $stagiaire->date_naissance }}</span>
                    </div>
                    <div class="d-flex justify-content-between info-row">
                        <span class="text-muted fw-medium">Lieu de naissance</span>
                        <span class="fw-bold text-dark">{{ $stagiaire->lieu_naissance }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Info Card -->
        <div class="col-md-6">
            <div class="card custom-card shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="text-primary fw-bold mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-graduation-cap text-primary opacity-75"></i> Informations Académiques
                    </h5>
                </div>

                <div class="card-body px-4 pb-4">
                    <div class="d-flex justify-content-between info-row">
                        <span class="text-muted fw-medium">Année Scolaire</span>
                        <span class="badge bg-light text-dark border fw-bold">{{ $stagiaire->nom_annee_scolaire }}</span>
                    </div>
                    <div class="d-flex justify-content-between info-row">
                        <span class="text-muted fw-medium">Niveau de formation</span>
                        <span class="fw-bold text-dark">{{ $stagiaire->niveau_formation }}</span>
                    </div>
                    <div class="d-flex justify-content-between info-row">
                        <span class="text-muted fw-medium">Type de formation</span>
                        <span class="fw-bold text-dark">{{ $stagiaire->type_formation }}</span>
                    </div>
                    @php
                        $total_absences = 0;
                        foreach ($stagiaire->transactions as $transaction) {
                            $total_absences += $transaction->note;
                        }
                        $note_absence = 10 - $total_absences;
                    @endphp
                    <div class="d-flex justify-content-between info-row">
                        <span class="text-muted fw-medium">Note assiduité / 10</span>
                        <span class="fw-bold {{ $note_absence < 5 ? 'text-danger' : 'text-success' }}">
                            <i class="fa-solid {{ $note_absence < 5 ? 'fa-triangle-exclamation' : 'fa-square-check' }} me-1"></i>
                            {{ $note_absence }} / 10
                        </span>
                    </div>
                    <div class="d-flex justify-content-between info-row">
                        <span class="text-muted fw-medium">Année d'étude</span>
                        <span class="fw-bold text-dark">{{ $stagiaire->annee_etude }}</span>
                    </div>
                    <div class="d-flex justify-content-between info-row">
                        <span class="text-muted fw-medium">Début formation</span>
                        <span class="fw-bold text-dark">{{ $stagiaire->date_demarrage_formation }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filières Info Card -->
        <div class="col-md-6">
            <div class="card custom-card shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="text-dark fw-bold mb-3 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-book-bookmark text-secondary"></i> Filières rattachées
                    </h5>
                    @if($stagiaire->filieres->isEmpty())
                        <p class="text-muted my-2 small">Aucune filière assignée.</p>
                    @else
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($stagiaire->filieres as $item)
                                <span class="badge bg-light border text-dark p-2 px-3 rounded-3 fw-semibold shadow-sm">
                                    {{ $item->nom_filiere_francais }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Groupes Info Card -->
        <div class="col-md-6">
            <div class="card custom-card shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="text-dark fw-bold mb-3 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-users text-secondary"></i> Groupes d'appartenance
                    </h5>
                    @if($stagiaire->groupes->isEmpty())
                        <p class="text-muted my-2 small">Aucun groupe assigné.</p>
                    @else
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($stagiaire->groupes as $item)
                                <span class="badge bg-primary text-white p-2 px-3 rounded-3 fw-semibold shadow-sm">
                                    <i class="fa-solid fa-layer-group me-1 opacity-75"></i> {{ $item->nom_g }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <!-- Hidden Secure Delete Form -->
    <form id="delete-form" action="{{ route('stagiaires.destroy', $stagiaire->cef) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

</div>

<!-- Simple Modern Pop-up Confirmation Interaction -->
<script>
    function confirmDelete() {
        if (confirm("Êtes-vous sûr de vouloir définitivement supprimer ce stagiaire ? Cette action est irréversible.")) {
            document.getElementById('delete-form').submit();
        }
    }
</script>
@endsection