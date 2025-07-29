@extends('layouts.catalog')

@section('title', 'Détails de la commande #' . $order->id . ' - E-Commerce Laravel')

@section('content')
<h1>Commande #{{ $order->id }}</h1>

<div class="card mb-4">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Détails de la commande</h5>
            <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>
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
                    <strong>Montant total :</strong> {{ number_format($order->total_amount, 2) }} €
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
                        <td>
                            @if($item->product)
                            <a href="{{ route('catalog.product.show', $item->product) }}">{{ $item->product_name }}</a>
                            @else
                            {{ $item->product_name }}
                            @endif
                        </td>
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

<div class="text-center">
    <a href="{{ route('catalog.index') }}" class="btn btn-primary">
        <i class="bi bi-house"></i> Retour à l'accueil
    </a>
</div>
@endsection
