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
                    @if (Auth::check() && Auth::user()->roleId && Auth::user()->roleId->name === 'admin')
                        <button class="btn btn-primary" onclick="showSection('allEventsSection')">les Evenements ne pas
                            accepter</button>
                        <button class="btn btn-primary" onclick="showSection('allCategorySection')">Tous les Category</button>
                        <button class="btn btn-primary" onclick="showSection('allUserSection')">Tous les Utilisateure</button>
                        <button class="btn btn-primary" onclick="showSection('statisticsSection')">Statistiques</button>
                    @endif
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
                                                <a href="{{ route('accepter', ['id' => $row->id]) }}">
                                                    <button type="button" class=" btn btn-primary">
                                                        Accepter
                                                    </button></a>

                                                <form action="{{ route('delete', ['id' => $row->id]) }}" method="get">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">
                                                        Annuler
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
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalModifier{{ $row->id }}">
                                                    Modifier
                                                </button>

                                                <div class="modal fade" id="exampleModalModifier{{ $row->id }}"
                                                    tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                    <button type="submit"
                                                                        class="btn btn-secondary">Mettre à jour</button>
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

                <div id="allUserSection" class="content-section">
                    <div class="content">

                        @if (!empty($users))
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nom du Utileusateur</th>
                                        <th scope="col">Changer role</th>
                                    </tr>
                                </thead>
                                <tbody id="search-results">
                                    @foreach ($users as $index => $row)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $row->username }}</td>
                                            <td class="d-flex gap-3">
                                                <form action="{{ route('changerRoler', ['id' => $row->id]) }}"
                                                    method="get">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary">
                                                        Organisateur
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
