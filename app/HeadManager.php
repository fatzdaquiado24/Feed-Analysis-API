<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class HeadManager extends Authenticatable
{
    use HasMultiAuthApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address', 'cellphone_number', 'email', 'password', 'active', 'activation_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}
