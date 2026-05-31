@extends('layout.app')

@section('content')
    <div class="container py-5">
      @if (session('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ session('error') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-sm-5">
                    
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                            <i class="bi bi-search fs-4"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-1">Filter Trainees</h4>
                        <p class="text-muted small">Enter the CEF or select a group to start searching</p>
                    </div>

                    <form action="{{route('document.search')}}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-hash me-1"></i> CEF or Group
                            </label>
                            <input 
                                type="text" 
                                class="form-control form-control-lg shadow-none border-secondary-subtle" 
                                id="title" 
                                name="cef_groupe" 
                                placeholder="e.g., DOWFS201 or 234567"
                            >
                        </div>

                        <div class="mb-4">
                            <label for="action-select" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-filter-square me-1"></i> Selection Options
                            </label>
                            <select name="option" id="action-select" class="form-select form-select-lg shadow-none border-secondary-subtle" aria-label="Selection options">
                                <option selected disabled>Open this select menu</option>
                                <option value="engagement">Engagement</option>
                                <option value="demande">Demande de Stage</option>
                                <option value="controle_continu">PV de Présence Controle Continu</option>
                                <option value="fin_module">PV de Présence d'Examen de Fin de Module</option>
                                <option value="regional">PV de Présence d'Examen Régional</option>

                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-3 shadow-sm py-2.5">
                                <i class="bi bi-check2-circle me-1"></i> Submit
                            </button>
                        </div>
                        
                    </form>
                    
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
    