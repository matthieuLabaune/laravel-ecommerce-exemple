<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Affiche le contenu du panier.
     */
    public function index()
    {
        //dd(Session::getId(), Session::all());

        $cartItems = session()->get('cart', []);
        $total = $this->calculateTotal($cartItems);

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Ajoute un produit au panier.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity;

        // Récupération du produit
        $product = Product::findOrFail($productId);

        // Vérification du stock
        if ($product->stock < $quantity) {
            return back()->with('error', 'Stock insuffisant. Il reste seulement ' . $product->stock . ' unité(s).');
        }

        // Récupération du panier actuel
        $cart = session()->get('cart', []);

        // Si le produit existe déjà dans le panier, on met à jour la quantité
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
            $cart[$productId]['subtotal'] = $cart[$productId]['price'] * $cart[$productId]['quantity'];
        } else {
            // Sinon on ajoute le produit au panier
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'subtotal' => $product->price * $quantity,
                'image' => $product->image ?? null,
            ];
        }

        // Mise à jour du panier dans la session
        session()->put('cart', $cart);

        // Log le contenu du panier après l'ajout
        \Illuminate\Support\Facades\Log::info('Panier après ajout:', ['cart' => session()->get('cart')]);

        return back()->with('success', 'Produit ajouté au panier avec succès.');
    }

    /**
     * Met à jour la quantité d'un produit dans le panier.
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity;

        // Récupération du produit
        $product = Product::findOrFail($productId);

        // Vérification du stock
        if ($product->stock < $quantity) {
            return back()->with('error', 'Stock insuffisant. Il reste seulement ' . $product->stock . ' unité(s).');
        }

        // Récupération du panier actuel
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            $cart[$productId]['subtotal'] = $cart[$productId]['price'] * $quantity;

            session()->put('cart', $cart);
            return back()->with('success', 'Panier mis à jour avec succès.');
        }

        return back()->with('error', 'Produit non trouvé dans le panier.');
    }

    /**
     * Supprime un produit du panier.
     */
    public function remove(Request $request)
    {
        $productId = $request->product_id;
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            return back()->with('success', 'Produit retiré du panier avec succès.');
        }

        return back()->with('error', 'Produit non trouvé dans le panier.');
    }

    /**
     * Vide le panier.
     */
    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Panier vidé avec succès.');
    }

    /**
     * Calcule le total du panier.
     */
    private function calculateTotal($cartItems)
    {
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['subtotal'];
        }
        return $total;
    }
}
