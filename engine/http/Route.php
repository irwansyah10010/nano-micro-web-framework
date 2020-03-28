<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace engine\http;

/**
 * Description of Route
 *
 * @author Irwansyah
 */
use engine\Loader;
use engine\errors\ErrorCode;
use engine\http\Session;
use engine\utility\ArrayManipulation;
use engine\errors\SessionError;
use engine\http\Response;

class Route {
    private $loader,    
            $arrayManipulation,
            $url,
            $acces,
            $session,
            $response,
            $array;
    
    
    public $nameRoute = array();
    public $validRoute = array();
    
    public function __construct() {
        $this->loader = new Loader();
        $this->arrayManipulation = new ArrayManipulation();
        $this->session = new Session();
        $this->response = new Response();
        $this->acces = new \view\Acces();
    }
    
    /* 
     *
     */
    private function setRoute($route,$function,$acces=''){
        $this->array = $this->arrayManipulation->explode2Delimiter($route, '(', ')');
        

        // variabel example
        $variabelRoute = explode("/", $route);
        
        $boolean = 0;
        
        $url = $_GET['url'];
        
        // menyimpan variabel
        $arrayRoute = array();
        
        // jika route memiliki variabel
        if(count($this->array) >= 1){
            $true = 0;     
            $arrayUrl = explode("/", $url);

            $count = 0;
            // cek apabila jumlah array url dengan route sama(berhasil)
            if(count($variabelRoute) == count($arrayUrl)){
                
                for($i = 0;$i < count($arrayUrl);$i++){
                    if($variabelRoute[$i] == $arrayUrl[$i]){
                        
                    }else{
                        $bo = $this->arrayManipulation->searchCharacterOnString("(", $variabelRoute[$i]);
                        if($bo == 1){
                            $variabelRoute[$i] = $arrayUrl[$i];    
                        }
                    }
                }
            }

            $route = implode("/", $variabelRoute);
            
            // membuat variabel(belum selesai)
            for($i = count($arrayUrl) - 2;$i >= 0; $i -= 2){
                $arrayRoute[$count++] = $arrayUrl[$i];
            }
            
            $arrayRoute = array_reverse($arrayRoute);
            
        }
        
        if($url == $route){
            $this->validRoute[] = $route;
            
            $arrayRoute = $this->arrayManipulation->newArrayFArray($this->array, $arrayRoute);
            
            // periksa hak akses
            if(is_array($acces)){
                $keyArrayAcces = array_keys($acces);

                if(count($acces) > 1){
                    
                    
                }else if(count($acces) == 1){
                    $acces = $acces[$keyArrayAcces[0]];
                    
                    // nama session di view acces
                    $sessionExample = $this->acces->accesRight;
                    
                    // nama session yang aktif
                    $valueSession = $this->session->getValue($keyArrayAcces[0]);


                    // periksa apakah lebih value array lebih dari 1
                    if(is_array($acces)){   
                        $boolAccess = $this->arrayManipulation->searchValue($valueSession, $acces);
                        
                        if($boolAccess == 1){
                            $boolean = $this->arrayManipulation->searchArrayVToArray($acces, $sessionExample);    
                        }
                    }else{
                        $boolean = $this->arrayManipulation->searchValue($valueSession, $sessionExample);
                    }
                }
            }
            // end hak akses
            
            // cek variabel acces
            if($acces == ''){
                $function($arrayRoute);
            }else{
                // jika ada session
                if($boolean == 1){
                    $function($arrayRoute);

                // jika tidak ada session
                }else{
                    $this->response->redirect(SessionError::getLocationSession());
                }
            }
        }
    }
    
    public function get($route,$function,$keyAcces = '') {
        $this->nameRoute[] = 'get->'.$route;
        
        $this->setRoute($route, $function,$keyAcces);
    }
    
    public function post($route,$function,$button,$keyAcces='') {
        $this->nameRoute[] = 'post->'.$route;
        
        if(isset($_POST[$button])){
            $this->setRoute($route, $function,$keyAcces);
        }
    }

    public function group(){}
    
    public function getNameRoute() {
        return $this->nameRoute;
    }

    public function checkRoute(){
        if(count($this->validRoute) == 0){
            ErrorCode::setMessage("Page not found");
            $this->loader->loaderPage(ErrorCode::getPageError(), ErrorCode::getLocationError());
        }
    }
}
