@extends('layouts.catalog')

@section('title', 'Commande confirmée - E-Commerce Laravel')

@section('content')
<div class="text-center py-5">
    <div class="display-1 text-success mb-4">
        <i class="bi bi-check-circle"></i>
    </div>
    <h1 class="mb-4">Merci pour votre commande !</h1>
    <p class="lead">Votre commande #{{ $order->id }} a été enregistrée avec succès.</p>
    <p>Un email de confirmation a été envoyé à <strong>{{ $order->customer_email }}</strong>.</p>

    <div class="card my-5 text-start">
        <div class="card-header">
            <h5 class="mb-0">Détails de la commande</h5>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6>Informations client</h6>
                    <p>
                        <strong>Nom :</strong> {{ $order->customer_name }}<br>
                        <strong>Email :</strong> {{ $order->customer_email }}<br>
                        <strong>Adresse de livraison :</strong><br>
                        {{ $order->shipping_address }}
                    </p>
                </div>
                <div class="col-md-6">
                    <h6>Informations commande</h6>
                    <p>
                        <strong>Numéro de commande :</strong> #{{ $order->id }}<br>
                        <strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}<br>
                        <strong>Statut :</strong> <span class="badge bg-warning">{{ ucfirst($order->status) }}</span>
                    </p>
                </div>
            </div>

            <h6>Produits commandés</h6>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th class="text-center">Prix unitaire</th>
                            <th class="text-center">Quantité</th>
                            <th class="text-end">Sous-total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td class="text-center">{{ number_format($item->price, 2) }} €</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">{{ number_format($item->subtotal, 2) }} €</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total :</th>
                            <th class="text-end">{{ number_format($order->total_amount, 2) }} €</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('catalog.index') }}" class="btn btn-primary">
            <i class="bi bi-house"></i> Retour à l'accueil
        </a>
        <a href="{{ route('catalog.products') }}" class="btn btn-outline-primary ms-2">
            <i class="bi bi-bag"></i> Continuer vos achats
        </a>
    </div>
</div>
@endsection
