<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

use App\Model\Category;

class CategoryCollection extends ResourceCollection{

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){

        $data = $this->collection->map( function ($data){

            return [
                'id' => $data['id'],
                'name' => $data['name'],
                'icon' => $data['icon'],
                'color'=> $data['color'],
                'layout' => $data->layout()->first()['name'],
                'visibility' => $data->visibility()->first()['name'],
                'articles' => $data->articles()->count()
            ];
        });

        $nextPage = $this->resource->currentPage() + 1;
        if($nextPage > $this->resource->lastPage()) $nextPage = $this->resource->lastPage();        

        $paginate = [
            'total'       => $this->resource->total(),
            'currentPage' => route('apiCategory').'?page='.$this->resource->currentPage(),
            'nextPage'    => route('apiCategory').'?page='.$nextPage,
            'lastPage'    => route('apiCategory').'?page='.$this->resource->lastPage(),
        ];        

        return [
            'data' => $data,
            'paginate' => $paginate
        ];
    }
}
