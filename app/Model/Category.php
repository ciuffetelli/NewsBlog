<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Model\Layout;
use App\Model\Visibility;
use App\User;

class Category extends Model{

    protected $table = 'categorys';

    protected $fillable = ['name', 'icon', 'layout_id', 'visibility_id', 'color', 'isMenu'];
    // protected $guarded = ['id', '_token'];
    public $timestamps = true;    

    public function layout(){
        return $this->belongsTo(Layout::class,'layout_id','id');
    }

    public function visibility(){
        return $this->belongsTo(Visibility::class, 'visibility_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function articles(){
        return $this->hasMany(Article::class);
    }
}
