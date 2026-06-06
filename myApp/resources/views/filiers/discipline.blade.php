@extends('layout.app')

@section('content')



  <div class="p-4">
    <div class="container">
        <form class="row g-3 align-items-center" action="{{route('discipline.afficher')}}" method="get">
            
            
            <div class="col-sm-8">
                <label class="" for="selectInput">Choose the filier</label>
                <select name="filier" class="form-select" id="selectInput">
                    <option  value="all">All</option>
                    @foreach ($filiers as $filier)
                      <option  value="{{$filier->code_f}}">{{$filier->nom_filiere_francais}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-auto">
                

                <button type="submit" class="btn btn-primary mt-4">Afficher</button>
            </div>
            
        </form>
    </div>
  </div>
    

  
@endsection