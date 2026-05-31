@extends('layout.app')

@section('content')

<div class="container my-5">

    <form action="{{ route('comportements.store') }}" method="POST">

        @csrf
        {{-- @method('PUT') --}}

        {{-- MOTIF + CEF --}}
        <div class="row mb-4">

            <div class="col-md-6">

                <label class="mb-2">
                    Motif de la sanction
                </label>

                <select name="motif" class="form-select">

                    <option value="motif1"
                        {{ $comportement->motif == 'motif1' ? 'selected' : '' }}>
                        Motif 1
                    </option>

                    <option value="motif2"
                        {{ $comportement->motif == 'motif2' ? 'selected' : '' }}>
                        Motif 2
                    </option>

                    <option value="motif3"
                        {{ $comportement->motif == 'motif3' ? 'selected' : '' }}>
                        Motif 3
                    </option>

                </select>

            </div>

            <div class="col-md-6">

                <label class="mb-2">CEF</label>

                <input type="text"
                        name="cef"
                        readonly
                        class="form-control"
                        value="{{ $comportement->stagiaire_id }}">

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
                                id="mise"

                                {{ $comportement->sanction == 'Mise en garde' ? 'checked' : '' }}>

                        <label for="mise">
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
                                id="avertissement"

                                {{ $comportement->sanction == 'Avertissement' ? 'checked' : '' }}>

                        <label for="avertissement">
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
                               id="blame"

                               {{ $comportement->sanction == 'Blame' ? 'checked' : '' }}>

                        <label for="blame">
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
                               id="surveillance"

                               {{ $comportement->autorite_dec == 'Surveillance générale' ? 'checked' : '' }}>

                        <label for="surveillance">
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
                               id="directeur"

                               {{ $comportement->autorite_dec == 'Directeur' ? 'checked' : '' }}>

                        <label for="directeur">
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
                               id="conseil"

                               {{ $comportement->autorite_dec == 'Conseil de discipline' ? 'checked' : '' }}>

                        <label for="conseil">
                            Conseil de discipline
                        </label>

                    </div>

                </div>

            </div>

        </fieldset>

        {{-- MISE EN GARDE --}}
        <fieldset class="border p-3 mb-4">

            <legend class="float-none w-auto px-2">
                Mise en garde
            </legend>

            <div class="row">

                @php

                    $mises = [
                        '1ère Mise en garde',
                        '2ème Mise en garde',
                        '3ème Mise en garde',
                        '4ème Mise en garde',
                        '5ème Mise en garde'
                    ];

                @endphp

                @foreach ($mises as $mise)

                    <div class="col-md-3">

                        <div class="form-check">

                            <input type="radio"
                                    name="miseEnGarde"
                                    value="{{ $mise }}"
                                    class="form-check-input"

                                    {{ $comportement->miseEnGarde == $mise ? 'checked' : '' }}>

                            <label class="form-check-label">
                                {{ $mise }}
                            </label>

                        </div>

                    </div>

                @endforeach

            </div>

        </fieldset>

        {{-- DATE --}}
        <fieldset class="border p-3 mb-4">

            <legend class="float-none w-auto px-2">
                Date
            </legend>

            <input type="date"
                    name="date"
                    class="form-control"
                    value="{{ $comportement->date }}">

        </fieldset>

        <button class="btn btn-primary">
            Update
        </button>

    </form>

</div>

@endsection