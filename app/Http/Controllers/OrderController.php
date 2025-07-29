<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Affiche le formulaire de commande.
     */
    public function checkout()
    {
        $cartItems = session()->get('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $total = $this->calculateTotal($cartItems);

        return view('orders.checkout', compact('cartItems', 'total'));
    }

    /**
     * Traite et crée la commande.
     */
    public function store(Request $request)
    {
        $cartItems = session()->get('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'shipping_address' => 'required|string',
        ]);

        $total = $this->calculateTotal($cartItems);

        try {
            DB::beginTransaction();

            // Création de la commande
            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'shipping_address' => $validated['shipping_address'],
                'total_amount' => $total,
                'status' => 'pending',
            ]);

            // Création des éléments de commande
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Mise à jour du stock
                $product = Product::find($item['id']);
                $product->stock -= $item['quantity'];
                $product->save();
            }

            DB::commit();

            // Vider le panier
            session()->forget('cart');

            return redirect()->route('orders.confirmation', $order)->with('success', 'Commande passée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la création de la commande: ' . $e->getMessage());
        }
    }

    /**
     * Affiche la confirmation de commande.
     */
    public function confirmation(Order $order)
    {
        return view('orders.confirmation', compact('order'));
    }

    /**
     * Affiche les détails d'une commande.
     */
    public function show(Order $order)
    {
        $order->load('items');
        return view('orders.show', compact('order'));
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
