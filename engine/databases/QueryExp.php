<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace engine\database;

/**
 * Description of QueryExp
 *
 * @author Irwansyah
 */
use engine\database\Connection;


class QueryExp {
    //put your code here
    protected $query = "",$stmt;
            
    protected $con,$dml,$ddl,$other;
    
    /*
     * 
     */
    function ready(){
        $this->con = new Connection();
        
        try{
            $this->con->getConnection()->prepare($this->query)->execute();
            echo "Query Ok\n\n";
        } catch (\PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    function setQuery($query){
        $this->query = $query;
    }
    
    /*
     * 
     */
    function execute($query,$field = ''){
        $this->con = new Connection();
        
        try{
            $this->stmt = $this->con->getConnection()->prepare($query);
            if($field == ''){
                $this->stmt->execute();
            }else{
                $this->stmt->execute($field);
            }
            echo "Query Ok\n\n";
        } catch (\PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
    /*
     * 
     */
    function exeQuery() {
        return $this->query;
    }
    
    function getStatement(){
        return $this->stmt;
    }
    
}
