<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace engine\http;

/**
 * Description of Server
 *
 * @author Irwansyah
 */
class Server {
    
    function get($key) {
        return $_SERVER[$key];
    }
}
