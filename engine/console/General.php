<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace engine\console;

use engine\console\Keyword;
use engine\console\Rules;
use engine\utility\ArrayManipulation;

class General {
    private $rules,
            $arrayManipulation,
            $keyword;
    
    public function __construct($argv) {
        $this->rules = new Rules();
        $this->arrayManipulation = new ArrayManipulation();
        $this->keyword = new Keyword();
        
        $this->rules->setArgument($argv);
        
        $count = 1;
        if($this->rules->countArgument() > 1){
            $arrayMethod = $this->rules->getMethodAll();
            $this->rules->getArgument($count);
            $arrayTypeFlow = $this->rules->getFlowAgree($this->rules->getArgument($count));
            
            // count = 1
            if($this->arrayManipulation->searchValue($this->rules->getArgument($count++), $arrayMethod) == 1){
                
                // count = 2
                if($this->arrayManipulation->searchValue($this->rules->getArgument($count++), $arrayTypeFlow) == 1){
                    
                    // count = 3
                    $this->rules->onReady($argv);
                    
                }else{
                    $this->equalArgument($count-1, "Type not Found\n\n");
                    
                    $this->rules->showArray(["no","nama Method2"], $this->rules->getFlowAgree($this->rules->getArgument(1)));
                    
                }
            }else{
                $this->equalArgument($count-1, "Method not Found\n\n");
                
                $this->rules->showArray(["Nama Method","Penjelasan"],$this->keyword->penjelasanMethod);
            }
        }else{
            $this->rules->showArray(["Nama Method","Penjelasan"],$this->keyword->penjelasanMethod);
        }
    }
    
    /*
     * 
     */
    function equalArgument($count,$message){
        if($this->rules->countArgument() != $count){
            echo $message;
        }
    }
    
}
