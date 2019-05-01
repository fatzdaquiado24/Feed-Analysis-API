<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use SMartins\PassportMultiauth\HasMultiAuthApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hash;

class Client extends Authenticatable
{
    use Notifiable, SoftDeletes, HasMultiAuthApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address', 'cellphone_number', 'email', 'password', 'status', 'activation_token', 'client_type', 'valid_id', 'business_permit'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function validateForPassportPasswordGrant($password)
    {
        if($this->status == 'Approved') {
            return Hash::check($password, $this->getAuthPassword());
        } else {
            return false;
        }
    }

    public function routeNotificationForNexmo($notification) {
        return $this->cellphone_number;
    }
}
