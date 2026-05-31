
    @extends('layout.app')
    
    <style>
        body{
            background:#f5f5f5;
            font-family: "Times New Roman", serif;
        }

        .attestation-container{
            width: 850px;
            margin: 30px auto;
            background: white;
            padding: 40px 60px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .logo{
            width: 300px;
        }

        .title-box{
            border: 2px solid #000;
            padding: 12px;
            text-align: center;
            font-weight: bold;
            font-size: 22px;
            margin-top: 20px;
            margin-bottom: 40px;
        }

        .content p{
            font-size: 16px;
            line-height: 2;
        }

        .label{
            font-weight: bold;
        }

        .footer-sign{
            margin-top: 100px;
        }

        .signature{
            font-weight: bold;
            text-decoration: underline;
            font-size: 22px;
        }
         .sheet {
            background: white;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .title {
            text-align: center;
            font-weight: bold;
        }

        .subtitle {
            text-align: center;
            font-size: 14px;
        }

        table th, table td {
            font-size: 13px;
            text-align: center;
            vertical-align: middle;
        }

        .header-box {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 10px;
        }

        @media print{
            body{
                background: white;
            }

            .attestation-container{
                box-shadow: none;
                border: none;
            }
        }
    </style>

@section('content')

    @if ($stagiaires && $stagiaires != '')
        <div class="container">
          <div class="attestation-container">

              <!-- Logo -->
              <div class="text-center">
                  <img style="width: 100px" src="{{asset('images/OFPPT.png')}}" class="logo mb-2" alt="OFPPT Logo">

                  
              </div>

              <!-- Title -->
              <div class="title-box">
                  ATTESTATION DE POURSUITE DE FORMATION
              </div>

              <!-- Content -->
              <div class="content">

                  <p>
                      <span class="label">Réf :</span>
                      CFP/ISTA AD / {{$stagiaires->groupes[0]->nom_g}} /N°329 /2026
                  </p>

                  <p>
                      Je soussigné Directeur de l’établissement :
                      <strong>
                          INSTITUT SPECIALISE DE TECHNOLOGIE
                          APPLIQUEE HAY AL ADARISSA FES
                      </strong>
                  </p>

                  <p>
                      Atteste que le stagiaire :
                      <strong>{{strtoupper($stagiaires->nom_francais.' '.$stagiaires->prenom_francais)}}</strong>
                  </p>

                  <p>
                      <span class="label">Né le :</span>
                      {{$stagiaires->date_naissance}}
                      &nbsp;&nbsp;&nbsp;&nbsp;

                      <span class="label">à</span>
                      {{$stagiaires->lieu_naissance }}

                  </p>

                  <p>
                      <span class="label">Niveau de formation :</span>
                      {{$stagiaires->niveau_formation}}

                  </p>

                  <p>
                      <span class="label">Spécialité :</span>
                      {{$stagiaires->filieres[0]->nom_filiere_francais	}} 
                  </p>

                  <p>
                      <span class="label">En :</span>
                    {{$stagiaires->annee_etude}}

                  </p>

                  <div class="row">
                      <div class="col-md-6">
                          <p>
                              <span class="label">Type Formation :</span>
                              {{$stagiaires->type_formation}}

                          </p>
                      </div>

                      <div class="col-md-6">
                          <p>
                              <span class="label">Mode :</span>
                              {{$stagiaires->filieres[0]->mode_formation	}} 

                          </p>
                      </div>
                  </div>

                  <p>
                      <span class="label">N° d'inscription :</span>
                      {{$stagiaires->cef}}
                  </p>

                  <p>
                      <span class="label">Année de Formation :</span>
                      {{$stagiaires->annee_etude}}
                  </p>

                  <p>
                      - Poursuit sa formation à l’établissement depuis :
                      {{date('Y')}}
                  </p>

                  <br>

                  <p>
                      Cette attestation est délivrée à l’intéressé
                      pour servir et valoir ce que de droit.
                  </p>

                  <div class="text-end">
                      <p>
                          Fait à Fès le : {{date("d/m/Y")}}
                      </p>
                  </div>

                  <!-- Signatures -->
                  <div class="row footer-sign text-center">

                      <div class="col-md-6">
                          <p class="signature">
                              Signature et Cachet du <br>
                              Surveillant Général
                          </p>
                      </div>

                      <div class="col-md-6">
                          <p class="signature">
                              Signature et cachet <br>
                              du Directeur
                          </p>
                      </div>

                  </div>

              </div>

          </div>
        </div>
    @endif
        
    @if ($groupes && $groupes !='')
        <div class="container my-4 sheet">

            <!-- HEADER -->
            <div class="header-box">
                <h5 class="title">INSTITUT SPECIALISE DE TECHNOLOGIE APPLIQUEE</h5>
                <p class="subtitle">Année de Formation : {{$groupes->stagiaires[0]->nom_annee_scolaire}}</p>
                <p class="subtitle">PV de Présence - Contrôle Continu</p>
            </div>

            <!-- MODULE -->
            <div class="row mb-3">
                <div class="col-12">
                    <strong>Intitulé du Module :</strong> ....................................................
                </div>
            </div>

            <!-- INFO TABLE -->
            <table class="table table-bordered">
                <tr>
                    <th>Filière / Groupe</th>
                    <th>Epreuve</th>
                    <th>Date</th>
                    <th>Heure de démarrage</th>
                </tr>
                <tr>
                  <td>{{$groupes->nom_g}}</td>
                  <td>Théorique</td>
                  <td></td>
                  <td></td>
                </tr>
            </table>

            <!-- STUDENTS TABLE -->
            <table class="table table-bordered table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>N°</th>
                        <th>CEF</th>
                        <th>Nom et prénom</th>
                        <th>Emargement début</th>
                        <th>Emargement fin</th>
                        <th>Observation</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($groupes->stagiaires as $index => $stagiaire)
                        <tr>
                          <td>{{$index}}</td>
                          <td>{{$stagiaire->cef}}</td>
                          <td>{{strtoupper($stagiaire->nom_francais.' '.$stagiaire->nom_francais)}}</td>
                          <td></td>
                          <td></td>
                          <td></td>


                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="table text-center">
              <tr>
                <th>Matricule / CIN</th>
                <th>Nom et Prénom</th>
                <th>Emargement</th>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            </table>

        </div>
    @endif
    

@endsection


