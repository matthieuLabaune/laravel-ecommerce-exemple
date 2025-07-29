@extends('layouts.catalog')

@section('title', 'Accueil - E-Commerce Laravel')

@section('content')
<div class="jumbotron bg-light p-5 rounded mb-4">
    <h1 class="display-4">Bienvenue sur notre boutique en ligne</h1>
    <p class="lead">Découvrez notre sélection de produits de qualité.</p>
    <hr class="my-4">
    <p>Parcourez nos catégories et trouvez ce dont vous avez besoin.</p>
    <a class="btn btn-primary btn-lg" href="{{ route('catalog.products') }}" role="button">Voir tous les produits</a>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <h2>Catégories populaires</h2>
        <hr>
    </div>
</div>

<div class="row mb-5">
    @foreach($categories as $category)
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <h3 class="card-title">{{ $category->name }}</h3>
                <p class="card-text">{{ Str::limit($category->description, 100) }}</p>
                <a href="{{ route('catalog.category', $category) }}" class="btn btn-outline-primary">Explorer</a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <h2>Produits en vedette</h2>
        <hr>
    </div>
</div>

<div class="row">
    @foreach($featuredProducts as $product)
    <div class="col-md-3 mb-4">
        <div class="card product-card h-100">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text flex-grow-1">{{ Str::limit($product->description, 80) }}</p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="h5 text-primary mb-0">{{ number_format($product->price, 2) }} €</span>
                    <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                        {{ $product->stock > 0 ? 'En stock' : 'Rupture de stock' }}
                    </span>
                </div>
                <div class="mt-3">
                    <a href="{{ route('catalog.product.show', $product) }}" class="btn btn-primary w-100">Voir le produit</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="text-center mt-4">
    <a href="{{ route('catalog.products') }}" class="btn btn-outline-primary btn-lg">Voir tous les produits</a>
</div>
@endsection
