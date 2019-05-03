<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaboratoryAnalysisRequest extends Model
{
    protected $fillable = [
        'appointment_date', 'client_id', 'receiver_id', "chemist_id"
    ];

    protected $hidden = [
        'client_id', 'receiver_id', "chemist_id"
    ];

    public function client() {
        return $this->belongsTo('App\Client');
    }

    public function receiver() {
        return $this->belongsTo('App\Receiver');
    }

    public function feed_analysis_tests() {
        return $this->hasMany('App\FeedAnalysisTest');
    }
}
