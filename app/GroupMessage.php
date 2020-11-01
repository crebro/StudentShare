<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function group()
    {
        return $this->belongsTo('App\User', 'group_id');
    }

    
}
