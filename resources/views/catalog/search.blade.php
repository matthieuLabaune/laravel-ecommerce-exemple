@extends('layouts.catalog')

@section('title', 'Recherche: ' . $query . ' - E-Commerce Laravel')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}">Accueil</a></li>
        <li class="breadcrumb-item"><a href="{{ route('catalog.products') }}">Produits</a></li>
        <li class="breadcrumb-item active" aria-current="page">Recherche: {{ $query }}</li>
    </ol>
</nav>

<h1>Résultats de recherche pour "{{ $query }}"</h1>
<p>{{ $products->total() }} résultat(s) trouvé(s)</p>

@if($products->isEmpty())
<div class="alert alert-info">
    Aucun produit ne correspond à votre recherche.
</div>
@else
<div class="row">
    @foreach($products as $product)
    <div class="col-md-4 mb-4">
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
                <div class="mt-3 d-grid gap-2">
                    <a href="{{ route('catalog.product.show', $product) }}" class="btn btn-primary">Voir le produit</a>
                    @if($product->stock > 0)
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-outline-primary btn-add-to-cart">
                            <i class="bi bi-cart-plus"></i> Ajouter au panier
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $products->appends(['q' => $query])->links() }}
</div>
@endif
@endsection
