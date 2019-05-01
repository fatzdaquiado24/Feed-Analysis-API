<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChemicalTest extends Model
{
    protected $fillable = [
        'parameter', 'method', 'fee'
    ];
}
