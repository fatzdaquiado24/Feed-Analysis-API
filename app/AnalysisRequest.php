<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalysisRequest extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'parameter', 'method', 'fee', 'feed_analysis_test_id'
    ];

    protected $hidden = [
        'id', 'feed_analysis_test_id'
    ];
}
