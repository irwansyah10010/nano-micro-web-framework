<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use engine\database\order\OtherQuery;
/**
 * Description of Dosen
 *
 * @author Irwansyah
 */
class QueryCustom {
    //put your code here
    public function __construct() {
        $other = new OtherQuery();
        
        $other->setQuery("select anything");
        
        $other->execute($other->exeQuery());
    }
    
}
