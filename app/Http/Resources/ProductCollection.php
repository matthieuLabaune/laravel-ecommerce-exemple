<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => [
                        'value' => $product->price,
                        'formatted' => number_format($product->price, 2) . ' €'
                    ],
                    'stock' => [
                        'quantity' => $product->stock,
                        'status' => $product->stock > 0 ? 'En stock' : 'Rupture de stock'
                    ],
                    'active' => $product->active,
                    'category' => $product->category ? [
                        'id' => $product->category->id,
                        'name' => $product->category->name
                    ] : null,
                    'created_at' => $product->created_at->format('d/m/Y H:i'),
                ];
            }),
            'meta' => [
                'total_count' => $this->collection->count(),
                'total_active' => $this->collection->where('active', true)->count(),
                'total_inactive' => $this->collection->where('active', false)->count(),
                'total_out_of_stock' => $this->collection->where('stock', 0)->count(),
            ],
        ];
    }
}
