<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace engine\database;

use engine\utility\JsonManipulation;
use engine\Loader;

class Connection{
     
    private $jsonArray,$con;
    
    /** type dari database 
     * 1. mysql
     * 2. psgre
     * 
     */
    
    private $rdbms = ['mysql','psgre'];
    
    private $type;
    
    /*
     * type = jenis letak file berada -> url , console
     */
    function __construct() {
        $loader = new Loader();
        $this->jsonArray = new JsonManipulation();
        
        $driver = $this->jsonArray->getValue($loader->loaderFileNew("environment.json"), "Database", "DB_driver");
        switch ($driver) {
            case "mysql":
                $this->setType($this->getRdbms());
                break;
            case "psgre":
                $this->setType($this->getRdbms(1));
                break;
            default:
                break;
        }
        
    }
    
    public function getConnection(){
        switch($this->getType()){
            case "mysql":
                $this->type = new driver\MysqlConnection;
                $this->con = $this->type->getConnection();
                
                break;
            case "psgre":
                $this->type = new driver\PosgreConnection();
                $this->con = $this->type->getConnection();
                break;
            default:
                break;
        }
        return $this->con;
    }
    
    function setType($type) {
        $this->type = $type;
    }
    
    function getType(){
        return $this->type;
    }
    
    function getRdbms($value = 0) {
        return $this->rdbms[$value];
    }

}

