<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaboratoryAnalysisRequest extends Model
{
    protected $fillable = [
        'appointment_date', 'client_id'
    ];

    protected $hidden = [
        'client_id'
    ];

    public function client() {
        return $this->belongsTo('App\Client');
    }
}
