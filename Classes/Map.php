<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Map
 *
 * @author Giny-NB
 */
class Map extends Element{
    public $ID;
    public $coords_array;
    public $start_coords;
    public $name;
    public function __construct($name, $id) {
        $this->name=$name;
        $this->ID=$id;
        $this->coords_array=array();
        $this->start_coords=array(52.112353, 19.412842);
    }
    public function addCoords($coordsXY){
        $this->coords_array[count($this->coords_array)]=$coordsXY;
    }
}
