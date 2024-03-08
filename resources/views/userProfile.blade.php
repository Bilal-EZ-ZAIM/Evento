@extends('layaout.master')

@section('main')
    <style>
        body {
            background-color: #f8f9fa;
        }

        #sidebar {
            background: #000;
            padding: 20px;
            height: 100vh;
        }

        .btn-group-vertical .btn {
            background-color: #343a40;
            border-color: #343a40;
            margin-bottom: 10px;
        }

        .btn-group-vertical .btn:hover {
            background-color: #212529;
            border-color: #212529;
        }

        .content-section {
            display: none;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        .active-section {
            display: block;
        }

        .content h2 {
            color: #000;
        }

        .form-label,
        .form-control {
            color: #000;
        }

        .btn-primary {
            background-color: #000;
            border-color: #000;
        }

        .btn-primary:hover {
            background-color: #212529;
            border-color: #212529;
        }

        /* Utilisation de Flexbox pour le contenu */
        .container-fluid {
            display: flex;
            flex-direction: row;
        }

        #content {
            flex: 1;
            padding: 20px;
            margin-left: 20px;
            /* Espacement entre le sidebar et le contenu */
        }

        .image {
            width: 150px;
            height: 150px;
        }
    </style>
    </head>

    <body>
        <div class="container-fluid">
            <div id="sidebar">
                <div class="btn-group-vertical">
                    <button class="btn btn-primary" onclick="showSection('allEventsSection')">Tous les Resrvation</button>
                    <button class="btn btn-primary" onclick="showSection('ticketsSection')">Tickets</button>
                </div>
            </div>

            <div id="content">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif



                <div id="allEventsSection" class="content-section active-section">
                    <div class="content">
                        <h2>Tous les Réservation</h2>
                        @if (!empty($reservation))
                            <div class="card">
                                <div class="card-header">
                                    Informations de la réservation
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($reservation as $reserve)
                                            <div class="col-md-6">
                                                <div class="reservation-info">
                                                    <p><strong>Nom de l'événement :</strong> {{ $reserve->event->titre }}
                                                    </p>
                                                    <p><strong>Date de l'événement :</strong> {{ $reserve->event->date }}
                                                    </p>
                                                    <p><strong>Lieu :</strong> {{ $reserve->event->ville->ville }}</p>
                                                    <p><strong>Description :</strong> {{ $reserve->event->description }}
                                                    </p>
                                                    @if ($reserve->etat->type == 'en coure')
                                                        <p><strong>État :</strong> En cours</p>
                                                    @elseif($reserve->etat->type == 'accepter')
                                                        <p><strong>État :</strong> Accepté</p>
                                                    @endif
                                                </div>
                                                <hr>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-muted mt-3">Aucune réservation disponible.</p>
                        @endif
                    </div>
                </div>


                <div id="ticketsSection" class="content-section">
                    <div class="content">
                        <h2 class="mb-4">Tickets</h2>
                        <div class="row">
                            @foreach ($reservation as $ticket)
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5>Bienvenue, {{ auth()->user()->username }}</h5>
                                            <h6 class="card-title">{{ $ticket->event->titre }}</h6>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item" >{{ $ticket->event->titre }}</li>
                                            <li class="list-group-item">Date: {{ $ticket->event->date }}</li>
                                            <li class="list-group-item">Prix: {{ $ticket->event->prix }} DH</li>
                                        </ul>
                                        <div class="card-body">
                                            <a href="{{ route('download.ticket', ['ticketId' => $ticket->id]) }}"
                                                class="btn btn-primary">Télécharger</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


            </div>

        </div>



        <script>
            function showSection(sectionId) {
                let sections = document.getElementsByClassName('content-section');
                for (var i = 0; i < sections.length; i++) {
                    sections[i].classList.remove('active-section');
                }
                document.getElementById(sectionId).classList.add('active-section');
            }
        </script>
    @endsection
