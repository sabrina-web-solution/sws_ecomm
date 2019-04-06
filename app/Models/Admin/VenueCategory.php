<?php

namespace App\Models\Ecomm;

use Illuminate\Database\Eloquent\Model;

class VenueCategory extends Model
{
    $fillable = [
    	'venue_category_name','venue_category_images','venue_id','merchant_id'
    ];
}
