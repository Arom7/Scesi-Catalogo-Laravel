<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Connection;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Table('products',
        key: 'id',
        keyType: 'string',
        autoIncrement: false,
        dateFormat: ['created_at', 'updated_at']
    )]

#[Connection('mysql')]
class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory>
     *  @use SoftDeletes<\Database\Factories\ProductFactory>
     *  @use HasUuids<\Database\Factories\ProductFactory>
     */
    use HasFactory, HasUuids, SoftDeletes;

    protected $attributes = [
        'status' => 'pending_approval',
    ];

    protected $fillable = [
        'name',
        'description',
        'base_price',
        'status',
    ];

    // Relacioned models

    /**
     * Get the images associated with the product.
     */

    public function productImages(){
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the actions associated with the product.
     */

    public function auctions(){
        return $this->hasMany(Auction::class);
    }

    // Scopes


    // Helpers methods
}
