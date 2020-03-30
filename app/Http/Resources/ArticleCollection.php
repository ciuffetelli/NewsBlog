<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
{
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
                'title' => $data['title'],
                'view' => $data['view'],
                'category' => $data->category()->first()['name'],
                'layout' => $data->layout()->first()['name'],
                'visibility' => $data->visibility()->first()['name'],
                'user' => $data->user()->first()['name'],
            ];
        });

        if($this->resource instanceof \Illuminate\Pagination\LengthAwarePaginator){
            $nextPage = $this->resource->currentPage() + 1;
            if($nextPage > $this->resource->lastPage()) $nextPage = $this->resource->lastPage();

            $paginate = [
                'total'       => $this->resource->total(),
                'currentPage' => route('apiArticle').'?page='.$this->resource->currentPage(),
                'nextPage'    => route('apiArticle').'?page='.$nextPage,
                'lastPage'    => route('apiArticle').'?page='.$this->resource->lastPage(),
            ];
        }else{
            $paginate = null;
        }

        return [
            'data' => $data,
            'paginate' => $paginate
        ];
        // return parent::toArray($request);
    }
}
