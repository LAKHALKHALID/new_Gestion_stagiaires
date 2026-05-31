@extends('layout.app')

@section('content')
    <div class="container mt-5">
      @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
      @endif
      <a href="{{route('engagements.create')}}" class="btn btn-primary mb-3">Ajouter</a>
      <table class="table table-bordered table-head-bg-info table-bordered-bd-info">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Motif</th>
            <th scope="col">Date</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
              @foreach ($engagements as $item)
                  <tr>
                    <td>{{$item->stagiaire_id}}</td>
                    <td>{{$item->motif}}</td>
                    <td>{{$item->date}}</td>
                    <td class="d-flex gap-2">
                      <a href="{{route('engagements.edit',['id'=>$item->id])}}" class="btn btn-success btn-sm">Edit</a>
                      <form action="{{route('engagements.destroy',['id'=>$item->id])}}" method="POST">
                        @csrf
                        @method('delete')
                        <button 
                        onclick="return confirm('Are you sure you want to delete this stagiaire ?')"
                        class="btn btn-danger btn-sm">Supp</button>
                      </form>
                    </td>
                  </tr>
              @endforeach
        </tbody>
      </table>
    </div>
@endsection