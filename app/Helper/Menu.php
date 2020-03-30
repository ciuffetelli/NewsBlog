<?php

namespace App\Helper;

class Menu {

    public $data = [];
    public $active = 'home';
    public $home = null;

    function __construct(array $data = []){
        $this->data = $data;
        $this->home = route('home');
    }

    public function add(array $data, int $position = null){

        if(empty($position)){
            array_push($this->data, $data);
        }else{

            $newData = [];
            for($i=0; $i < count($this->data); $i++){
                if($i == $position){
                    array_push($newData, $data);
                }
                
                array_push($newData, $this->data[$i]);
            }

            $this->data = $newData;
        }
    }

    public function remove(int $index){

        if($this->data[$index]){
            array_splice($this->data, $index, 1);
        }
    }

    public function setActive(string $name){
        $this->active = $name;
    }

    public function setHome(string $home){
        $this->home = $home;
    }

    public function get(array $data = null){

        $data['menu'] = !empty($data) ? $data : $this->data;
        $data['active'] = $this->active;
        $data['home'] = $this->home;

        return $data;
    } 
    
    public function build($data = null){

        $toReturn = $this->get($data);
        $toReturn['menu'] = json_encode($toReturn['menu']);

        return $toReturn;
    }
}
?>