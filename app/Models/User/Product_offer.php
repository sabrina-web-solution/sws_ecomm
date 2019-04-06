<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Product_offer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'offer_name', 'offer_type', 'product_id','venue_id','merchant_id','modifier_id','discount_amt','combo_product_ids'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
