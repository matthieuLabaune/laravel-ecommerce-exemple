<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd('test');



        $products = Product::with('category:id,name')->get();

        //abort_if(true, 401);


        // La même requêtes avec DB Query Builder
        // $products = DB::table('products')->join('categories', 'products.category_id', '=', 'categories.id')
        //     ->select('products.*', 'categories.name as category_name')
        //     ->get();

        //dd($products);

        try {
            // Transformation des données avec Resources
            $formattedProducts = new ProductCollection($products);

            // Conversion en tableau PHP pour utilisation dans la vue
            $productsData = $formattedProducts->toArray(request());

            // Ajout de données complémentaires pour l'exemple
            $exampleData = [
                'using_resource' => true,
                'resource_benefits' => [
                    'Transformation de données consistante',
                    'Contrôle précis des attributs exposés',
                    'Inclusion conditionnelle de relations',
                    'Formatage de données (dates, prix, etc.)',
                    'Métadonnées additionnelles'
                ]
            ];

            return view('products.index', [
                'products' => $products, // Données brutes pour la compatibilité avec la vue existante
                'productsResource' => $productsData, // Données formatées par la Resource
                'exampleData' => $exampleData // Données d'exemple supplémentaires
            ]);
        } catch (\Exception $e) {
            // En cas d'erreur avec les Resources, on utilise simplement la vue standard
            \Illuminate\Support\Facades\Log::error('Erreur lors du traitement des Resources: ' . $e->getMessage());
            return view('products.index', compact('products'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('active', true)->get();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation directe dans le contrôleur (sans Form Request)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => ['required|numeric|min:0'],
            'stock' => 'required|integer|min:0',
            'active' => 'boolean',
            'category_id' => 'required|exists:categories,id'
        ], [
            'name.required' => 'Le nom du produit est obligatoire.',
            'name.max' => 'Le nom du produit ne peut pas dépasser 255 caractères.',
            'price.required' => 'Le prix du produit est obligatoire.',
            'price.numeric' => 'Le prix doit être un nombre.',
            'price.min' => 'Le prix ne peut pas être négatif.',
            'stock.required' => 'Le stock du produit est obligatoire.',
            'stock.integer' => 'Le stock doit être un nombre entier.',
            'stock.min' => 'Le stock ne peut pas être négatif.',
            'category_id.required' => 'La catégorie est obligatoire.',
            'category_id.exists' => 'La catégorie sélectionnée n\'existe pas.',
        ]);

        // Préparer les données
        $validated['active'] = $request->boolean('active');

        try {
            Product::create($validated);

            // make the same update if no fieds in the fillable
            // if no fields are provided, the product will not be updated
            // this is a safeguard to ensure that the product is updated only with provided fields
            $product = new Product();
            $product->name = $validated['name'];
            $product->description = $validated['description'] ?? null;
            $product->price = $validated['price'];
            $product->stock = $validated['stock'];
            $product->active = $validated['active'];
            $product->category_id = $validated['category_id'];
            $product->save();
            // If you have fillable fields, you can use:
            //$product->fill($validated);


            return redirect()->route('products.index')
                ->with('success', 'Produit créé avec succès');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Une erreur est survenue lors de la création du produit: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        $product->load('category'); // Charger la relation catégorie
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('active', true)->get();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $validated = $request->validated();

            $product->update($validated);

            return redirect()->route('products.show', $product)
                ->with('success', 'Produit mis à jour avec succès');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour du produit: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return redirect()->route('products.index')
                ->with('success', 'Produit supprimé avec succès');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Une erreur est survenue lors de la suppression du produit: ' . $e->getMessage());
        }
    }
}
