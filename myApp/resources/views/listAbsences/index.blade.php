@extends('layout.app')

{{-- @section('title', 'listAbsence') --}}

@section('content')


    <div class="container">
        <form action="{{ route('listAbsences.index') }}" method="get" class="my-4">
            <div class="row">
                <div class="col-md-5 d-flex gap-3">
                    <label for="">Groupe : </label>
                    <input type="text" name="groupe" value="{{ request('groupe') }}" class="form-control" required>
                </div>
                <div class="col-md-5 d-flex gap-3">
                    <label for="">Début de la semaine : </label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}" required>
                </div>
                <div class="col-md-2 d-flex justify-content-center align-items-center">
                    <input type="submit" value="Search" class="btn btn-success">
                </div>
            </div>
        </form>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="container-fluid mt-4">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle ">

                    <thead class="table-light">
                        <!-- ROW 1 -->
                        <tr>
                            <th rowspan="2" class="align-middle">Nom et prénom</th>

                            <th colspan="4" class="bg-primary text-white">Lundi</th>
                            <th colspan="4" class="bg-danger text-white">Mardi</th>
                            <th colspan="4" class="bg-warning">Mercredi</th>
                            <th colspan="4" class="bg-info text-white">Jeudi</th>
                            <th colspan="4" class="bg-success text-white">Vendredi</th>
                            <th colspan="4" class="bg-secondary text-white">Samedi</th>

                            <th rowspan="2" class="align-middle">CEF</th>
                        </tr>

                        <!-- ROW 2 -->
                        <tr>
                            <!-- repeat slots -->
                            <!-- Monday -->
                            <th>L</th>
                            <th>u</th>
                            <th>n</th>
                            <th>di</th>

                            <!-- Tuesday -->
                            <th>M</th>
                            <th>a</th>
                            <th>r</th>
                            <th>di</th>

                            <!-- Wednesday -->
                            <th>Me</th>
                            <th>rc</th>
                            <th>re</th>
                            <th>di</th>

                            <!-- Thursday -->
                            <th>Je</th>
                            <th>u</th>
                            <th>d</th>
                            <th>i</th>

                            <!-- Friday -->
                            <th>Ve</th>
                            <th>nd</th>
                            <th>re</th>
                            <th>di</th>

                            <!-- Saturday -->
                            <th>Sa</th>
                            <th>m</th>
                            <th>e</th>
                            <th>di</th>
                        </tr>
                    </thead>
                    @if ($stagiaires != '')

                        <form action="{{ route('listAbsences.store') }}" method="post">
                            @csrf
                            <tbody>
                                @foreach ($stagiaires as $stagiaire)
                                    @php
                                        $absencesByDate = [];

                                        foreach ($stagiaire->absences as $absence) {
                                            $seances = array_map('trim', explode(';', $absence->seance));

                                            foreach ($seances as $seance) {
                                                $absencesByDate[$absence->date][] = $seance;
                                            }
                                        }
                                    @endphp
                                    @php
                                        $fullName = $stagiaire->nom_francais . ' ' . $stagiaire->prenom_francais;
                                    @endphp
                                    <tr>
                                        <td class="text-start ">{{ strtoupper($fullName) }}</td>

                                        <!-- 24 cells -->
                                        {{-- 1 --}}
                                        @for ($i = 0; $i < 6; $i++)
                                            @php
                                                $date = $startOfWeek->copy()->addDays($i)->format('Y-m-d');
                                                $seances = $absencesByDate[$date] ?? [];
                                            @endphp
                                            <input type="hidden"
                                        name="all_dates[{{$stagiaire->cef}}][]"
                                        value="{{$date}}">

                                            <td><input type="checkbox" value="8h30-11h00" 
                                                    name="absences[{{ $stagiaire->cef }}][{{ $date }}][]"
                                                    {{ in_array('8h30-11h00', $seances) ? 'checked' : '' }}></td>
                                            <td><input type="checkbox" value="11h00-13h30"
                                                    name="absences[{{ $stagiaire->cef }}][{{ $date }}][]"
                                                    {{ in_array('11h00-13h30', $seances) ? 'checked' : '' }}></td>
                                            <td><input type="checkbox" value="13h30-16h00"
                                                    name="absences[{{ $stagiaire->cef }}][{{ $date }}][]"
                                                    {{ in_array('13h30-16h00', $seances) ? 'checked' : '' }}></td>
                                            <td>
                                                <input type="checkbox" value="16h00-18h30"
                                                    name="absences[{{ $stagiaire->cef }}][{{ $date }}][]"
                                                    {{ in_array('16h00-18h30', $seances) ? 'checked' : '' }}>
                                            </td>
                                        @endfor

                                        <td class="">{{ $stagiaire->cef }}</td>
                                    </tr>
                                    
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>

                                        <input type="submit" value="Save" class="btn btn-success">
                                    </td>
                                </tr>
                            </tfoot>
                            <input type="hidden" name="start_date" value="{{ request('date') }}">
                            <input type="hidden" name="group_name" value="{{ request('groupe') }}">
                        </form>

                    @endif


                </table>
            </div>
        </div>
    </div>

@endsection
