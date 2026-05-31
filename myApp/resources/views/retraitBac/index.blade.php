@extends('layout.app')




@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">

                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>
            </div>
        @endif
        <a href="{{route('retraitBac.create')}}" class="btn btn-primary my-3">Ajouter</a>
        <form action="{{route('retraitBac.index')}}" method="GET" class="d-flex align-items-end gap-2">
            <div class="form-group">
                <label for="cef" class="form-label font-weight-bold">Code Stagiaire</label>
                <input 
                    type="text" 
                    id="cef" 
                    name="cef" 
                    placeholder="Ex: CEF001" 
                    value="{{ request('cef') }}"
                    class="form-control"
                >
            </div>

            <button type="submit" class="btn btn-success m-2">
                Search
            </button>
        </form>
        <table class="table table-hover text-center table-bordered table-head-bg-info table-bordered-bd-info">
            <thead>
            <tr>
                {{-- <th>Nom & Prenom</th> --}}
                <th>CEF</th>
                <th>CNE</th>
                <th>Piece Justificative</th>
                <th>Motife</th>
                <th>type de retraite</th>
                <th>date retrait</th>
                <th>date retour</th>
                <th>is_return</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($retraitBacs as $item)
                {{-- class="{{ $item->type_retrait == 'Retrait Définitif' ? 'table-danger' : 'table-warning' }}" --}}
                    <tr class="{{$item->is_returned ?'table-success' : 'table-danger'}}" >
                    {{-- <td>{{ strtoupper($item->stagiaire->nom_francais.' '.$item->stagiaire->prenom_francais) }}</td> --}}
                    <td>{{$item->stagiaire_id}}</td>
                    <td>{{$item->cne}}</td>
                    <td>{{$item->piece_justification}}</td>
                    <td>{{$item->motif}}</td>
                    <td>{{$item->type_retrait}}</td>
                    <td>{{$item->date_retrait}}</td>
                    <td>{{$item->date_retour}}</td>
                    <td>
                        
                            {{$item->is_returned  ? 'Yes' : 'No'}}
                        
                    </td>
                    <td class="">
                        <a href="{{route('retraitBac.edit',['id'=>$item->id])}}" class="btn btn-success">Edit</a>
                        
                        

                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Listen to changes on the checkbox, specifically working with the bootstrap-toggle plugin
    $('.toggle-form input[type="checkbox"]').change(function(e) {
        let checkbox = $(this);
        let form = checkbox.closest('form');

        // Show confirmation popup
        if (confirm('Are you sure this Stagiaire returned the Bac?')) {
            // If they clicked OK, manually submit this specific form
            form.submit();
        } else {
            // If they canceled, reset the visual switch state without re-triggering this event
            e.preventDefault();
            checkbox.bootstrapToggle('toggle', true); 
        }
    });
});
</script>
@endsection