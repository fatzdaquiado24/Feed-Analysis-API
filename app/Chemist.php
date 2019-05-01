<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chemist extends Authenticatable
{
    use SoftDeletes, HasMultiAuthApiTokens;

    protected $fillable = [
        'name', 'email', 'password'
    ];

    protected $hidden = [
        'password',
    ];
}
