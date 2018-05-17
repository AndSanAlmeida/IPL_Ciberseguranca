<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserQuestion extends Model
{
    protected $fillable = [
        'question', 'answer', 'user_id', 'isAnswered', 'isFAQ'
    ];

    public function user() {
    	$this->belongsTo('App\User');
    }
}
