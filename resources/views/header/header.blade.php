<div class="bg-dark">
    <nav class="container navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Evento</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
                    </li>

                    @if (Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('userProfile') }}">{{ Auth::user()?->username }} </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register </a>
                        </li>
                    @endif

                    @if (Auth::check() && Auth::user()->roleId && Auth::user()->roleId->name === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin') }}">Admin </a>
                        </li>
                    @endif

                    @if (Auth::check() && Auth::user()->roleId && Auth::user()->roleId->name === 'organisateur')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile') }}">{{ Auth::user()?->username }} </a>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
    </nav>
</div>
