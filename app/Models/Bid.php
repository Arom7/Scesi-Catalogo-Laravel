<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Connection;

#[Table('bids',
        key: 'id',
        keyType: 'string',
        autoIncrement: false,
        dateFormat: ['created_at', 'updated_at']
    )]

#[Connection('mysql')]

class Bid extends Model
{
    /** @use HasFactory<\Database\Factories\BidFactory> */
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'amount',
        'auction_id',
        'user_id',
    ];

    // Related models
    /**
     * Get the auction associated with the bid.
     */
    /**
     * Get the auction associated with this bid. (Relationships principal)
     */
    public function auction(){
        return $this->belongsTo(Auction::class);
    }

    /**
     * Get the user who made this bid. (Relationships principal)
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}
