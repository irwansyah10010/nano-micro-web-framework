<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace engine\errors;

class SessionError{
    private static $message = "";
    private static $kode = "";
    private static $location = "";
    private static $page = "";
    private static $messageArray = array();
    
    static function setMessage($messageIn) {
        SessionError::$message = $messageIn;
    }
    
    static function getMessage(){
        return SessionError::$message;
    }
    
    static function setKode($kodeIn) {
        SessionError::$kode = $kodeIn;
    }
    
    static function getKode() {
        return SessionError::$kode;
    }
    
    static function setLocationSession($location){
        SessionError::$location = $location;
    }

    static function getLocationSession(){
        return SessionError::$location;
    }

    static function setPageSession($page){
        SessionError::$page = $page;
    }

    static function getPageSession(){
        return SessionError::$page;
    }

}

