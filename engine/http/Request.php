<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace engine\http;

use engine\errors\ErrorCode;
use engine\Loader;
use engine\utility\JsonManipulation;
use engine\http\Response;

class Request {
    private $loader,$json,$response;
    
    public function __construct() {
        $this->loader = new Loader();
        $this->json = new JsonManipulation();
        $this->response = new Response();
    }
    
    function get($data) {
        $url = $_GET['url'];
        
        $arrayUrl = explode("/", $url);
        if($data < count($arrayUrl)){
            $arrayUrl = $arrayUrl[$data];
        }else{
            $arrayUrl = "";
        }

        return $arrayUrl;
    }

    function getValue($data){
        $value = isset($_GET[$data])?$_GET[$data]:'';

        return $value;
    }
    
    function post($data,$tipeData='',$validation = 'none'){
        $postData = isset($_POST[$data])?$_POST[$data]:'';
        
        if($tipeData == 'string'){
            $postData = "'".$postData."'";
        }

        switch ($validation) {
            case 'null': 
                if($postData == null){
                    $this->response->notif("Input not null");

                    $this->response->back();
                    exit();
                }
                break;
            case 'number':
                if(is_numeric($postData)){
                    $this->response->notif("Input not numeric");

                    $this->response->back();
                    exit();
                }
                break;
            case 'string':
                if(is_string($postData)){
                    $this->response->notif("Input not string");

                    $this->response->back();
                    exit();
                }
                break;
            case 'none':
                
                break;
            default:
                
                break;
        }
        
        return $postData;
    }
    
    
    function validation($data){
        $arrayMessage ='';
        $post = array();
        if(is_array($data)){
            foreach ($data as $key => $value) {
                $post = $this->post($key);
                $typeValidation = explode('/', $value);
                foreach ($typeValidation as $valueItem) {
                    switch ($valueItem){  
                        case 'null':
                            if($post == null){
                                $arrayMessage .= "$key is not null*";
                            }
                            break;
                        case 'number':
                            if(is_numeric($post)){
                                $arrayMessage .= "$key is not number*";
                            }
                            break;
                        case 'string':
                            if(is_string($post)){
                                $arrayMessage .= "$key is not string*";
                            }
                            break;
                        default :
                            exit();
                    }
                }
            }
        }else{
            echo "Data not valid";;
        }
        
        if($arrayMessage == ''){
            return $post;
        }else{
            $this->response->notif($arrayMessage);
            $this->response->back();
            exit();
        }
    }
    
    function inc($section){
        $sectionNew = str_replace('.', '/', $section);
        if(file_exists($sectionNew.'.php')){
            include $sectionNew.'.php';
        }else{
            ErrorCode::setKode($sectionNew.'.php');
            ErrorCode::setMessage('Include <b>'.ErrorCode::getKode().'</b> not found');
            $this->loader->loaderPage(ErrorCode::getPageError(), ErrorCode::getLocationError());
        }
    }

    function incEkstension($section){
        if(file_exists($section)){
            include $section;
        }else{
            ErrorCode::setKode($section);
            ErrorCode::setMessage('Include <b>'.ErrorCode::getKode().'</b> not found');
            $this->loader->loaderPage(ErrorCode::getPageError(), ErrorCode::getLocationError());
        }
    }

    function getNotification($cookie = 'notifikasi'){
        $notif = isset($_COOKIE[$cookie])?$_COOKIE[$cookie]:""; 

        return $notif;
    }

    function assets($filename){
        return $this->json->getValue($this->loader->loaderFile('environment.json'), 'App', 'App_import').$filename;
    }

    function getFiles($filename){
        return $this->json->getValue($this->loader->loaderFile('environment.json'), 'App', 'App_files').$filename;
    }

}
