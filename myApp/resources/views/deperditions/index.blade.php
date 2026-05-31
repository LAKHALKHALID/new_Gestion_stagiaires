@extends('layout.app')

{{-- @section('title','index') --}}
@php
use App\Models\Stagiaire;
@endphp
@section('content')
    <div class="container">
      @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
      <a href="{{route('deperditions.create')}}" class="btn btn-primary my-3">Ajouter</a href="">
      <div class="row my-3">
        <form action="{{ route('deperditions.index') }}" method="GET" class="d-flex align-items-end gap-2">

          <div class="col-md-8">

              <input 
                  type="text" 
                  name="cef"
                  class="form-control"
                  placeholder="Enter CEF"
                  value="{{ request('cef') }}"
              >
          </div>

          <div class="col-md-4">
              <button type="submit" class="btn btn-success w-100">
                  Search
              </button>
          </div>

      </form>
      </div>
        <table class="table table-bordered table-head-bg-info table-bordered-bd-info">
          <thead>
            <tr>
              <th>ID</th>
              <th>CEF</th>
              <th>Raison de déperdition</th>
              <th>Date de déperdition</th>
              <th>Raison de retour</th>
              <th>Date de retour</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            
            
            @foreach ($deperditions as $item)
            @php
              $stagiaire = Stagiaire::withTrashed()
                    ->where('cef', $item->stagiaire_id)
                    ->first();
                    // dd($stagiaire)
            @endphp
                <tr>
                  <td>{{$item->id}}</td>
                  <td>{{$item->stagiaire_id}}</td>
                  <td>{{$item->	raison_deperdition}}</td>
                  <td>{{$item->date_deperdition}}</td>
                  <td>{{$item->raison_retour  }}</td>
                  <td>{{$item->date_retour  }}</td>

                  <td>
                    <a href="{{route('deperditions.edit',['id'=>$item->id])}}" class="btn btn-success">Edit</a>
                  </td>


                </tr>
            @endforeach
          </tbody>
        </table>
    </div>
@endsection