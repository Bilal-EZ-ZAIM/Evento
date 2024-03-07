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
                    <button class="btn btn-primary" onclick="showSection('userInfoSection')">Profile</button>
                    <button class="btn btn-primary" onclick="showSection('allEventsSection')">Tous les Evenements</button>
                    <button class="btn btn-primary" onclick="showSection('allCategorySection')">Tous les
                        Category</button>
                    <button class="btn btn-primary" onclick="showSection('statisticsSection')">Statistiques</button>
                    <button class="btn btn-primary" onclick="showSection('ticketsSection')">Tickets</button>
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
                <div id="userInfoSection" class="content-section">
                    <div class="content">
                        <h2>Informations Utilisateur</h2>
                        <img class="image"
                            src="https://media.discordapp.net/attachments/1158803349248946218/1214230528040116284/image.png?ex=65f85b4d&is=65e5e64d&hm=c0d8b7271fd93b50c4d944b8cf7331dbea2452f17d46226d399ae2a8395247d1&=&format=webp&quality=lossless&width=565&height=565"
                            alt="">
                        <p> User name: <strong> {{ $user->username }} </strong> </p>
                        <p> Email: <strong> {{ $user->email }} </strong> </p>

                        <!-- Bouton de déconnexion -->
                        <form action="{{ route('logOut') }}" method="get">
                            @csrf
                            <button type="submit" class="btn btn-primary">Log Out</button>
                        </form>

                        <div class="d-flex justify-content-center">
                            <form action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <input type="file" class="form-control" id="photo" name="photo">
                                </div>
                                <button type="submit" class="btn btn-primary">Upload Photo</button>
                            </form>
                        </div>
                    </div>
                </div>



                <div id="allEventsSection" class="content-section">
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

            <div id="allCategorySection" class="content-section">
                <div class="content">
                    <div class="d-flex justify-content-between">
                        <h2>Tous les Categorie</h2>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">ajouter Categorie</button>
                    </div>
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter Categorie</h1>
                                </div>
                                <div class="modal-body">
                                    <form action={{ route('category') }} method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">Nom de
                                                Categorie</label>
                                            <input type="text" class="form-control" name="name"
                                                id="exampleFormControlInput1" placeholder="nom de categoru">
                                        </div>
                                        <button type="submit" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Ajouter</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (!empty($catecory))
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nom du Category</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="search-results">
                                @foreach ($catecory as $index => $row)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $row->name }}</td>
                                        <td class="d-flex gap-3">
                                            <button type="button" class="btn btn-primary ModifierCategory"
                                                data-bs-toggle="modal" data-bs-target="#exampleModalModifier">
                                                Modifier
                                            </button>

                                            <div class="modal fade" id="exampleModalModifier" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                Modifier Categorie</h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('update.category', ['id' => $row->id]) }}"
                                                                method="post">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlInput1"
                                                                        class="form-label">Nom de Categorie</label>
                                                                    <input type="text" class="form-control"
                                                                        name="name" id="exampleFormControlInput1"
                                                                        placeholder="Nom de categorie"
                                                                        value="{{ $row->name }}">
                                                                </div>
                                                                <button type="submit" class="btn btn-secondary">Mettre à
                                                                    jour</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <form action="{{ route('delete.category', ['id' => $row->id]) }}"
                                                method="get">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">
                                                    Supprimer
                                                </button>
                                            </form>
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
                    <h2>Statistiques</h2>
                    <!-- Contenu de la section Statistiques -->
                </div>
            </div>
            <div id="ticketsSection" class="content-section">
                <div class="content">
                    <h2>Tickets</h2>
                    <!-- Contenu de la section Tickets -->
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
