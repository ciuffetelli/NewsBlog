<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){
        return $this->collection->map( function ($register) {

            return [
                'name' => $register->name,
                'email' => $register->email,
                'level' => $register->level()->first()->name,
                'register' => date('m-d-Y H:i', strtotime($register->created_at))
            ];
        });
    }
}
