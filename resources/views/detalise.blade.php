@extends('layaout.master')

@section('main')
    <div class="container mt-5">
        <div class="jumbotron">
            <h1 class="display-4">Détails de l'événement</h1>
            <p class="lead">Découvrez les détails de l'événement.</p>
            <hr class="my-4">
            <!-- Afficher les détails de l'événement ici -->
            <div class="card mb-4">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="..." style="height: 60vh;">
                <div class="card-body">
                    <h5 class="card-title">Titre: <strong>{{ $evenement->titre }}</strong></h5>
                    <p class="card-text">Description: <strong>{{ $evenement->description }}</strong></p>
                    <p class="card-text">Date: <strong>{{ $evenement->date }}</strong></p>
                    <p class="card-text">Pays: <strong>Maroc</strong></p>
                    <p class="card-text">Ville: <strong>{{ $evenement->ville->ville }}</strong></p>
                    <p class="card-text">Tickets: <strong>{{ $evenement->nombre_places }}</strong></p>
                    <p class="card-text">catecory: <strong>{{ $evenement->catecory->name }}</strong></p>
                    <p class="card-text">Prix de Tickets: <strong>{{ $evenement->prix }} DH</strong></p>
                    <a href="{{ route('ajouter', ['id' => $evenement->id]) }}" class="btn btn-primary">Ajouter au panier</a>
                </div>
            </div>
        </div>
    </div>

    <div id="allEventsSection" class="container content-section">
        <div class="content">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if (!empty($reservation))
                <h2>Tous les Reservation</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nom du user</th>
                            <th scope="col">Etat du reservation</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="search-results">
                        @foreach ($reservation as $index => $row)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $row->user->username }}</td>
                                <td>{{ $row->etat->type }}</td>
                                <td class="d-flex gap-3">
                                    <a href="{{ route('accepeter', ['id' => $row->evenemont_id]) }}">
                                        <button type="button" class=" btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">
                                            Accepter
                                        </button></a>

                                    <a href="{{ route('anniller', ['id' => $row->id]) }}">
                                        <button type="button" class=" btn btn-danger">
                                            Anuller
                                        </button></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>

    <!-- Ajouter les scripts JavaScript de Bootstrap (jQuery et Popper.js) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
