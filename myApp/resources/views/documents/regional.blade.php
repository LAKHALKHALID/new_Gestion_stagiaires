


@extends('layout.app')

@section('content')

    <style>
        /* Base page look for web viewing */
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            background-color: #f4f5f7;
            margin: 0;
            color: #000000;
        }

        .pv-container {
            background-color: #ffffff;
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 35px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Top Institutional Header Elements */
        .header-section {
            text-align: center;
            margin-bottom: 25px;
            position: relative;
        }

        .logo-placeholder {
            font-size: 0.85rem;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .institute-name {
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .academic-year {
            font-size: 0.95rem;
            margin-bottom: 4px;
        }

        .pv-title {
            font-size: 1.05rem;
            font-weight: bold;
            margin-top: 10px;
        }

        /* Module Metadata Field */
        .module-field {
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .dots-line {
            font-weight: normal;
            letter-spacing: 1.5px;
            color: #555555;
        }

        /* General Table Framework Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #000000;
            padding: 0px 8px;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background-color: #fcfcfc;
            font-weight: bold;
            text-align: center;
        }

        /* Specific Metadata Top Table Config */
        .meta-table th {
            width: 25%;
        }
        .meta-table td {
            height: 24px;
            text-align: center;
        }

        /* Main Trainee List Table Layout Column Sizes */
        .students-table th {
            /* padding: 10px 5px; */
        }

        .col-id { width: 4%; text-align: center; }
        .col-cef { width: 14%; text-align: center; }
        .col-name { width: 32%; }
        .col-sign1 { width: 20%; }
        .col-sign2 { width: 18%; }
        .col-obs { width: 12%; }

        .center-text {
            text-align: center;
        }

        /* Bottom Footer / Examiner Meta Fields */
        .examiner-table th {
            padding: 6px;
        }
        .examiner-table td {
            height: 30px; 
        }

        .footer-copies-count {
            font-size: 1rem;
            font-weight: bold;
            margin-top: 25px;
        }

        /* Native Paper Optimization Rules */
        @media print {
            body {
                background-color: #ffffff;
                padding: 0;
                margin: 0;
            }
            .pv-container {
                box-shadow: none;
                padding: 15px 20px;
                max-width: 100%;
            }
            th {
                background-color: #ffffff !important;
            }
        }
    </style>

<button onclick="printDiv('printSection')" class="btn btn-primary my-3">
    <i class="bi bi-printer"></i> Print PV Sheet
</button>

<div class="pv-container" id="printSection">

    <div class="header-section">
        <div class="institute-name">INSTITUT SPECIALISE DE TECHNOLOGIE APPLIQUEE HAY AL ADARISSA FES</div>
        <div class="academic-year">PV de Présence d'Examen Régional  {{(date('Y')-1).'/'.date('Y')}}</div>
        
    </div>

    <div class="module-field">
        Intitulé du Module : ........................................................................................................................
    </div>

    <table class="meta-table">
        <thead>
            <tr>
                <th>Filière / Groupe</th>
                <th>Synthese</th>
                <th>Salle</th>
                <th>Date</th>
                <th>Heure de démarrage</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-weight: bold;">{{$groupe->nom_g}}</td>
                <td>Théorique</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <table class="students-table">
        <thead>
            <tr>
                <th class="col-id">N°</th>
                <th class="col-cef">CEF</th>
                <th class="col-name">Nom et prénom</th>
                <th class="col-sign1">Emargement au démarrage de l'épreuve</th>
                <th class="col-sign2">Emargement à la fin de l'épreuve</th>
                <th class="col-obs">Variante</th>
                <th class="col-obs">Observation</th>
            </tr>
        </thead>
          @php
                  $stagiaires = $groupe->stagiaires->sortBy('nom_francais');
          @endphp
        <tbody>
            @foreach ($stagiaires as $stagiaire)
            @php
                $fullName = $stagiaire->nom_francais.' '.$stagiaire->prenom_francais;
            @endphp
                <tr>
                    <td class="center-text">{{ $loop->iteration }}</td>
                    <td class="center-text">{{$stagiaire->cef}}</td>
                    <td> {{strtoupper($fullName)}} </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
            
        </tbody>
    </table>

    <table class="examiner-table">
        <thead>
            <tr>
                <th style="width: 25%;">Matricule / CIN</th>
                <th style="width: 50%;">Nom et Prénom</th>
                <th style="width: 25%;">Emargement</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div class="footer-copies-count">
        Nombre de copies : <span class="dots-line">...................................................</span>
    </div>

</div>

<script>
function printDiv(divId) {
    const printContents = document.getElementById(divId).innerHTML;
    const iframe = document.createElement('iframe');
    
    // Hide iframe securely from display layouts
    iframe.style.position = 'absolute';
    iframe.style.width = '0px';
    iframe.style.height = '0px';
    iframe.style.border = 'none';
    
    document.body.appendChild(iframe);
    
    const doc = iframe.contentWindow.document;
    
    doc.open();
    doc.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Print PV Sheet</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 30px; color: #000; }
                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 12px; }
                th, td { border: 1px solid #000; padding: 7px 8px; text-align: left; vertical-align: middle; }
                th { background-color: #fcfcfc; font-weight: bold; text-align: center; }
                .center-text { text-align: center; }
                .header-section { text-align: center; margin-bottom: 25px; }
                .institute-name { font-weight: bold; font-size: 14px; }
                .academic-year { font-size: 13px; margin-bottom: 4px; }
                .pv-title { font-weight: bold; margin-top: 10px; font-size: 15px; }
                .module-field, .footer-copies-count { font-weight: bold; margin-top: 15px; }
                .examiner-table td { height: 75px; }
                
                /* Layout structural widths */
                .col-id { width: 4%; }
                .col-cef { width: 14%; }
                .col-name { width: 32%; }
                .col-sign1 { width: 20%; }
                .col-sign2 { width: 18%; }
                .col-obs { width: 12%; }
                @media print { th { background-color: #fff !important; } }
            </style>
        </head>
        <body>
            <div class="pv-container">
                ${printContents}
            </div>
        </body>
        </html>
    `);
    doc.close();
    
    // Slight pause to ensure styling elements render safely inside the frame context
    setTimeout(() => {
        iframe.contentWindow.focus();
        iframe.contentWindow.print();
        document.body.removeChild(iframe);
    }, 400);
}
</script>

@endsection