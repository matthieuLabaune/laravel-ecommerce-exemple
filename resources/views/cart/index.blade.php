@extends('layouts.catalog')

@section('title', 'Votre Panier - E-Commerce Laravel')

@section('content')
<h1>Votre Panier</h1>

@if(empty($cartItems))
<div class="alert alert-info">
    Votre panier est vide. <a href="{{ route('catalog.products') }}" class="alert-link">Continuer vos achats</a>.
</div>
@else
<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th class="text-center">Prix unitaire</th>
                        <th class="text-center">Quantité</th>
                        <th class="text-end">Sous-total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $id => $item)
                    <tr>
                        <td>
                            <a href="{{ route('catalog.product.show', $item['id']) }}">{{ $item['name'] }}</a>
                        </td>
                        <td class="text-center">{{ number_format($item['price'], 2) }} €</td>
                        <td class="text-center">
                            <form action="{{ route('cart.update') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $id }}">
                                <div class="input-group input-group-sm" style="width: 120px;">
                                    <button class="btn btn-outline-secondary" type="button" onclick="decrementQuantity('{{ $id }}')">-</button>
                                    <input type="number" name="quantity" id="quantity-{{ $id }}" class="form-control text-center" value="{{ $item['quantity'] }}" min="1" onchange="this.form.submit()">
                                    <button class="btn btn-outline-secondary" type="button" onclick="incrementQuantity('{{ $id }}')">+</button>
                                </div>
                            </form>
                        </td>
                        <td class="text-end">{{ number_format($item['subtotal'], 2) }} €</td>
                        <td class="text-end">
                            <form action="{{ route('cart.remove') }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="product_id" value="{{ $id }}">
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total :</strong></td>
                        <td class="text-end"><strong>{{ number_format($total, 2) }} €</strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('catalog.products') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Continuer vos achats
        </a>
        <a href="{{ route('cart.clear') }}" class="btn btn-outline-danger ms-2">
            <i class="bi bi-trash"></i> Vider le panier
        </a>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('orders.checkout') }}" class="btn btn-success btn-lg">
            <i class="bi bi-credit-card"></i> Passer la commande
        </a>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    function incrementQuantity(productId) {
        const input = document.getElementById('quantity-' + productId);
        input.value = parseInt(input.value) + 1;
        input.form.submit();
    }

    function decrementQuantity(productId) {
        const input = document.getElementById('quantity-' + productId);
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            input.form.submit();
        }
    }

</script>
@endsection
