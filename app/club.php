<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class club extends Model
{
    //
    protected $table = "club";
    protected $primaryKey = "clubID";

    //1 club - 1 coach
    public function coach()
    {
        return $this->belongsTo('App\coach', 'coachID', 'manager');
    }

    //1 club - n class
    public function class()
    {
        return $this->hasMany('App\classes', 'clubID', 'clubID');
    }

}
