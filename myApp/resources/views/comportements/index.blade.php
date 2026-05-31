@extends('layout.app')

{{-- @section('title','index') --}}
    
@section('content')
    <div class="container">
      @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif
      <a href="{{route('comportements.create')}}" class="btn btn-primary my-3">Ajouter</a>
      <table  class="table table-bordered table-head-bg-info table-bordered-bd-info">
        <thead>
          <tr>
            <th>Full Name</th>
            <th>cef</th>
            <th>Sanction</th>
            <th>Autorité de décision</th>
            <th>Mise en Garde</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          {{-- @foreach ($comp as $c)
            @php($fullName =$c->stagiaire->nom_francais.' '.$c->stagiaire->prenom_francais )
              <tr>
                <td>{{strtoupper($fullName)}}</td>
                <td>{{$c->stagiaire->cef}}</td>
                <td>{{$c->sanction}}</td>
                <td>{{$c->autorite_dec}}</td>
                <td>{{$c->miseEnGarde}}</td>
                <td>{{$c->created_at}}</td>
                <td>
                  <a href="{{route('comportements.edit',['id'=>$c->id])}}" class="btn btn-success btn-sm">Edit</a>
                </td>

              </tr>
          @endforeach --}}

          @foreach ($comp as $c)
              
                
                  @php($fullName = $c->stagiaire ? $c->stagiaire->nom_francais . ' ' . $c->stagiaire->prenom_francais : 'Stagiaire Inconnu')
              
              <tr>
                <td>{{ strtoupper($fullName) }}</td>
                <td>{{ $c->stagiaire?->cef ?? 'N/A' }}</td> 
                <td>{{ $c->sanction }}</td>
                <td>{{ $c->autorite_dec }}</td>
                <td>{{ $c->miseEnGarde }}</td>
                <td>{{ $c->created_at }}</td>
                <td>
                  <a href="{{ route('comportements.edit', ['id' => $c->id]) }}" class="btn btn-success btn-sm">Edit</a>
                </td>
              </tr>
            @endforeach
        </tbody>
      </table>
    </div>
@endsection