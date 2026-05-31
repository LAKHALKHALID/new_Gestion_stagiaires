@extends('layout.app')

@section('content')
    @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
  <form action="{{ route('import.inscription') }}" class="mt-5" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
      <div class="col-md-8 mt-2">
          <input type="file" name="file" class="form-control" required>
      </div>
      <div class="col-md-4">
        <button type="submit" class="btn btn-primary mt-2">
            Import
        </button>
      </div>

    </div>
    

    
</form>

@endsection