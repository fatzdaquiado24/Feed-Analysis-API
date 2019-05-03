<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalysisRequest extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'parameter', 'method', 'fee', 'result', 'feed_analysis_test_id'
    ];

    protected $hidden = [
        'feed_analysis_test_id'
    ];
}
