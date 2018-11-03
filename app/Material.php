<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
class Material extends Model
{
     use HasApiTokens;
     protected $fillable = [
        'description', 'code', 'unit_measure',
        'quantity', 'unit_price', 'total_value',
    ];
}
