<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace engine\database\order;

/**
 * Description of DDLQuery
 *
 * @author Irwansyah
 */

class DDLQuery extends \engine\database\QueryExp{
    
    private $column = array();
    private $alter = "";
    
    /*
     * periksa kolom perbolehkan kosong atau tidak. bisa juga memasukan nilai default
     */
    function checkColumn($null = "null",$valueDefault = "") {
       $column = "";
        if($null == "null"){
            $column = " null";
        }else if($null == "not null"){
            $column = " not null";
        }else if($null == "default"){
            $column = " default $valueDefault";
        }else{
            $column = " null";
        }
        
        return $column;
    }
    
    /*
     * 
     */
    function checkLength($length = 'no'){
        $column = "";
        if($length == 'no'){
            $column = "";
        }else{
            if(is_numeric($length)){
                $column = "($length)";
            }else{
                $column = "";
            }
        }
        return $column;
    }
    
    function checkAutoIncrement($autoIncrement = '') {
        $auto = '';
        if($autoIncrement == 'autoIncrement'){
            $auto = 'AUTO_INCREMENT';
        }else{
            $auto = '';
        }
        
        return $auto;
    }
    
    
    /***************************************************************************
     *  Data Definition Language 1
     *  Create Table (clear)
     * 
     */
    /**************************************************************************/
    
    /*
     * 
     */
    function createTable($tablename){
        $colomns = implode(", ", $this->column);
        
        $this->query = "create table $tablename($colomns)";
        
        return $this;
    }
    
    
    /*
     * null = nama column tersebut boleh kosong atau tidak dan
     * length = panjang dari field tersebut
     * autoIncrement = Field auto increment atau tidak
     */
    function integer($columnName,$nullOrDefault = "null",$length='no',$valueDefault='',$autoIncrement = '') {
        $checkNull = $this->checkColumn($nullOrDefault);
        $checkLength = $this->checkLength($length);
        $checkAuto = $this->checkAutoIncrement($autoIncrement);
        
        $this->column[] = "$columnName int$checkLength $checkNull $checkAuto";
    }
    
    /*
     * 
     */
    function floats($columnName,$nullOrDefault = "null",$length='no',$valueDefault='',$autoIncrement = '') {
        $checkNull = $this->checkColumn($nullOrDefault);
        $checkLength = $this->checkLength($length);
        $checkAuto = $this->checkAutoIncrement($autoIncrement);
        
        $this->column[] = "$columnName float$checkLength $checkNull $checkAuto";
    }
    
    /*
     * 
     */
    function char($columnName,$nullOrDefault = "null",$length='no',$valueDefault='',$autoIncrement='') {
        $checkNull = $this->checkColumn($nullOrDefault);
        $checkLength = $this->checkLength($length);
        $checkAuto = $this->checkAutoIncrement($autoIncrement);
        
        $this->column[] = "$columnName char$checkLength $checkNull $checkAuto";
    }
    
    /*
     * 
     */
    function varchar($columnName,$nullOrDefault = "null",$length='no',$valueDefault='') {
        $checkNull = $this->checkColumn($nullOrDefault);
        $checkLength = $this->checkLength($length);
        
        $this->column[] = "$columnName varchar$checkLength $checkNull";
    }
    
    /*
     * 
     */
    function text($columnName,$nullOrDefault = "null",$length='no',$valueDefault=''){
        $checkNull = $this->checkColumn($nullOrDefault);
        $checkLength = $this->checkLength($length);
        
        $this->column[] = "$columnName text$checkLength $checkNull";
    }
    
    /*
     * 
     */
    function typeData($columnName,$typeData,$nullOrDefault = "null",$length='no',$valueDefault='',$autoIncrement='') {
        $checkNull = $this->checkColumn($nullOrDefault);
        $checkLength = $this->checkLength($length);
        $checkAuto = $this->checkAutoIncrement($autoIncrement);
        
        $this->column[] = "$columnName $typeData$checkLength $checkNull $checkAuto";
    }
    
    /*
     * 
     */
    function primaryKey($columnName){
        $this->column[] = "primary key($columnName)";
    }
    
    /*
     * 
     */
    function unique($columnName){
        $this->column[] = "unique($columnName)";
    }

    /*
     * 
     */
    function foreignKey($columnName,$tableName,$columnTable){
        $this->column[] = "foreign key($columnName) references $tableName($columnTable)";
    }

    /*
     * 
     */
    function getColumn() {
        return $this->column;
    }


    /***************************************************************************
     *  Data Definition Language 2 
     *  Alter Table
     *
     * 
    /**************************************************************************/
    
    /*
     * 
     */
    function alterTable($tableName) {
        $this->alter = "alter table $tableName";
        
        return $this;
    }
    
    /*
     * 
     */
    function change($columnBefore,$columnAfter) {
        $this->alter .= " change $columnBefore $columnAfter";
    }
    
    /*
     * 
     */
    function drop($columnName){
        $this->alter .= " drop $columnName";
    }
    
    /*
     * 
     */
    function add($columnName,$typeData,$afterColumn = "no"){
        if($afterColumn == "no"){
            $this->alter .= " add $columnName $typeData";
        }else{
            $this->alter .= " add $columnName $typeData after $afterColumn";
        }
    }
    
    function addPrimaryKey($columnName){
        $this->alter .= " add primary key($columnName)";
    }
    
    function addForeignKey($columnName,$tableName,$columnTable){
        $this->alter .= " add foreign key($columnName) references $tableName($columnTable)";
    }
    
    /*
     * 
     */
    function modify($column,$typeData){
        $this->alter .= " modify $column $typeData";
    }
    
    /*
     * 
     */
    function executeAlter() {
        return $this->alter;
    }
    
}
