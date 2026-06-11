<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Connection;

#[Table('auctions',
        key: 'id',
        keyType: 'string',
        autoIncrement: false,
        dateFormat: ['created_at', 'updated_at']
    )]

#[Connection('mysql')]
class Auction extends Model
{
    /** @use HasFactory<\Database\Factories\AuctionFactory>
     *  @use SoftDeletes<\Database\Factories\AuctionFactory>
     *  @use HasUuids<\Database\Factories\AuctionFactory>
     */
    use HasFactory, HasUuids, SoftDeletes;

    protected $attributes = [
        'status' => 'scheduled',
    ];

    protected $fillable = [
        'product_id',
        'start_time',
        'end_time',
        'min_increment',
        'current_highest_bid',
    ];

    // Related models
    /**
     * Get the product associated with the auction. (Relationships principal)
     */
    public function product(){
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the bids associated with the auction. (Relationships principal)
     */
    public function bids(){
        return $this->hasMany(Bid::class);
    }

    /**
     * Get current highest bid for the auction. (Relationships reference)
     */
    public function highestBid(){
        return $this->belongsTo(Bid::class, 'current_highest_bid', 'id');
    }
}
