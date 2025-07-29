<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_name',
        'customer_email',
        'shipping_address',
        'total_amount',
        'status',
    ];

    /**
     * Obtenir les éléments de la commande.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
