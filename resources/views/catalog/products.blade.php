@extends('layouts.catalog')

@section('title', 'Tous les produits - E-Commerce Laravel')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1>Tous les produits</h1>
    </div>
    <div class="col-md-4">
        <div class="d-flex justify-content-end align-items-center h-100">
            <form action="{{ route('catalog.products') }}" method="GET" class="d-flex">
                @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <select name="sort" class="form-select me-2">
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nom (A-Z)</option>
                    <option value="price" {{ request('sort') == 'price' && request('direction') == 'asc' ? 'selected' : '' }}>Prix (croissant)</option>
                    <option value="price" {{ request('sort') == 'price' && request('direction') == 'desc' ? 'selected' : '' }}>Prix (décroissant)</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Nouveautés</option>
                </select>
                <input type="hidden" name="direction" value="{{ request('direction', 'asc') }}">
                <button type="submit" class="btn btn-primary">Trier</button>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Catégories</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="{{ route('catalog.products') }}" class="list-group-item list-group-item-action {{ !request('category') ? 'active' : '' }}">
                        Toutes les catégories
                    </a>
                    @foreach($categories as $category)
                    <a href="{{ route('catalog.products', ['category' => $category->id]) }}" class="list-group-item list-group-item-action {{ request('category') == $category->id ? 'active' : '' }}">
                        {{ $category->name }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
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
                        <div class="mt-3">
                            <a href="{{ route('catalog.product.show', $product) }}" class="btn btn-primary w-100">Voir le produit</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $products->appends(request()->except('page'))->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
