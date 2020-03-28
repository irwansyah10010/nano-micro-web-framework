<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace engine;

/**
 * Description of Loader
 *
 * @author Irwansyah
 */

class Loader {
    public $rules;
    public $general;
    
    
    function loaderClass($className,$folder){
        $path = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:"Request notting";
        $count = explode('/', $path);
        $minCount = count($count);
        $subDirectori = '../';
        
        while($minCount < count($count)){
            $subDirectori = $subDirectori.'../';
            $minCount++;
        }
        
        $path = $subDirectori.$folder.'/'.$className.'.php';
        
        require_once $path;
    }
    
    /*
     * 
     */
    function loaderPage($pageFile,$folder){
        $path = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:"Request notting";
        $count = explode('/', $path);
        $minCount = count($count);
        $subDirectori = '../';
        
        while($minCount < count($count)){
            $subDirectori = $subDirectori.'../';
            $minCount++;
        }
        
        $path = $subDirectori.$folder.'/'.$pageFile;
        
        require_once $path;
    }
    
    /*
     * $filename = file dan directori nya
     * $type = type dari lokasi file yang akan di cari -> url , console
     */
    function loaderFile($filename,$type ='url'){
        $urlBool = 1;
        $subDirectori = "";
        
        
        if($type == 'url'){
            $path = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:"Request notting";
        }else if($type == 'console'){
            $urlBool = 0;
            $path = $filename;
        }else{
            $path = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:"Request notting";
        }
        
        
        if($urlBool == 1){
            $count = explode('/', $path);
            $minCount = count($count);
            $subDirectori = '../';

            while($minCount < count($count)){
                $subDirectori = $subDirectori.'../';
                $minCount++;
            }
        }else{
            $subDirectori = "";
        }
        
        
        return $subDirectori.$filename;
    }
    
    /*
     * load file berdasarkan lokasi file kebawah atau menuju root
     * 
     * separator = batas untuk pencarian file, default = 5
     */
    function loaderFileNew($filename,$separator = 5) {
        $subDirectori = "../";
        $directori = "";
        $count = 0;
        
        while(!file_exists($directori.$filename)){
            $directori .= $subDirectori;
            $count++;
            if($separator == $count){
                echo "File Tidak ditemukan";
                exit();
            }
        }
        
        return $directori.$filename;
    }
    
    function autoLoader() {
        spl_autoload_register(function(){

        });
    }
    
    
}
