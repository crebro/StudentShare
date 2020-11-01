<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Group extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User', 'group_user', 'group_id', 'user_id');
    }

    public function messages()
    {
        return $this->hasMany('App\GroupMessage', 'group_id');
    }

    public function userInGroup() 
    {
        if ( DB::select('select * from group_user where user_id = ? and group_id = ?', [Auth::user()->id, $this->id]) ) 
        {
            return true;
        } else {
            return false;
        }
    }
    public function userRequestedGroup() 
    {
        if ( DB::select('select * from join_requests where user_id = ? and group_id = ?', [Auth::user()->id, $this->id]) ) 
        {
            return true;
        } else {
            return false;
        }
    }

}
