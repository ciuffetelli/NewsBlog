<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Level extends Model{
    
    protected $table = 'sis_level';

    public function users(){
        return $this->hasMany(User::class);
    }    

}
