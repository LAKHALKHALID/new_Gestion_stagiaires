@extends('layout.app')


{{-- @section('title','inscription') --}}


@section('content')
    <div class="container my-5">
        @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif
        @if (session('refuse'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('refuse') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif 
        <a href="{{route('toImport.inscription')}}" class="btn btn-primary ms-3 mb-4">Import</a>
        <form action="{{route('inscription.store')}}" method="post" class="mb-3">
          @csrf
            <div class="row g-3 align-items-end">

                <!-- Code Stagiaire -->
                <div class="col-md-3">
                    <label class="form-label">Code Stagiaire</label>
                    <input type="text" name="cef" class="form-control" placeholder="Enter CEF">
                </div>

                <!-- Filiere -->
                <div class="col-md-3">
                    <label class="form-label">Filière</label>
                    <select class="form-select" name="code_f">
                      @foreach ($f as $item)
                          <option value="{{$item->code_f}}">{{$item->nom_filiere_francais}}</option>
                      @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Groupe</label>
                    <select class="form-select" name="code_g">
                      @foreach ($g as $item)
                          <option value="{{$item->code_g}}">{{$item->nom_g}}</option>
                      @endforeach
                    </select>
                </div>

                <!-- Button -->
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">
                        Ajouter
                    </button>
                </div>

            </div>
        </form>
      </div>
@endsection