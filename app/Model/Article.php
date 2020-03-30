<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Article extends Model{

    protected $table = 'articles';

    protected $fillable = ['title', 'category_id', 'layout_id', 'visibility_id', 'content'];
    
    public function category(){
        return $this->belongsTo(category::class, 'category_id', 'id');
    }

    public function layout(){
        return $this->belongsTo(Layout::class,'layout_id','id');
    }

    public function visibility(){
        return $this->belongsTo(Visibility::class, 'visibility_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }    
}
