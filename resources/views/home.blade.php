@extends('layaout.master')

@section('main')
    <div class="container mt-5">
        <form action="{{ route('recherch') }}" method="GET" class="form-inline mx-auto mb-4">
            <div>
                <input type="text" name="query" class="form-control" placeholder="Rechercher par titre...">
                <br>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary input-group-text">Rechercher</button>
                </div>
            </div>
        </form>


        <div class="jumbotron">
            <h1 class="display-4">Bienvenue sur Evento</h1>
            <p class="lead">La plateforme pour découvrir, réserver et gérer des événements.</p>
            <hr class="my-4">
            <p>Cliquez ci-dessous pour explorer les événements à venir.</p>
            <a class="btn btn-primary btn-lg" href="#" role="button">Explorer les événements</a>
        </div>

        <div class="mt-5">
            <h2 class="mb-4">Événements à venir</h2>
            <div class="row">
                <!-- Carte d'événement 1 -->
                @foreach ($evenement as $item)
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="https://via.placeholder.com/300" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->titre }}</h5>
                                <p class="card-text">{{ $item->description }}</p>
                                <a href="{{ route('show', ['id' => $item->id]) }}" class="btn btn-primary">Détails de
                                    l'événement</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center">
                {{ $evenement->links() }}
            </div>
        </div>
    </div>

    <!-- Ajouter les scripts JavaScript de Bootstrap (jQuery et Popper.js) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
