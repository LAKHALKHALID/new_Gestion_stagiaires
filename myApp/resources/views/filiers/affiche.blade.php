@extends('layout.app')

@section('content')
    
    <style>
        table {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .header-table td {
            padding: 4px;
            vertical-align: top;
        }
        .title-box {
            border: 1px solid black;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            padding: 6px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        .data-table th, .data-table td {
            border: 1px solid black;
            padding: 5px;
        }
        .data-table th {
            text-align: center;
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .footer-section {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .footer-section td {
            border: 1px solid black;
            height: 120px;
            vertical-align: top;
            padding: 8px;
            width: 50%;
        }
        .date-container {
            text-align: right;
            margin-top: 15px;
            font-size: 12px;
        }

        .print-group-wrapper {
            page-break-after: always;
        }
        .print-group-wrapper:last-child {
            page-break-after: avoid;
        }

        /* --- STYLES TO ISOLATE PRINT SECTION --- */
        @media print {
            /* Hide absolute everything on the screen first */
            body *, html * {
                visibility: hidden;
            }
            
            /* Only target the custom print layout and make it visible */
            #printArea, #printArea * {
                visibility: visible;
            }
            
            /* Pin the target section right at the top left of the physical paper */
            #printArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                background-color: #ffffff !important;
                color: #000000 !important;
            }

            table, td, th, div, span, strong {
                color: #000000 !important;
            }

            .data-table th {
                background-color: #f2f2f2 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>

    <div class="container my-3 d-print-none">
        <button onclick="window.print();" class="btn btn-dark d-flex align-items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1"/>
            </svg>
            Print Sections (Afficher/Imprimer)
        </button>
    </div>

    <div id="printArea">
        @foreach ($filiers as $filier)
            @foreach ($filier->groupes as $groupe)
                
                <div class="print-group-wrapper">
                    
                    <table class="header-table">
                        <tr>
                            <td style="width: 60%;">
                                <strong>EFP :</strong> ISTA Al Adarissa Fès<br>
                                <strong>Filière :</strong> {{$filier->nom_filiere_francais}}<br>
                                <strong>Groupe :</strong> {{$groupe->nom_g}}<br>
                                <strong>Intitulé du module :</strong> Discipline
                            </td>
                            <td style="width: 40%;">
                                <div class="title-box">Procès Verbal d'Examen de Fin de Module</div>
                                <table style="width: 100%; border-collapse: collapse; margin-top: 5px;">
                                    <tr>
                                        <td style="border: 1px solid black; padding: 2px;">Présents :</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid black; padding: 2px;">Absents :</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width: 15%;">CEF</th>
                                <th style="width: 25%;">Nom</th>
                                <th style="width: 25%;">Prénom</th>
                                <th style="width: 11%;">Assiduité<br>/10</th>
                                <th style="width: 12%;">Comportement<br>/5</th>
                                <th style="width: 12%;">Discipline<br>/20</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groupe->stagiaires->sortBy('nom_francais') as $stagiaire)
                                @php
                                    $note_absence = $stagiaire->transactions->firstWhere('motif', 'a')->note ?? 0;
                                    $note_comportement = $stagiaire->transactions->firstWhere('motif', 'c')->note ?? 0;
                                @endphp
                                <tr>
                                    <td> {{$stagiaire->cef}} </td>
                                    <td>{{strtoupper($stagiaire->nom_francais)}}</td>
                                    <td>{{strtoupper($stagiaire->prenom_francais ?? $stagiaire->prenom)}}</td> 
                                    <td class="text-center">{{10 - $note_absence}}</td>
                                    <td class="text-center">{{5 - $note_comportement}}</td>
                                    <td class="text-center">{{number_format(((10-$note_absence)+(5-$note_comportement))*20/15,2)}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <table class="footer-section">
                        <tr>
                            <td class="text-center"><strong>Surveillance Générale</strong></td>
                            <td class="text-center"><strong>Directeur d'établissement</strong></td>
                        </tr>
                    </table>

                    <div class="date-container">
                        Fait à Fès le : {{date('d/m/Y')}}
                    </div>

                </div>
            @endforeach
        @endforeach
    </div>

@endsection