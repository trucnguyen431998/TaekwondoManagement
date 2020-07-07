<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    //
    protected $table = "role";
    protected $primaryKey = "roleID"; 
    //1-n voi bang coach
    public function coach()
    {
        return $this->hasMany('App\coach', 'roleID', 'roleID');
    }
}
