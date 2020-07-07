<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class coach extends Model
{
    //
    protected $table = "coach";
    protected $primaryKey = "coachID";
    
    //1 coach - n club
    public function club()
    {
        return $this->hasMany('App\club', 'manager', 'coachID');
    }

    //1 coach - 1 role
    public function role()
    {
        return $this->belongsTo('App\role', 'roleID', 'roleID');
    }

    //1 coach - n class
    public function class()
    {
        return $this->hasMany('App\classes', 'coachID', 'coachID');
    }
}
