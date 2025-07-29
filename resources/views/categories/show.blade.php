@extends('layouts.app')

@section('title', 'Détails de la Catégorie')
@section('header', 'Détails de la Catégorie')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ $category->name }}</h5>
        <div>
            @if($category->active)
            <span class="badge bg-success">Active</span>
            @else
            <span class="badge bg-danger">Inactive</span>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <h6 class="text-muted">Description</h6>
                <p>{{ $category->description ?? 'Aucune description disponible' }}</p>

                <h6 class="text-muted mt-4">Détails</h6>
                <table class="table table-striped">
                    <tr>
                        <th style="width: 150px;">ID</th>
                        <td>{{ $category->id }}</td>
                    </tr>
                    <tr>
                        <th>Nombre de produits</th>
                        <td>{{ $category->products_count }}</td>
                    </tr>
                    <tr>
                        <th>Créée le</th>
                        <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Dernière mise à jour</th>
                        <td>{{ $category->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if(count($products) > 0)
        <div class="mt-4">
            <h5>Produits dans cette catégorie</h5>
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
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
                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info">
                                    Voir
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="alert alert-info mt-4">
            Aucun produit n'est associé à cette catégorie.
        </div>
        @endif
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between">
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                Retour à la liste
            </a>
            <div>
                <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">
                    Modifier
                </a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    Supprimer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer la catégorie <strong>{{ $category->name }}</strong> ?</p>
                @if($category->products_count > 0)
                <div class="alert alert-warning">
                    <strong>Attention :</strong> Cette catégorie contient {{ $category->products_count }} produit(s). Leur catégorie sera supprimée si vous continuez.
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('categories.destroy', $category) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
