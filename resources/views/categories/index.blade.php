@extends('layouts.app')

@section('title', 'Liste des Catégories')
@section('header', 'Liste des Catégories')

@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Nouvelle Catégorie
    </a>
</div>

@if($categories->isEmpty())
<div class="alert alert-info">
    Aucune catégorie n'est disponible pour le moment.
</div>
@else
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Produits</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ Str::limit($category->description, 50) }}</td>
                <td>{{ $category->products_count }}</td>
                <td>
                    @if($category->active)
                    <span class="badge bg-success">Active</span>
                    @else
                    <span class="badge bg-danger">Inactive</span>
                    @endif
                </td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-info">
                            Voir
                        </a>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">
                            Modifier
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $category->id }}">
                            Supprimer
                        </button>
                    </div>

                    <!-- Modal de confirmation de suppression -->
                    <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $category->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $category->id }}">Confirmer la suppression</h5>
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
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
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
