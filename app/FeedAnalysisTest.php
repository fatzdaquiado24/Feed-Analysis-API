<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedAnalysisTest extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'sample_name'
    ];

    public function analysis_requests() {
        return $this->hasMany('App\AnalysisRequests');
    }
}
