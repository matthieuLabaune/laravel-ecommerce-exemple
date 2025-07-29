<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Affiche la page d'accueil du catalogue.
     */
    public function index()
    {
        $featuredProducts = Product::where('active', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

        $categories = Category::where('active', true)->get();

        return view('catalog.index', compact('featuredProducts', 'categories'));
    }

    /**
     * Affiche tous les produits du catalogue.
     */
    public function products(Request $request)
    {
        $query = Product::where('active', true);

        // Filtrer par catégorie
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Tri des produits
        $sortBy = $request->input('sort', 'name');
        $direction = $request->input('direction', 'asc');

        switch ($sortBy) {
            case 'price':
                $query->orderBy('price', $direction);
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('name', $direction);
        }

        $products = $query->paginate(12);
        $categories = Category::where('active', true)->get();

        return view('catalog.products', compact('products', 'categories'));
    }

    /**
     * Affiche les détails d'un produit.
     */
    public function show(Product $product)
    {
        if (!$product->active) {
            abort(404);
        }

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('active', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('catalog.show', compact('product', 'relatedProducts'));
    }

    /**
     * Affiche les produits d'une catégorie.
     */
    public function category(Category $category)
    {
        if (!$category->active) {
            abort(404);
        }

        $products = $category->products()
            ->where('active', true)
            ->paginate(12);

        return view('catalog.category', compact('category', 'products'));
    }

    /**
     * Recherche de produits.
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        $products = Product::where('active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->paginate(12);

        return view('catalog.search', compact('products', 'query'));
    }
}
