<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Hablame!')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* ajustes rápidos */
        .card-grid img {
            height: 160px;
            object-fit: cover;
            width: 100%;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Hablame!</a>
            <form class="d-flex ms-auto" method="GET" action="{{ route('home') }}">
                <input class="form-control me-2" type="search" placeholder="Buscar..." name="q"
                    value="{{ request('q') }}">
                <select name="category" class="form-select me-2" style="width:auto;">
                    <option value="">Todas</option>
                    @foreach (\App\Models\Category::all() as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-outline-primary">Buscar</button>
            </form>
            <ul class="navbar-nav ms-3">
                @auth
                    <li class="nav-item"><a href="/admin" class="nav-link">Admin</a></li>
                    <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sair</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Entrar</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <div class="container py-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
