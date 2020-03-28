<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace engine\database;

use engine\utility\JsonManipulation;
use engine\Loader;

abstract class DatabaseSql {
    
    private $jsonArray;
    
    private $DB,$namaDb,$port,$host,$username,$password;
    
    abstract function getConnection();
    
    /*
     * inisialisasi
     */
    protected function initial() {
        $loader = new Loader();
        
        $this->jsonArray = JsonManipulation::read($loader->loaderFileNew("environment.json"),"");
        
        if($this->jsonArray != ""){
        
            foreach($this->jsonArray as $section => $items){
                foreach($items as $key => $value){
                    if($section == "Database"){
                        switch ($key){
                            case "DB_driver": $this->setDB($value);
                                break;
                            case "DB_name": $this->setDBName($value);
                                break;
                            case "DB_host": $this->setHost($value);
                                break;
                            case "DB_port": $this->setPort($value);
                                break;
                            case "DB_user": $this->setUsername($value);
                                break;
                            case "DB_password": $this->setPassword($value);
                                break;
                            default :
                                break;
                        }
                    }
                }
            }
        }

    }
    
    public function setDB($DB) {
        $this->DB = $DB;
    }
    
    function getDB() {
        return $this->DB;
    }

    public function setDBName($namaDB) {
        $this->namaDb = $namaDB;
    }
    
    function getDBName() {
        return $this->namaDb;
    }
    
    function setPort($port) {
        $this->port = $port;
    }
    
    function getPort(){
        return $this->port;
    }
    
    function setHost($host) {
        $this->host = $host;
    }
    
    function getHost() {
        return $this->host;
    }
    
    function setUsername($username) {
        $this->username = $username;
    }
    
    function getUsername() {
        return $this->username;
    }
    
    function setPassword($password) {
        $this->password = $password;
    }
    
    function getPassword() {
        return $this->password;
    }
}
