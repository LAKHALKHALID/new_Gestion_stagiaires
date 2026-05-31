@extends('layout.app')

@section('content')

    <div class="container">
      <h1 class="text-center">Gestion des stagiaires</h1>
            @if (session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ session('success') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif
             @if (session('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ session('error') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif
      <a href="{{route('stagiaires.create')}}" class="btn btn-primary">Ajouter New Stagiaire</a>
      <a href="{{route('import.stagiaires')}}" class="btn btn-primary ms-3">Import</a>

      <div class="container my-5">
        <form action="{{route('stagiaires.index')}}" method="GET" class="mb-3">
            <div class="row g-3 align-items-end">

                <!-- Code Stagiaire -->
                <div class="col-md-3">
                    <label class="form-label">Code Stagiaire</label>
                    <input type="text" name="cef" class="form-control" placeholder="Enter CEF">
                </div>

                <!-- Filiere -->
                

                <div class="col-md-4">
                    <label class="form-label">Groupe</label>
                    {{-- <input type="text" name="code_f" class="form-control" placeholder="Enter Groupe"> --}}
                    <select class="form-control" name="code_g">
                      <option value="" selected>All</option>
                      @foreach ($g as $item)
                          <option value="{{$item->code_g}}">{{$item->nom_g}}</option>
                      @endforeach
                    </select>
                </div>

                <!-- Button -->
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100 ">
                        Search
                    </button>
                </div>

            </div>
        </form>
      </div>
      <table class="table table-hover table-bordered table-head-bg-info table-bordered-bd-info text-center">
        <thead>
          <tr>
            <th>Cef</th>
            <th>CIN</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Annee Etude</th>
            <th>Annee Scolaire</th>
            <th>Niveau</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($stagiaires as $st)
              <tr>
                <td>{{$st->cef}}</td>
                <td>{{$st->cin}}</td>
                <td>{{$st->nom_francais}}</td>
                <td>{{$st->prenom_francais}}</td>
                <td>{{$st->annee_etude}}</td>
                <td>{{$st->nom_annee_scolaire}}</td>
                <td>{{$st->niveau_formation}}</td>
                <td class="d-flex gap-1">

                  
                  <a href="{{route('stagiaires.show',['cef'=>$st->cef])}}" class="btn btn-sm btn-primary">show</a>
                  <a href="{{route('stagiaires.edit',['cef'=>$st->cef])}}" class="btn btn-sm btn-success mx-2">edit</a>
                  
                  <form action="{{route('stagiaires.destroy',['cef'=>$st->cef])}}" method="POST">
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this stagiaire?')">Supp</button>
                  </form>


                </td>

              </tr>
          @endforeach
        </tbody>
      </table>
      <div class="mt-3">
          {{ $stagiaires->links() }}
      </div>
    </div>

@endsection