<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
       /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'fname', 'lname','gender','birthdate','mobile','marital_status','images'
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
