<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



namespace engine\http;

use engine\errors\ErrorCode;
use engine\utility\JsonManipulation;
use engine\Loader;
use engine\http\Session;

class Response {
    private $page,$class = "",$function="",$json,$loader,$session;
    private  $homepage;
            
    function __construct() {
        $this->json = new JsonManipulation();
        $this->loader = new Loader();
        $this->session = new Session();
        $this->homepage = $this->json->getValue($this->loader->loaderFile('environment.json'), 'App', 'App_server');
    }
    
    /*
     * 
     */
    function url($page){
        $this->call($this->homepage.$page);
    }
    
    function returnUrl($page){
        return $this->homepage.$page;
    }
    
    /*
     *  
     * menampilkan halaman berdasarkan lokasi file di direktori tanpa ektensi yang tersedia example 
     * view('help/index')
     * atau dengan memanggil fungsi dari class controller,
     * view('ControlExample&namaFungsi')
     */
    public function view($location,$id='',$notification='',$time = 30){
        setcookie("notifikasi", $notification, time()+$time,'/');
        
        $message = "";
        
        $this->page = explode("&", $location);
        $cekLocation = strpos($location, "&")? strpos($location, "&"):0;
        
        if($cekLocation == 0){
                if(file_exists($location.'.php')){

                    include_once $location.'.php';
                }else{
                    if(ErrorCode::getKode() == ""){
                        $message = "File not found <br> Location <b>Routing.php</b>";
                    }else{
                        $message = 'File not found <br> Location <b>'.ErrorCode::getKode().'</b>';
                        
                    }
                    ErrorCode::setMessage($message);
                    $this->loader->loaderPage(ErrorCode::getPageError(), ErrorCode::getLocationError());
                }
        }else{
            $this->class = '\controller\\'.$this->page[0];
            $this->function = $this->page[1];
            if(class_exists($this->class)){
                $control = new $this->class;
                if(method_exists($this->class, $this->function)){
                    ErrorCode::setKode($this->class.'</b> on Method <b>'.$this->function);
                    
                    $control->{$this->function}($id);
                    
                } else{
                    $message = "Method not found on <br><b>$this->class.php<b/>";
                    ErrorCode::setMessage($message);
                    $this->loader->loaderPage(ErrorCode::getPageError(), ErrorCode::getLocationError());
                }
            }else{
                $message = "Class not found";
                ErrorCode::setMessage($message);
                $this->loader->loaderPage(ErrorCode::getPageError(), ErrorCode::getLocationError());
            }
        }
    }
    
    // pindah ke halaman tertentu berdasarkan routing
    function redirect($location,$notification = '',$time=30){   
            
        if($notification != ''){
            setcookie("notifikasi", $notification, time()+$time,'/');
        }
        
        header('Location: '.$this->homepage.$location);
    }
    
    // menampilkan objek
    function call($obj){
        echo $obj;
    }
    
    // kembali ke halaman sebelumnya
    function back($notification = '',$time = 30){
        
        if($notification != ''){
            setcookie("notifikasi", $notification, time()+$time,'/');
        }
        
        echo $_SERVER['HTTP_REFERER'];
        
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    
    function notif($notification,$time = 30) {
        setcookie("notifikasi", $notification, time()+$time,'/');
    }
}

