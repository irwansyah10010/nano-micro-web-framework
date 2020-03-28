<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace engine\errors;

class ErrorCode{
    private static $message = "";
    private static $kode = "";
    private static $location = "";
    private static $page = "";
    private static $messageArray = array();
    
    static function setMessage($messageIn) {
        ErrorCode::$message = $messageIn;
    }
    
    static function getMessage(){
        return ErrorCode::$message;
    }
    
    static function setKode($kodeIn) {
        ErrorCode::$kode = $kodeIn;
    }
    
    static function getKode() {
        return ErrorCode::$kode;
    }
    
    static function setLocationError($location){
        ErrorCode::$location = $location;
    }

    static function getLocationError(){
        return ErrorCode::$location;
    }

    static function setPageError($page){
        ErrorCode::$page = $page;
    }

    static function getPageError(){
        return ErrorCode::$page;
    }

    // 
    static function addError($message) {
        setcookie('00Error', $message, time()+10,'/');
    }
    
    static function getError() {
        $message = "";
        if(isset($_COOKIE['00Error'])){
            $message =  $_COOKIE['00Error'];
        }
        
        return $message;
    }
    
    static function anyErrors(){
        
    }
    
    static function getErrors(){
        
    }
    
    
    
}

