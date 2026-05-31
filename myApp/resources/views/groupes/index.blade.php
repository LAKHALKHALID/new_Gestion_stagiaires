@extends('layout.app')

@section('content')

<div class="container mt-4">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    

        
            

            <a href="{{ route('groupes.create') }}" class="btn btn-primary btn-sm"> Ajouter
            </a>
            <a href="{{route('toImport.groupes')}}" class="btn btn-primary  btn-sm ms-3">Import</a>
        

        

            <form method="GET" action="{{ route('groupes.index') }}" class="my-3">

                <div class="row">

                    <div class="col-md-8">
                        <select name="filiere_id" class="form-control" onchange="this.form.submit()">

                            <option value="">-- Toutes les filières --</option>

                            @foreach($filiers as $f)
                                <option value="{{ $f->code_f }}"
                                    {{ request('filiere_id') == $f->code_f ? 'selected' : '' }}>
                                    {{ $f->nom_filiere_francais }}
                                </option>
                            @endforeach

                        </select>
                        {{-- Nb: <span class="badge bg-primary">{{ $nb }}</span> --}}
                    </div>

                    <div class="col-md-4">
                        <a href="{{ route('groupes.index') }}" class="btn btn-secondary w-100   ">
                            Reset
                        </a>
                    </div>

                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-head-bg-info table-bordered-bd-info">

                    <thead class="table-dark">
                        <tr>
                            <th>Code</th>
                            <th>Nom</th>
                            <th>Filière</th>
                            <th>Capacité</th>
                            <th width="180">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($groupes as $g)
                            <tr>
                                <td>{{ $g->code_g }}</td>
                                <td>{{ $g->nom_g }}</td>
                                <td>{{ $g->filiere->nom_filiere_francais ?? '' }}</td>
                                <td>{{ $g->capacite }}</td>
                                <td>
                                    <a href="{{ route('groupes.show', $g->code_g) }}"
                                       class="btn btn-info btn-sm">
                                        Show
                                    </a>
                                    <a href="{{ route('groupes.edit', $g->code_g) }}"
                                       class="btn btn-warning btn-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('groupes.destroy', $g->code_g) }}"
                                          method="POST"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Supprimer ce groupe ?')">
                                            Supp
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    Aucun groupe trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $groupes->links() }}
                </div>
            </div>
        
    
</div>

@endsection