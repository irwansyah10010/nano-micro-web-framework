<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace engine\database;


class BasicQuery {

    public $query,$record=array();
    
    function __construct() {
        
    }
    
    /*
     *  fungsi untuk penambahan data 
     * $tablename = nama table
     * $arrayField = data field dari table yang bersangkutan
     */
    function insert($tablename,$arrayField) {
        $this->record = implode(' , ', $arrayField);
        $replace = implode(' , ', $this->recordValues($arrayField));
        $this->query = "INSERT INTO $tablename($this->record) Values($replace)";
        
        return $this->query;
    }
    
    function update($tablename,$arrayField,$Key,$value = '?') {
        $this->record = implode(' = ?, ', $arrayField);
        
        $this->query = "UPDATE $tablename set $this->record = ? where $Key = $value";
        
        return $this->query;
    }
    
    function delete($tablename,$key,$value = '?') {
        $this->query = "DELETE from $tablename where $key = $value";
        
        return $this->query;
    }
    
    function recordValues($arrayField) {
        $replace=array();
        for($i = 0;$i < count($arrayField);$i++){
            $replace[$i]='?';
        }
        return $replace;
    }
    
    /* 
     * fungsi yang digunakan untuk menampilkan data tabel yang memiliki batasan tertentu
     * 1. Mengurutkan data
     * 2. Membatasi jumlah data berdasarkan dengan jumlah ataupun column tertentu
     * 3. 
     * 
     * berikut penjelasan paramnya 
     * tablename = nama tabel
     * firstColumn = batas awal data tabel, lastColumn = batas akhir
     * columnName = nama column yang akan dipakai , valueName = nilai dari column -> boleh kosong
     * sort = jenis pengurutan yg akan digunakan ASC atau DESC -> boleh kosong
     */
    function select($tablename,$firstColumn,$lastColumn,$sort = '',$columnName = '',$valueName=''){
        if($valueName == ''){
            $this->query = "SELECT * from $tablename order by $columnName $sort limit $firstColumn,$lastColumn";
        }else{
            if(is_numeric($valueName)){
                $this->query = "select * from $tablename where $columnName < $valueName order by $columnName $sort limit $firstColumn,$lastColumn";
            }else{
                $this->query = "select * from $tablename where $columnName like '$valueName%' order by $columnName $sort limit $firstColumn,$lastColumn";
            }
        }
        
        return $this->query;
    }
    
    function selectAll($tablename,$field = 'None',$sort = 'None') {
        if($sort == 'None'){
            $this->query = "SELECT * from $tablename";
        }else{
            $this->query = "SELECT * from $tablename order by $field $sort";
        }
        
        return $this->query;
    }
    
    function selectCount($tablename) {
        $this->query = "SELECT count(*) from $tablename";
        
        return $this->query;
    }
}

