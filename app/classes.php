<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class classes extends Model
{
    //
    protected $table = "class";
    protected $primaryKey = "classID"; 

    //1 class - 1 club
    public function club()
    {
        return $this->belongsTo('App\club', 'clubID', 'clubID');
    }

    //1 class - n martial
    public function martial()
    {
        return $this->hasMany('App\martial', 'classID', 'classID');
    }

    //1 class - 1 coach
    public function coach()
    {
        return $this->belongsTo('App\coach', 'coachID', 'coachID');
    }
}
