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
                    <button class="btn btn-primary" onclick="showSection('addEventSection')">Ajouter Evenement</button>
                    <button class="btn btn-primary" onclick="showSection('allEventsSection')">Tous les Evenements</button>
                    <button class="btn btn-primary" onclick="showSection('statisticsSection')">Statistiques</button>
                </div>
            </div>

            <div id="content">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div id="addEventSection" class="content-section active-section">
                    <div class="content">
                        <h2>Ajouter Evenement</h2>

                        <form action={{ route('evenement') }} method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Titer</label>
                                <input type="text" class="form-control" name="titre" id="exampleFormControlInput1"
                                    placeholder="titre">
                                @error('titre')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" name="date" id="date">
                            </div>
                            <div class="mb-3">
                                <label for="ville" class="form-label">Ville</label>
                                <select class="form-control" name="ville" id="ville">
                                    @foreach ($ville as $item)
                                        <option value=" {{ $item->id }} ">{{ $item->ville }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="catecory" class="form-label">Catecory</label>
                                <select name="categorie_id" class="form-control" id="catecory">
                                    @foreach ($catecory as $item)
                                        <option value=" {{ $item->id }} ">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="places" class="form-label">Nombre Places</label>
                                <input type="number" class="form-control" name="nombre_places" id="places"
                                    placeholder="Nombre Places">
                            </div>
                            <div class="mb-3">
                                <label for="places" class="form-label">prix</label>
                                <input type="number" class="form-control" name="prix" id="places"
                                    placeholder="Nombre Places">
                            </div>
                            <div class="mb-3">
                                <label for="ville" class="form-label">Aceppter le resrvation automatique </label>
                                <select class="form-control" name="auto" id="ville">

                                    <option value="1"> Oui </option>

                                    <option value="0"> Non </option>

                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
               

                <div id="allEventsSection" class="content-section">
                    <div class="content">
                        <h2>Tous les Evenements</h2>
                        @if (!empty($evenement))
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nom du Evenement</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="search-results">
                                    @foreach ($evenement as $index => $row)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $row->titre }}</td>
                                            <td class="d-flex gap-3">
                                                <a href="{{ route('updite', ['id' => $row->id]) }}">
                                                    <button type="button" class=" btn btn-primary ModifierCategory"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                        Modifier
                                                    </button></a>

                                                <form action="{{ route('delete', ['id' => $row->id]) }}" method="get">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger suppremerCategory"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                        Supprimer
                                                    </button>
                                                </form>


                                                <a href="{{ route('shows', ['id' => $row->id]) }}"><button
                                                        class="btn btn-primary">Detaie</button></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                    </div>

                </div>
                <div id="statisticsSection" class="content-section">
                    <div class="content">
                        <h2 class="text-center mb-4">Statistiques des événements</h2>
                       
                        @foreach ($evenement as $event)
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h3 class="card-title">{{ $event['titre'] }}</h3>
                                    <p class="card-text"><strong>Nombre de places disponibles:</strong>
                                        {{ $event['nombre_places'] }}</p>
                                    <p class="card-text"><strong>Accepté:</strong>
                                        {{ $event['accepter'] ? 'Oui' : 'Non' }}</p>
                                    <p class="card-text"><strong>Nombre de réservations:</strong>
                                        {{ $event['reservation_count'] }}</p>
                                    @if (!empty($event['reservation']))
                                        <h5 class="card-subtitle mb-2 text-muted">Informations sur la réservation:</h5>
                                        <ul class="list-group">
                                            @foreach ($event['reservation'] as $reservation)
                                                <li class="list-group-item">
                                                    <strong>Nom d'utilisateur:</strong>
                                                    {{ $reservation['user']['username'] }}
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>Email:</strong> {{ $reservation['user']['email'] }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="card-text text-muted">Aucune réservation pour le moment.</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
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
