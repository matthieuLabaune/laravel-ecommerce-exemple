<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestion des Produits')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 20px;
        }

        .alert-fixed {
            position: fixed;
            top: 10px;
            right: 10px;
            width: 300px;
            z-index: 9999;
        }

    </style>
</head>
<body>
    <div class="container">
        <header class="mb-4">
            <h1 class="mb-3">@yield('header', 'Gestion des Produits')</h1>
            <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="productsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Produits
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="productsDropdown">
                                    <li><a class="dropdown-item" href="{{ route('products.index') }}">Liste des produits</a></li>
                                    <li><a class="dropdown-item" href="{{ route('products.create') }}">Ajouter un produit</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Catégories
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                                    <li><a class="dropdown-item" href="{{ route('categories.index') }}">Liste des catégories</a></li>
                                    <li><a class="dropdown-item" href="{{ route('categories.create') }}">Ajouter une catégorie</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

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

        <main>
            @yield('content')
        </main>

        <!-- Section pour le contenu supplémentaire (après le contenu principal) -->
        @yield('after-content')

        <footer class="mt-5 pt-3 text-muted border-top">
            <p>&copy; {{ date('Y') }} Gestion des Produits</p>
        </footer>
    </div>

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
</body>
</html>
