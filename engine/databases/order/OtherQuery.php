<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace engine\database\order;

/**
 * Description of OtherQuery
 *
 * @author Irwansyah
 */
class OtherQuery extends \engine\database\QueryExp{
    
    public function describe($tableName) {
        $this->query = "describe $tableName";
        
        return $this->query;
    }
    
    public function showing($type = 'table') {
        $query = "";
        if($type == 'table'){
            $query = "show tables";
        }else if($type == 'db'){
            $query = "show databases";
        }else{
            $query = "show tables";
        }
        
        $this->query = $query;
        
        return $this->query;
    }
    
    public function truncate($tableName) {
        $this->query = "truncate $tableName";
    }

    public function dropTable($tableName) {
        $this->query = "drop table $tableName";
    }    
}
