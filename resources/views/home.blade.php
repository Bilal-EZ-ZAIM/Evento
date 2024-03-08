@extends('layaout.master')

@section('main')
    <style>
        .jumbotron {
            min-height: 50vh;
            /* Instead of fixed height, set minimum height for responsiveness */
        }
    </style>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md">
                <div class="jumbotron d-md-flex justify-content-between align-items-center">
                    <!-- Adjust flexbox settings for responsiveness -->
                    <div class="mr-auto">
                        <h1 class="display-4">Bienvenue sur Evento</h1>
                        <p class="lead">La plateforme pour découvrir, réserver et gérer des événements.</p>
                        <hr class="my-4">
                        <p>Cliquez ci-dessous pour explorer les événements à venir.</p>
                        <a class="btn btn-primary btn-lg" href="#" role="button">Explorer les événements</a>
                    </div>

                    @if (Auth::check())
                        <div class="col-md-4 mt-4 mt-md-0"> <!-- Adjust margin top for smaller devices -->
                            <div class="card">
                                <div class="card-header">
                                    Informations Utilisateur
                                </div>
                                <div class="card-body">
                                    <p>Nom d'utilisateur : {{ Auth::user()->username }}</p>
                                    <p>Email : {{ Auth::user()->email }}</p>
                                    <form action="{{ route('logOut') }}" method="GET">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Déconnexion</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
                    <!-- Adjust flexbox settings for responsiveness -->
                    <form class="form-inline mb-3 mb-md-0" action="{{ route('recherch') }}" method="GET">
                        <div class="input-group">
                            <input class="form-control" type="search" placeholder="Recherche par nom" aria-label="Search"
                                name="query">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Rechercher</button>
                            </div>
                        </div>
                    </form>

                    <form class="form-inline" action="{{ route('recherchCategory') }}" method="GET">
                        <div class="input-group">
                            <label for="category" class="input-group-text">Catégorie</label>
                            <select name="query" class="form-control" id="category">
                                @foreach ($category as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-success" type="submit">Rechercher</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="mt-5">
                    <h2 class="mb-4">Événements à venir</h2>
                    <div class="row">
                        <!-- Event Cards -->
                        @foreach ($evenement as $item)
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->titre }}</h5>
                                        <p class="card-text">{{ $item->description }}</p>
                                        <a href="{{ route('show', ['id' => $item->id]) }}" class="btn btn-primary">Détails
                                            de l'événement</a>
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
        </div>
    </div>
@endsection
