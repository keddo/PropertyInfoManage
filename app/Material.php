<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
     protected $fillable = [
        'description', 'code', 'unit_measure',
        'quantity', 'unit_price', 'total_value',
    ];
}
