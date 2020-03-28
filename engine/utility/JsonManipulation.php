<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace engine\utility;

class JsonManipulation {

    
    function __construct() {
        
    }
    
    function create($array,$nameFile) {
        $jsonFile = json_encode($array,JSON_PRETTY_PRINT);
        
        file_put_contents($nameFile, $jsonFile);
    }
    
    /*
     * membaca file json
     */
    public static function read($file,$message = "") {
        $data = $message;
        if(file_exists($file)){
            $isiFile = file_get_contents($file);
        
            $data = json_decode($isiFile, TRUE);
        }else{
            
        }
        return $data;
    }
    
    /*
     * mendapatkan data json value berdasarkan kunci
     * parameter : 
     * pathFile = letak dari file json, gunakan claas Loader untuk mempermudah
     * kunciArray = kunci terluar dari json,
     * kunci = kunci dari item yang akan dipilih
     */
    function getValue($pathFile,$kunciArray,$kunci= 'none') {
        $this->jsonArray = JsonManipulation::read($pathFile);
        
        foreach($this->jsonArray as $section => $items){
            foreach($items as $key => $value){
                if($section == $kunciArray){
                    if($key == $kunci){
                        return $value;
                    }
                }
            }
        }
    }
    
    /*
     * mendapatkan data array json value berdasarkan kunci
     * parameter : 
     * pathFile = letak dari file json, gunakan class Loader untuk mempermudah
     * kunciArray = kunci terluar dari json,
     */
    function getValueAll($pathFile,$kunciArray = 'none'){
        $this->jsonArray = JsonManipulation::read($pathFile);
        if($kunciArray == 'none'){
            foreach($this->jsonArray as $section => $items){
                foreach($items as $key => $value){

                }
            }
        }else{
            foreach($this->jsonArray as $section => $items){
                foreach($items as $key => $value){
                    if($section == $kunciArray){
                        echo $key."\t".$value."\n";
                    }
                }
            }
        }
    }
    
    /*
     * $object = variabel array untuk json
     */
    public function insert($file,$object,$type = 'controller') {
        $array = JsonManipulation::read($file);
        
        switch ($type) {
            case 'controller':
                if(is_array($array)){
                    $array['controller'] = $array['controller'] + $object;
                }else{
                    $array['controller'] = $object;
                }
                break;

            default:
                break;
        }
        
        $myJson = json_encode($array);
            
        file_put_contents($file, $myJson);
    }
    
    /* jenis Row 
     * 1. section 
     * 2. kunci
     * 3. nilai
     
    function getRow($rows) {
        $this->jsonArray = JsonManipulation::read("environment.json");
        
        $array="";
        
        $i=0;
        foreach($this->jsonArray as $section => $items){
            foreach($items as $key => $value){
                switch ($rows) {
                    case "section":
                        
                        break;
                    case "kunci":

                        break;
                    case "nilai":

                        break;

                    default:
                        break;
                }
            }
        }
    }*/

}

