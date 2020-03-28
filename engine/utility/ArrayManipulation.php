<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace engine\utility;


class ArrayManipulation {
    
    protected $value;
    
    /*
     * array => array yang akan diambil nilainya; nilai = array
     * key => nilai kunci; jika type 1D = integer, 2D = mixed
     * type => type dimensi dari array yg akan digunakan; ada 2 pilihan nilai yaitu = 1D dan 2D
     * keysub => nilai keysub khusus untuk type 2D. jika ingin mengambil nilai satuannya; nilai = integer
     */
    function getArrayValue($array,$key,$type,$keySub = 'none'){
        $this->value = '';
        switch ($type){
            case '1D':
                if($key < count($array)){
                    $this->value = $array[$key];
                }
                break;
            case '2D':
                if($key < count($array)){
                    $this->value = $array[$key];
                    if($keySub != 'none'){
                        $this->value = $this->value[$keySub];
                    }
                }    
                break;
            default:
                break;
        }
        return $this->value;
    }
    
    /*
     * mencari kunci dari array
     * 1 = true, 0 = false
     */
    function searchKey($key,$array){
        $boolean = 0;
        foreach ($array as $keys => $value) {
            if($key == $keys){
                $boolean = 1;
            }
        }
        return $boolean;
    }
    
    // mencari value dari array
    function searchValue($value,$array){
        $boolean = 0;
        foreach ($array as $key => $values) {
            if($value == $values){
                $boolean = 1;
            }
        }
        return $boolean;
    }

    /* 
     * mencari value dari array didalam array lain
     * max dan min 2 array
     */
    function searchArrayVToArray($arrayKey,$arrayValue){
        $boolean = 0;
        foreach ($arrayKey as $keyArray => $valueArray) {
            foreach ($arrayValue as $keyValue => $valueValue) {
                if($valueArray == $valueValue){
                    $boolean = 1;
                }
            }
        }
        
        return $boolean;
    }
    
    // mendapatkan string yang di apit delimiter yang berbeda, dan di kumpulkan ke array
    // help/(id)  /iden/(oi)
    function explode2Delimiter($text,$deli1,$deli2){
        $arrayNew = explode($deli2, $text);
        $array = array();
        $count = 0;
        
        if(count($arrayNew) > 1){
            foreach($arrayNew as $key => $value){
                if($value != ""){
                    $ar = explode($deli1, $value);
                    $array[$count++] = $ar[count($ar) - 1];
                }
            }
        }  
        return $array;
    } 
    
    /*
     * membuat array baru dengan parameter kunci dan nilai dari array
     */
    function newArrayFArray($arrayKey,$arrayValue){
        $arrayNew = array();
        
        for($i = 0;$i < count($arrayValue);$i++){
            $arrayNew[$arrayKey[$i]] = $arrayValue[$i];
        }
        
        return $arrayNew;
    }
    
    /*
     * tambah nilai array yang sudah ada tanpa kunci khusus
     */
    function addArray($array,$value) {
        $array[count($array)] = $value;
    }
    
    /*
     * melarang karakter tertentu dalam sebuah array
     */
    function searchCharacter($char,$array){
        $boolean = 0;
        foreach ($array as $value) {
            if(preg_match("/([$char])/", $value)){
                $boolean = 1;
            }
        }
        return $boolean;
    }

    /*
     * melarang karakter tertentu dalam sebuah string
     */
    function searchCharacterOnString($char,$string){
        $boolean = 0;
        if(preg_match("/([$char])/", $string)){
            $boolean = 1;
        }
        return $boolean;
    }
    
}
