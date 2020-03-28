<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace engine\database\order;

/**
 * Description of DML
 *
 * @author Irwansyah
 */

class DMLQuery extends \engine\database\QueryExp{
    
    /***************************************************************************
     *  Data Manipulation Language 1
     *  Save Update Delete
     * 
     ***************************************************************************/
    
    /*
     * 
     */
    public function save($tablename,$dataList){
        $column = implode(",", $dataList);
        
        $replace='';
        for($i = 0;$i < count($dataList);$i++){
            $replace[$i]='?';
        }
        
        $values = implode(",", $replace);
        
        
        
        $this->query = "INSERT INTO $tablename($column) values($values)";
        return $this->query;
    }
    
    /*
     * 
     */
    public function update($tablename,$dataList,$columnKey,$key) {
        $values = implode("= ?,", $dataList);
        
        $this->query = "UPDATE $tablename set $values = ? where $columnKey = $key";
        return $this->query;
    }
    
    public function updateCustom($tablename,$dataList) {
        
        $this->query = "UPDATE $tablename set ";
    }
    
    /*
     * 
     */
    public function delete($tablename,$columnKey,$key){
        $this->query = "DELETE from $tablename where $columnKey = $key";
        
        return $this->query;
    }
    
    /***************************************************************************
     *  Data Manipulation Language 2
     *  Select Data
     * 
     ***************************************************************************/
    
    /*
     * fungsi untuk menampilkan tabel berdasarkan nama table dengan memperbolehkan nilai kolom ganda tampil
     */
    public function select($tablename){
        $this->query = "Select * from $tablename";
        
        return $this->query;
    }
    
    /*
     * fungsi untuk menampilkan tabel berdasarkan nama table dengan nilai kolom yang unik
     */
    public function selectDistinct($tablename){
        $this->query = "Select distinct * from $tablename";
        
        return $this->query;
    }
    
    /*
     * fungsi menampilkan table berdasarkan kolom dengan operator sama dengan
     * dengan syarat memanggil fungsi select() terlebih dahulu
     * valueName =  bisa bernilai string atau angka
     */
    public function equalColumn($columnName,$valueName){
        
        if(is_numeric($valueName)){
            $this->query = " $columnName = $valueName";
            
        }else{
            $this->query = " $columnName = '$valueName'";
        }
        
        return $this->query;
    }
    
    /*
     * fungsi menampilkan table berdasarkan kolom dengan operator tidak sama dengan
     * dengan syarat memanggil fungsi select() terlebih dahulu
     * valueName =  bisa bernilai string atau angka
     */
    public function notequalColumn($columnName,$valueName){
        
        if(is_numeric($valueName)){
            $this->query = " $columnName != $valueName";
            
        }else{
            $this->query = " $columnName != '$valueName'";
        }
        
        return $this->query;
    }
    
    /*
     * fungsi menampilkan table berdasarkan kolom dengan operator selain dari sama dengan
     * dengan syarat memanggil fungsi select() terlebih dahulu
     * valueName :  bernilai angka,
     * operator : > < >= <= (string)
     */
    public function operatorColumn($columnName,$valueName,$operator){
        
        switch ($operator) {
            case ">":
                $this->query = " $columnName > $valueName";
                break;
            case "<":
                $this->query = " $columnName < $valueName";

                break;
            case ">=":
                $this->query = " $columnName >= $valueName";   

                break;
            case "<=":
                $this->query = " $columnName <= $valueName";

                break;
            default:
                break;
        }
        
        return $this->query;
    }
    
    /*
     * fungsi menampilkan table dengan berdasarkan karakter-karakter tertentu
     * dengan syarat memanggil fungsi select() terlebih dahulu
     * position = front , central , back
     */
    function like($columnName,$value,$position = 'front'){
        
        switch ($position) {
            case 'front':
                $this->query = " $columnName like  '$value%'";

                break;
            case 'central':
                $this->query = " $columnName like  '%$value%'";

                break;
            case 'back':
                $this->query = " $columnName like  '%$value'";

                break;
            default:
                $this->query = " $columnName like  '$value%'";
                break;
        }
        
        return $this->query;
    }
    
    /*
     * fungsi menampilkan table dengan berdasarkan tidak seperti karakter tersebut
     * dengan syarat memanggil fungsi select() terlebih dahulu
     * position = front , central , back
     */
    function unlike($columnName,$value,$position = 'front'){
        
        switch ($position) {
            case 'front':
                $this->query = " $columnName not like  '$value%'";

                break;
            case 'central':
                $this->query = " $columnName not like  '%$value%'";

                break;
            case 'back':
                $this->query = " $columnName not like  '%$value'";

                break;
            default:
                $this->query = " $columnName not like  '$value%'";
                break;
        }
        
        return $this->query;
    }
    
    
    /*
     * mengurutkan data berdasarkan column yang bersangkutan
     * typesorting = asc , desc -> default asc
     */
    public function sorting($columnName,$typeSorting = 'ASC'){
        
        if($typeSorting == 'ASC' || $typeSorting == 'DESC'){
            $this->query = " order by $columnName $typeSorting";
        }else{
            $this->query = " order by $columnName ASC";
        }
        
        return $this->query;
    }
    
    /*
     * group data berdasarkan dari kolom
     */
    function grouping($columnname) {
        $this->query = " group by $columnname";
        
        return $this->query;
    }
    
    /*
     * pembatasan data berdasarkan pada nilai awal column
     */
    public function limit($firstColumn,$lastColumn){
        $this->query = " limit $firstColumn,$lastColumn";
        
        return $this->query;
    }
}
