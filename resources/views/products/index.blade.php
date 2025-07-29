@extends('layouts.app')

@section('title', 'Liste des Produits')
@section('header', 'Liste des Produits')

@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Nouveau Produit
    </a>
</div>

@if($products->isEmpty())
<div class="alert alert-info">
    Aucun produit n'est disponible pour le moment.
</div>
@else
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category ? $product->category->name : 'Non catégorisé' }}</td>
                <td>{{ number_format($product->price, 2) }} €</td>
                <td>{{ $product->stock }}</td>
                <td>
                    @if($product->active)
                    <span class="badge bg-success">Actif</span>
                    @else
                    <span class="badge bg-danger">Inactif</span>
                    @endif
                </td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info">
                            Voir
                        </a>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">
                            Modifier
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}">
                            Supprimer
                        </button>
                    </div>

                    <!-- Modal de confirmation de suppression -->
                    <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $product->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $product->id }}">Confirmer la suppression</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Êtes-vous sûr de vouloir supprimer le produit <strong>{{ $product->name }}</strong> ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection

@section('after-content')
@isset($productsResource)
<div class="mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Exemple d'utilisation des Laravel Resources</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>Avantages des Resources Laravel</h6>
                    <ul>
                        @foreach($exampleData['resource_benefits'] as $benefit)
                        <li>{{ $benefit }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6>Métadonnées</h6>
                    <ul>
                        <li><strong>Nombre total de produits:</strong> {{ $productsResource['meta']['total_count'] }}</li>
                        <li><strong>Produits actifs:</strong> {{ $productsResource['meta']['total_active'] }}</li>
                        <li><strong>Produits inactifs:</strong> {{ $productsResource['meta']['total_inactive'] }}</li>
                        <li><strong>Produits en rupture de stock:</strong> {{ $productsResource['meta']['total_out_of_stock'] }}</li>
                    </ul>
                </div>
            </div>

            <h6 class="mt-3">Exemple de données formatées par la Resource</h6>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prix (formaté)</th>
                            <th>Statut de stock</th>
                            <th>Catégorie</th>
                            <th>Date de création</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productsResource['data'] as $item)
                        <tr>
                            <td>{{ $item['id'] ?? 'N/A' }}</td>
                            <td>{{ $item['name'] ?? 'N/A' }}</td>
                            <td>{{ $item['price']['formatted'] ?? 'N/A' }}</td>
                            <td>{{ $item['stock']['status'] ?? 'N/A' }}</td>
                            <td>
                                @if(isset($item['category']))
                                {{ $item['category']['name'] ?? 'N/A' }}
                                @else
                                Non catégorisé
                                @endif
                            </td>
                            <td>{{ $item['created_at'] ?? 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="alert alert-info mt-3">
                <strong>Note:</strong> Cette section est un exemple de l'utilisation des Resources Laravel pour transformer et formater les données.
                Les Resources permettent de standardiser le format des données dans votre application, ce qui est particulièrement utile pour les APIs.
            </div>

            <div class="mt-3">
                <h6>Code de la Resource:</h6>
                <pre class="bg-light p-3"><code>// app/Http/Resources/ProductResource.php
public function toArray(Request $request): array
{
    return [
        'id' => $this->id,
        'name' => $this->name,
        'price' => [
            'value' => $this->price,
            'formatted' => number_format($this->price, 2) . ' €'
        ],
        'stock' => [
            'quantity' => $this->stock,
            'status' => $this->stock > 0 ? 'En stock' : 'Rupture de stock'
        ],
        'category' => $this->whenLoaded('category', function () {
            return [
                'id' => $this->category->id,
                'name' => $this->category->name
            ];
        }),
        'created_at' => $this->created_at->format('d/m/Y H:i'),
    ];
}</code></pre>
            </div>
        </div>
    </div>
</div>
@endisset
@endsection
