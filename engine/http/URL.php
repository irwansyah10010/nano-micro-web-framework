<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace engine\http;

/**
 * Description of URL
 *
 * @author Irwansyah
 */
class URL {
    //put your code here
    
    public $url;
    
    function set($url) {
        $this->url = $url;
    }
    
    function get() {
        return $this->url;
    }
}
