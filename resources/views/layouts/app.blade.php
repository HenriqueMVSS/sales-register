<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            --radius: 0.65rem;
            --background: oklch(1 0 0);
            --foreground: oklch(0.141 0.005 285.823);
            --card: oklch(1 0 0);
            --card-foreground: oklch(0.141 0.005 285.823);
            --popover: oklch(1 0 0);
            --popover-foreground: oklch(0.141 0.005 285.823);
            --primary: oklch(0.623 0.214 259.815);
            --primary-foreground: oklch(0.97 0.014 254.604);
            --secondary: oklch(0.967 0.001 286.375);
            --secondary-foreground: oklch(0.21 0.006 285.885);
            --muted: oklch(0.967 0.001 286.375);
            --muted-foreground: oklch(0.552 0.016 285.938);
            --accent: oklch(0.967 0.001 286.375);
            --accent-foreground: oklch(0.21 0.006 285.885);
            --destructive: oklch(0.577 0.245 27.325);
            --border: oklch(0.92 0.004 286.32);
            --input: oklch(0.92 0.004 286.32);
            --ring: oklch(0.623 0.214 259.815);
            --chart-1: oklch(0.646 0.222 41.116);
            --chart-2: oklch(0.6 0.118 184.704);
            --chart-3: oklch(0.398 0.07 227.392);
            --chart-4: oklch(0.828 0.189 84.429);
            --chart-5: oklch(0.769 0.188 70.08);
            --sidebar: oklch(0.985 0 0);
            --sidebar-foreground: oklch(0.141 0.005 285.823);
            --sidebar-primary: oklch(0.623 0.214 259.815);
            --sidebar-primary-foreground: oklch(0.97 0.014 254.604);
            --sidebar-accent: oklch(0.967 0.001 286.375);
            --sidebar-accent-foreground: oklch(0.21 0.006 285.885);
            --sidebar-border: oklch(0.92 0.004 286.32);
            --sidebar-ring: oklch(0.623 0.214 259.815);
        }

        .dark {
            --background: oklch(0.141 0.005 285.823);
            --foreground: oklch(0.985 0 0);
            --card: oklch(0.21 0.006 285.885);
            --card-foreground: oklch(0.985 0 0);
            --popover: oklch(0.21 0.006 285.885);
            --popover-foreground: oklch(0.985 0 0);
            --primary: oklch(0.546 0.245 262.881);
            --primary-foreground: oklch(0.379 0.146 265.522);
            --secondary: oklch(0.274 0.006 286.033);
            --secondary-foreground: oklch(0.985 0 0);
            --muted: oklch(0.274 0.006 286.033);
            --muted-foreground: oklch(0.705 0.015 286.067);
            --accent: oklch(0.274 0.006 286.033);
            --accent-foreground: oklch(0.985 0 0);
            --destructive: oklch(0.704 0.191 22.216);
            --border: oklch(1 0 0 / 10%);
            --input: oklch(1 0 0 / 15%);
            --ring: oklch(0.488 0.243 264.376);
            --chart-1: oklch(0.488 0.243 264.376);
            --chart-2: oklch(0.696 0.17 162.48);
            --chart-3: oklch(0.769 0.188 70.08);
            --chart-4: oklch(0.627 0.265 303.9);
            --chart-5: oklch(0.645 0.246 16.439);
            --sidebar: oklch(0.21 0.006 285.885);
            --sidebar-foreground: oklch(0.985 0 0);
            --sidebar-primary: oklch(0.546 0.245 262.881);
            --sidebar-primary-foreground: oklch(0.379 0.146 265.522);
            --sidebar-accent: oklch(0.274 0.006 286.033);
            --sidebar-accent-foreground: oklch(0.985 0 0);
            --sidebar-border: oklch(1 0 0 / 10%);
            --sidebar-ring: oklch(0.488 0.243 264.376);
        }

        body {
            background-color: var(--background);
            color: var(--foreground);
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--primary-foreground);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        .btn-secondary {
            background-color: var(--secondary);
            color: var(--secondary-foreground);
            border-color: var(--secondary);
        }

        .btn-danger {
            background-color: var(--destructive);
            color: white;
            border-color: var(--destructive);
        }

        .card {
            background-color: var(--card);
            color: var(--card-foreground);
            border-color: var(--border);
        }

        .form-control {
            background-color: var(--background);
            color: var(--foreground);
            border-color: var(--input);
        }

        .form-control:focus {
            border-color: var(--ring);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        }

        .navbar {
            background-color: var(--card);
            border-bottom: 1px solid var(--border);
        }

        .navbar-brand, .nav-link {
            color: var(--foreground) !important;
        }

        .table {
            background-color: var(--card);
            color: var(--card-foreground);
        }

        .table th {
            border-bottom: 2px solid var(--border);
        }

        .table td {
            border-top: 1px solid var(--border);
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    {{ config('app.name', 'Sistema de Vendas') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('sales.index') }}">Vendas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('customers.index') }}">Clientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">Produtos</a>
                        </li>
                    </ul>
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @if(session('success'))
                <div class="container">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="container">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
