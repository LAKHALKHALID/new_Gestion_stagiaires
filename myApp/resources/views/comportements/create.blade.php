

@extends('layout.app')

@section('content')

<div class="container my-5">
  @if (session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif
    <form action="{{ route('comportements.store') }}" method="POST">
        @csrf

        {{-- MOTIF + CEF --}}
        <div class="row mb-4">

            <div class="col-md-6">
                <label class="mb-2">Motif de la sanction</label>

                <select name="motif" class="form-select">
                    <option value="motif1">Motif 1</option>
                    <option value="motif2">Motif 2</option>
                    <option value="motif3">Motif 3</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="mb-2">CEF</label>

                <input type="text"
                       name="cef"
                       class="form-control"
                       placeholder="Enter CEF">
            </div>

        </div>

        {{-- SANCTION --}}
        <fieldset class="border p-3 mb-4">

            <legend class="float-none w-auto px-2">
                Sanction
            </legend>

            <div class="row">

                <div class="col-md-4">

                    <div class="form-check">

                        <input type="radio"
                               name="sanction"
                               value="Mise en garde"
                               class="form-check-input sanction"
                               id="mise">

                        <label for="mise" class="form-check-label">
                            Mise en garde
                        </label>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="form-check">

                        <input type="radio"
                               name="sanction"
                               value="Avertissement"
                               class="form-check-input sanction"
                               id="avertissement">

                        <label for="avertissement" class="form-check-label">
                            Avertissement
                        </label>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="form-check">

                        <input type="radio"
                               name="sanction"
                               value="Blame"
                               class="form-check-input sanction"
                               id="blame">

                        <label for="blame" class="form-check-label">
                            Blame
                        </label>

                    </div>

                </div>

            </div>

        </fieldset>

        {{-- AUTORITE --}}
        <fieldset class="border p-3 mb-4">

            <legend class="float-none w-auto px-2">
                Autorité de décision
            </legend>

            <div class="row">

                <div class="col-md-4">

                    <div class="form-check">

                        <input type="radio"
                               name="autorite_dec"
                               value="Surveillance générale"
                               class="form-check-input"
                               id="surveillance">

                        <label for="surveillance" class="form-check-label">
                            Surveillance générale
                        </label>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="form-check">

                        <input type="radio"
                               name="autorite_dec"
                               value="Directeur"
                               class="form-check-input"
                               id="directeur">

                        <label for="directeur" class="form-check-label">
                            Directeur
                        </label>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="form-check">

                        <input type="radio"
                               name="autorite_dec"
                               value="Conseil de discipline"
                               class="form-check-input"
                               id="conseil">

                        <label for="conseil" class="form-check-label">
                            Conseil de discipline
                        </label>

                    </div>

                </div>

            </div>

        </fieldset>

        {{-- MISE EN GARDE --}}
        <fieldset class="border p-3 mb-4"
                  id="miseContainer"
                  style="display: none;">

            <legend class="float-none w-auto px-2">
                Mise en garde
            </legend>

            <div class="row" id="miseContent">

            </div>

        </fieldset>

        {{-- DATE --}}
        <fieldset class="border p-3 mb-4">

            <legend class="float-none w-auto px-2">
                Date
            </legend>

            <input type="date"
                   name="date"
                   required
                   class="form-control">
                  
        </fieldset>

        <button class="btn btn-primary">
            Ajouter
        </button>

    </form>

</div>

<script>

    // sanctions
    const sanctions = document.querySelectorAll('.sanction');

    // autorité
    const surveillance = document.getElementById('surveillance');
    const directeur = document.getElementById('directeur');
    const conseil = document.getElementById('conseil');

    // mise en garde container
    const miseContainer = document.getElementById('miseContainer');
    const miseContent = document.getElementById('miseContent');

    // function to display options
    function afficherMise(options)
    {
        miseContainer.style.display = 'block';

        let html = '';

        options.forEach(function(option, index){

            html += `
                <div class="col-md-3">

                    <div class="form-check">

                        <input type="radio"
                               name="miseEnGarde"
                               value="${option}"
                               class="form-check-input"
                               id="mise${index}">

                        <label for="mise${index}"
                               class="form-check-label">

                            ${option}

                        </label>

                    </div>

                </div>
            `;
        });

        miseContent.innerHTML = html;
    }

    // loop sanctions
    sanctions.forEach(function(sanction){

        sanction.addEventListener('change', function(){

            // reset
            miseContainer.style.display = 'none';
            miseContent.innerHTML = '';

            // Mise en garde
            if(this.value === 'Mise en garde')
            {
                surveillance.checked = true;

                afficherMise([
                    '1ère Mise en garde',
                    '2ème Mise en garde'
                ]);
            }

            // Avertissement
            else if(this.value === 'Avertissement')
            {
                directeur.checked = true;

                afficherMise([
                    '3ème Mise en garde',
                    '4ème Mise en garde'
                ]);
            }

            // Blame
            else if(this.value === 'Blame')
            {
                conseil.checked = true;

                afficherMise([
                    '5ème Mise en garde'
                ]);
            }

        });

    });

</script>

@endsection

