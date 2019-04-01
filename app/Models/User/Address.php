<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'flat', 'area','landmark','city_id','state_id','country_id','pincode','address_type','user_longitude','user_latitude','type','update_token'
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
