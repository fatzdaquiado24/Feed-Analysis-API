<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerFeedback extends Model
{
    protected $table = 'customer_feedbacks';

    protected $fillable = [
        'rating', 'comment', 'client_id'
    ];

    protected $hidden = [
        'client_id'
    ];

    public function client() {
        return $this->belongsTo('App\Client');
    }
}
