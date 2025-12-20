<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'buyer_id','seller_id','status','total_amount',
        'shipping_name','shipping_phone','shipping_address'
    ];

    public function buyer()  { return $this->belongsTo(User::class, 'buyer_id'); }
    public function seller() { return $this->belongsTo(User::class, 'seller_id'); }
    public function items()  { return $this->hasMany(OrderItem::class); }
}

