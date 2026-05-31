@extends('layout.app')

@section('content')

<div class="container mt-4">

    @if (session('error'))

        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif

    <div class="card shadow">

        <div class="card-header">
            <h4>Edit Engagement</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('engagements.update',$engagement->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                {{-- Stagiaire --}}
                <div class="mb-3">

                    <label class="form-label">
                        Stagiaire
                    </label>

                    <input
                        type="text"
                        name="stagiaire_id"
                        class="form-control"
                        value="{{ $engagement->stagiaire_id }}"
                    >

                </div>

                {{-- Motif --}}
                <div class="mb-3">

                    <label class="form-label">
                        Motif
                    </label>

                    <select name="motif" class="form-select">

                        <option value="">
                            -- Select Motif --
                        </option>

                        <option value="Absence"
                            {{ $engagement->motif == 'Absence' ? 'selected' : '' }}>
                            Absence
                        </option>

                        <option value="Retrais Bac"
                            {{ $engagement->motif == 'Retrais Bac' ? 'selected' : '' }}>
                            Retrais Bac
                        </option>

                        <option value="Comportement"
                            {{ $engagement->motif == 'Comportement' ? 'selected' : '' }}>
                            Comportement
                        </option>

                    </select>

                </div>

                {{-- Date --}}
                <div class="mb-3">

                    <label class="form-label">
                        Date
                    </label>

                    <input
                        type="date"
                        name="date"
                        class="form-control"
                        value="{{ $engagement->date }}"
                    >

                </div>

                <button type="submit"
                        class="btn btn-primary">

                    Update

                </button>

            </form>

        </div>

    </div>

</div>

@endsection