<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'description', 'client_id'
    ];

    protected $hidden = [
        'client_id'
    ];

    public function client() {
        return $this->belongsTo('App\Client');
    }
}
