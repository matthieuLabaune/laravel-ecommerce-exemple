@extends('layouts.catalog')

@section('title', $product->name . ' - E-Commerce Laravel')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}">Accueil</a></li>
        <li class="breadcrumb-item"><a href="{{ route('catalog.products') }}">Produits</a></li>
        @if($product->category)
        <li class="breadcrumb-item"><a href="{{ route('catalog.category', $product->category) }}">{{ $product->category->name }}</a></li>
        @endif
        <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
    </ol>
</nav>

<div class="row mb-5">
    <div class="col-md-5 mb-4">
        <!-- Image du produit (à remplacer par l'image réelle) -->
        <div class="card">
            <div class="card-body text-center py-5 bg-light">
                <i class="bi bi-image display-1 text-secondary"></i>
                <p class="mt-3 text-muted">Image du produit</p>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <h1 class="mb-3">{{ $product->name }}</h1>

        @if($product->category)
        <div class="mb-3">
            <span class="badge bg-secondary">{{ $product->category->name }}</span>
        </div>
        @endif

        <p class="lead">{{ $product->description }}</p>

        <div class="d-flex align-items-center mb-4">
            <h3 class="text-primary mb-0 me-3">{{ number_format($product->price, 2) }} €</h3>
            <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }} me-2">
                {{ $product->stock > 0 ? 'En stock' : 'Rupture de stock' }}
            </span>
            @if($product->stock > 0)
            <span class="text-muted">({{ $product->stock }} disponibles)</span>
            @endif
        </div>

        @if($product->stock > 0)
        <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="quantity" class="form-label">Quantité</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}">
                </div>
                <div class="col-md-9 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-cart-plus"></i> Ajouter au panier
                    </button>
                </div>
            </div>
        </form>
        @else
        <div class="alert alert-danger">
            Ce produit est actuellement en rupture de stock.
        </div>
        @endif
    </div>
</div>

@if($relatedProducts->isNotEmpty())
<div class="row mt-5">
    <div class="col-12">
        <h3>Produits similaires</h3>
        <hr>
    </div>
</div>

<div class="row">
    @foreach($relatedProducts as $relatedProduct)
    <div class="col-md-3 mb-4">
        <div class="card product-card h-100">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $relatedProduct->name }}</h5>
                <p class="card-text flex-grow-1">{{ Str::limit($relatedProduct->description, 80) }}</p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="h5 text-primary mb-0">{{ number_format($relatedProduct->price, 2) }} €</span>
                    <span class="badge bg-{{ $relatedProduct->stock > 0 ? 'success' : 'danger' }}">
                        {{ $relatedProduct->stock > 0 ? 'En stock' : 'Rupture de stock' }}
                    </span>
                </div>
                <div class="mt-3">
                    <a href="{{ route('catalog.product.show', $relatedProduct) }}" class="btn btn-primary w-100">Voir le produit</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection
