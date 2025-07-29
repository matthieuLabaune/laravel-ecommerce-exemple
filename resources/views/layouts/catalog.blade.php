<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Commerce Laravel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .alert-fixed {
            position: fixed;
            top: 10px;
            right: 10px;
            width: 300px;
            z-index: 9999;
        }

        .product-card {
            height: 100%;
            transition: transform 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .cart-badge {
            position: relative;
            top: -8px;
            right: 5px;
        }

        .btn-add-to-cart {
            width: 100%;
        }

    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="{{ route('catalog.index') }}">E-Commerce Laravel</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('catalog.index') }}">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('catalog.products') }}">Produits</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Catégories
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                                @foreach(\App\Models\Category::where('active', true)->get() as $category)
                                <li><a class="dropdown-item" href="{{ route('catalog.category', $category) }}">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex me-2" action="{{ route('catalog.search') }}" method="GET">
                        <div class="input-group">
                            <input class="form-control" type="search" name="q" placeholder="Rechercher..." aria-label="Search" value="{{ request('q') ?? '' }}">
                            <button class="btn btn-light" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                    <div class="d-flex">
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-light position-relative me-2">
                            <i class="bi bi-cart3"></i>
                            @if(session()->has('cart') && count(session('cart')) > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-badge">
                                {{ count(session('cart')) }}
                            </span>
                            @endif
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">
                            <i class="bi bi-gear"></i> Admin
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-4">
        @if(session('success'))
        <div class="alert alert-success alert-fixed alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-fixed alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>E-Commerce Laravel</h5>
                    <p>Une application d'exemple pour démontrer les fonctionnalités de Laravel.</p>
                </div>
                <div class="col-md-4">
                    <h5>Liens utiles</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('catalog.index') }}" class="text-white">Accueil</a></li>
                        <li><a href="{{ route('catalog.products') }}" class="text-white">Produits</a></li>
                        <li><a href="{{ route('cart.index') }}" class="text-white">Panier</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <address>
                        <p><i class="bi bi-envelope"></i> info@example.com</p>
                        <p><i class="bi bi-telephone"></i> +33 123 456 789</p>
                    </address>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p>&copy; {{ date('Y') }} E-Commerce Laravel. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                let alerts = document.querySelectorAll('.alert-fixed');
                alerts.forEach(function(alert) {
                    let bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });

    </script>
    @yield('scripts')
</body>
</html>
