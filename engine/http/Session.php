<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace engine\http;

/**
 * Description of Session
 *
 * @author Irwansyah
 */
class Session {
    //put your code here
    
    function set($sessionName,$value) {
        $_SESSION[$sessionName] = $value;   
    }
    
    function getValue($name) {
        $sessionName = empty($_SESSION[$name])?"":$_SESSION[$name];
        
        return $sessionName;
    }
    
    function getName($value){
        
    }
    
    function remove($sessionName){
        session_unregister($sessionName);
    }
    
    function removeAll() {
        session_destroy();
    }
    
}
