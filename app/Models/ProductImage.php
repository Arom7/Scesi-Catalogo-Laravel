<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Connection;

#[Table('product_images',
        key: 'id',
        keyType: 'string',
        incrementing: false,
    )]

#[Connection('mysql')]

class ProductImage extends Model
{
    /** @use HasFactory<\Database\Factories\ProductImageFactory>
     *  @use HasUuids<\Database\Factories\ProductImageFactory>
     */
    use HasFactory, HasUuids;

    protected $fillable = [
        'image_url',
        'is_main',
        'product_id',
    ];

    /**
     * Get the product that owns the image.
     */

    public function product(){
        return $this->belongsTo(Product::class);
    }

     // Scopes
    public function scopeMain(Builder $query): Builder
    {
        return $query->where('is_main', true);
    }


    // Helpers methods
}
