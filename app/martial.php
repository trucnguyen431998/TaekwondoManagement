<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class martial extends Model
{
    //
    protected $table = "martial";
    protected $primaryKey = "maID";

    //1 martial - 1 class
    public function class()
    {
        return $this->hasOne('App\classes', 'classID', 'classID');
    }
}
