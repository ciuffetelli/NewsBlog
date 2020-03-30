<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class ArticleBlogCollection extends ResourceCollection{

    public $breakPageCode = '<!-- pagebreak -->';

    private function cutHTML($content, int $position = 500){

        $newHtml = substr($content, 0, $position);

        $newHtml = explode('>', $newHtml);

        $newHtml = array_slice($newHtml, 0, -1);

        $newHtml = implode('>', $newHtml) .'>';

        return $newHtml;
    }

    private function processContent($content, $setBreakPage = false){

        //Check and take Off at break page
        $break = strstr($content, $this->breakPageCode, true);

        if($break)
            return $break;

        //CUT 60% off the content;
        $position = round(
                        strlen($content) / 3,
                        0);

        return $this->cutHTML($content, $position);
    }

    public function cols($request){
        return $request->map( function ($data) {
                return [
                    'id' => $data['id'],
                    'title' => $data['title'],
                    'content' => $this->processContent($data['content'], true),
                    'category' => $data->category()->first()['name'],
                    'color' => $data->category()->first()['color'],
                    'layout' => 4,
                    'visibility' => 3,
                    'user' => $data->user()->first()['name']
                ];
        });
    }

    public function process($request){

        return $request->map( function ($data) {

            //Check Visibility by Category
            if($data['visibility_id'] == 1){

                $visibility_id = $data->category()->first()['visibility_id'];

            }else{

                $visibility_id = $data['visibility_id'];
            }

            //check Visibility partially public
            if($visibility_id == 3 && !Auth::check()){
                
                $content = $this->processContent($data['content']);
                $readmore = true;

            }else if(array_search($data['layout_id'], [3,4,5])){

                $content = $this->processContent($data['content']);
                $readmore = true;

            }else if(strstr($data['content'], $this->breakPageCode, true)){

                $content = $this->processContent($data['content']);
                $readmore = true;

            }else{
                $content = $data['content'];
                $readmore = false;
            } 
            
            if($data['layout_id'] == 1) $data['layout_id'] = $data->category()->first()['layout_id'];

            return [                    
                'id' => $data['id'],
                'title' => $data['title'],
                'content' => $content,
                'category' => $data->category()->first()['name'],
                'category_layout' => $data->category()->first()['layout_id'],
                'color' => $data->category()->first()['color'],
                'layout' => $data['layout_id'],
                'visibility' => $visibility_id,
                'user' => $data->user()->first()['name'],
                'readmore' => $readmore,
            ];
        });
    }

    //Analyse section
    public function group($request){

        $toReturn = array();

        foreach($request->all() as $data){
            array_push($toReturn, $this->process($data));
        }

        return $toReturn;
    }
}
