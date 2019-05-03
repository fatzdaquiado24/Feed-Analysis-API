<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedAnalysisTest extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'sample_name', 'laboratory_analysis_request_id', "chemist_id"
    ];

    protected $hidden = [
        'laboratory_analysis_request_id', "chemist_id"
    ];

    public function analysis_requests() {
        return $this->hasMany('App\AnalysisRequest');
    }
}
