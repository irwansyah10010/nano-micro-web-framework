<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace engine\abstraction;

use engine\database\BasicQuery;
use engine\database\Connection;
use engine\database\order\DMLQuery;
use engine\errors\ErrorCode;
use engine\Loader;

abstract class Model{
    // var untuk pengenalan class lainnya
    
    private $con,$bq,$loader,$dml;
    private $stmt = "";
    
    // Data yang di gunakan untuk pengenalan data pada class model
    private $tableName="";
    private $fieldTable="";
    private $query="";
    private $primaryKey="";
    private $foreignKey = "";
    
    /*
     *  variabel array untuk penyisipan data di luar kelas model
     * variabel array di sesuaikan dengan variabel dari isi tabel dari sub kelas model
     * untuk tambah, edit dan delete
     */
    public $fields;
    
    // variabel pembantu
    public $column = 'None',$sort = 'None';
    
    // inisialisasi kelas 
    function initial() {
        $this->bq = new BasicQuery();
        $this->con = new Connection();
        $this->dml = new DMLQuery();
        $this->loader = new Loader();
        
    }
    
    /***************************************************************************
     * fungsi set dan get
     * 
     **************************************************************************/
    
    // Mengatur nama tabel yang di buat
    function setTable($tableName) {
        $this->tableName = $tableName;
    }
    
    // mendapatkan nama tabel yang di buat
    function getTable() {
        return $this->tableName;
    }
    
    // mengatur field table yang di buat
    function setField($fieldTable) {
        $this->fieldTable = $fieldTable;
    }
    
    private function getField() {
        return $this->fieldTable;
    }
    
    // mengatur primary key
    function setPrimaryKey($primaryKey) {
        $this->primaryKey = $primaryKey;
    }
    
    function setForeignKey($foreignKey){
        $this->foreignKey = $foreignKey;
    }
    
    private function getPrimaryKey() {
        return $this->primaryKey;
    }

    /***************************************************************************
     * Data Manipulation Language 1
     * Save Edit and Delete
     * menyimpan data ke database
     **************************************************************************/
    
    // save data
    function save(){
        if($this->getField() == ""){
            ErrorCode::setMessage("Field is null");
            $this->loader->loaderPage(ErrorCode::getPageError(), ErrorCode::getLocationError());
        }else if($this->getTable() == ""){
            ErrorCode::setMessage("Table is null");
            $this->loader->loaderPage(ErrorCode::getPageError(), ErrorCode::getLocationError());
        }else{
            
            $this->query = $this->bq->insert($this->getTable(), $this->getField());
            echo "$this->query";
            
            try{
                $this->stmt = $this->con->getConnection()->prepare($this->query);
                $this->stmt->execute($this->fields);
                
            }catch (\PDOException $ex) {
                ErrorCode::setMessage('on File '.$_SERVER['REQUEST_URI'].'<br>'.$ex->getMessage());
                $this->loader->loaderPage(ErrorCode::getPageError(), ErrorCode::getLocationError());
            }
        }
    }
    
    /*
     *  memperbarui data tabel berdasarkan primary key
     *  $id = nilai data
     */
    function update($id,$type = ''){
        // akan ada penyelesaian menggunakan class error
        
        if($type == 'string'){
            $id = "'".$id."'";
        }

        if($this->getField() == ""){
            echo "Field table belum di isi";
        }else if($this->getTable() == ""){
            echo "Nama table belum di isi";
        }else{
            $this->query = $this->bq->update($this->getTable(), $this->getField(), $this->primaryKey,$id);
            try{
                
                $this->stmt = $this->con->getConnection()->prepare($this->query)->execute($this->fields);
                
            } catch (\PDOException $ex) {
                ErrorCode::setMessage('on File '.$_SERVER['REQUEST_URI'].'<br>'.$ex->getMessage());
                $this->loader->loaderPage(ErrorCode::getPageError(), ErrorCode::getLocationError());
            }
        }
    }
    
    /* menghapus data berdasarkan primary key
     * id = nilai data
     */
    function remove($id,$type = '') {
        // akan ada penyelesaian menggunakan class error
        
        if($type == 'string'){
            $id = "'".$id."'";
        }

        if($this->getField() == ""){
            echo "Field table belum di isi";
        }else if($this->getTable() == ""){
            echo "Nama table belum di isi";
        }else{

            $this->query = $this->bq->delete($this->getTable(), $this->primaryKey,$id);
            
            try{
                $this->stmt = $this->con->getConnection()->prepare($this->query)->execute();
            } catch (\PDOException $ex) {
                ErrorCode::setMessage('on File '.$_SERVER['REQUEST_URI'].'<br>'.$ex->getMessage());
                $this->loader->loaderPage(ErrorCode::getPageError(), ErrorCode::getLocationError());
            }
        }
    }
    // end DML1
    
    /***************************************************************************
     * Data Manipulation Language 2 
     * Select data
     *//////////////////////////////////////////////////////////////////////////
    
    /*
     * membaca keseluruhan data yang ada di tabel
     */
    function readAll($column='None',$sort = 'None') {
        $this->orderBy($column, $sort);
        $this->query = $this->bq->selectAll($this->getTable(), $this->column, $this->sort);
        try{
            $this->stmt = $this->con->getConnection()->prepare($this->query);
            $this->stmt->execute();
        } catch (\PDOException $ex) {
            ErrorCode::setMessage('on File '.$_SERVER['REQUEST_URI'].'<br>'.$ex->getMessage());
            $this->loader->loaderPage(ErrorCode::getPageError(), ErrorCode::getLocationError());
        }
    }
    
    function read($firstData,$lastData,$columnName = '',$valueName='',$sort ='') {
        $this->query = $this->bq->select($this->getTable(), $firstData, $lastData,$columnName,$valueName,$sort);
        try{
            $this->stmt = $this->con->getConnection()->prepare($this->query);
            $this->stmt->execute();
        } catch (\PDOException $ex) {
            ErrorCode::setMessage('on File '.$_SERVER['REQUEST_URI'].'<br>'.$ex->getMessage());
            $this->loader->loaderPage(ErrorCode::getPageError(), ErrorCode::getLocationError());
        }
    }
    
    // membaca desc dari tabel
    function describeTable() {
        $this->query = $this->bq->describe($this->tableName);
        try{
            $this->stmt = $this->con->getConnection()->prepare($this->query);
            $this->stmt->execute();
            
        } catch (Exception $ex) {
            ErrorCode::setMessage('on File '.$_SERVER['REQUEST_URI'].'<br>'.$ex->getMessage());
            $this->loader->loaderPage(ErrorCode::getPageError(), ErrorCode::getLocationError());
        }
    }
    
    private function orderBy($column,$sort) {
        $this->column = $column;
        $this->sort = $sort;
    }
    
    // memanggil statement yang sudah di buat
    function getStatement() {
        return $this->stmt;
    }
    
    // membaca jumlah data yang ada di tabel
    function readSum() {
        $total = 0;
        $this->query = $this->bq->selectCount($this->getTable());
        try{
            $this->stmt = $this->con->getConnection()->prepare($this->query);
            $this->stmt->execute();
            while($row = $this->stmt->fetch()){
                $total = $row[0];
            }
        } catch (Exception $ex) {
            ErrorCode::setMessage('on File '.$_SERVER['REQUEST_URI'].'<br>'.$ex->getMessage());
            $this->loader->loaderPage(ErrorCode::getPageError(), ErrorCode::getLocationError());
        }
        return $total;
    }
    
    /***************************************************************************
     * Data Manipulation Language 3 (Renew) 
     * Select data
     **************************************************************************/
    
    /*
     * fungsi eksekusi
     */
    function ready(){
        try{
            $this->stmt = $this->con->getConnection()->prepare($this->query);
            $this->stmt->execute();
        } catch (\PDOException $ex) {
            ErrorCode::setMessage('on File '.$_SERVER['REQUEST_URI'].'<br>'.$ex->getMessage());
            $this->loader->loaderPage(ErrorCode::getPageError(), ErrorCode::getLocationError());
        }
    }
    
    function tesQuery() {
        return $this->query;
    }
    
    /*
     * fungsi untuk menampilkan tabel berdasarkan nama table dengan memperbolehkan 
     * nilai kolom ganda tampil ataupun tidak bergnatung dari parameter distinct.
     * 
     * isi parameter 
     * tablename = nama tabel yang dipilih
     * distinct = no, distinct
     */
    public function select($tablename,$distinct = 'no'){
        if($distinct == 'no'){
            $this->query = $this->query = $this->dml->select($tablename);
        }else if($distinct == 'distinct'){
            $this->query = $this->query = $this->dml->selectDistinct($tablename);
        }else{
            $this->query = $this->query = $this->dml->select($tablename);
        }
        
        return $this;
    }
    
    /*
     * fungsi yang digunakan sebagai penghubung atau pun untuk query yang lumayan
     * rumit. 
     * berikut yang dimaksud dengan penghubung = where,between, and, or, having
     */
    public function queryCustom($link){
        $this->query .=" $link";
        return $this;
    }

    public function where(){
        $this->query .= " where";
        
        return $this;
    }

    public function between(){
        $this->query .= " between";
        
        return $this;
    }

    public function and(){
        $this->query .= " and";
        
        return $this;
    }

    public function or(){
        $this->query .= " or";
        
        return $this;
    }

    public function having(){
        $this->query .= " having";
        
        return $this;
    }
    
    public function join($table,$column1,$column2){
        $this->query .= " join $table ON $column1 = $column2";
        
        return $this;
    }
    /*
     * fungsi yang digunakan sebagai penyeleksi value dari kolom yang digunakan 
     * untuk menampilkan data, dengan syarat memanggil fungsi select() terlebih 
     * dahulu.
     * 
     * comparing = memilih operator sama dengan, tidak sama dengan ataupun lebih 
     * dan kurang dari, dengan nilai default : =. nilainya : > < = >= <= !=.
     */
    public function comparing($columnName,$value,$comparing='='){
        
        switch ($comparing) {
            case '=':
                $this->query .= $this->dml->equalColumn($columnName,$value);
                break;
            case '!=':
                $this->query .= $this->dml->notequalColumn($columnName,$value);
                break;
            case '>':
                $this->query .= $this->dml->operatorColumn($columnName,$value,'>');

                break;
            case '<':
                $this->query .= $this->dml->operatorColumn($columnName,$value,'<');

                break;
            case '>=':
                $this->query .= $this->dml->operatorColumn($columnName,$value,'>=');

                break;
            case '<=':
                $this->query .= $this->dml->operatorColumn($columnName,$value,'<=');

                break;
            default:
                break;
        }
        return $this;
    }
    
    /*
     * fungsi penyeleksi kolom berdasarkan karakter dengan syarat memanggil 
     * fungsi select() terlebih dahulu
     * 
     * type = like, unlike
     * position = front , central , back
     */
    public function searchCharacter($columnName,$value,$type='like',$position='front') {
        
        if($type == 'like'){
            $this->query .= $this->dml->like($columnName,$value,$position);
        }else if($type == 'unlike'){
            $this->query .= $this->dml->unlike($columnName,$value,$position);
        }else{
            $this->query .= $this->dml->like($columnName,$value,$position);
        }
        
        return $this;
    }
    
    /*
     * mengurutkan data berdasarkan column yang bersangkutan
     * typesorting = asc , desc -> default asc
     */
    public function sorting($columnName,$typeSorting = 'ASC'){
        $this->query .= $this->dml->sorting($columnName,$typeSorting);
        
        return $this;
    }
    
    /*
     * group data berdasarkan dari kolom
     */
    function grouping($columnname) {
        $this->query .= $this->dml->grouping($columnname);
        
        return $this;
    }
    
    /*
     * pembatasan data berdasarkan pada nilai awal column
     */
    public function limit($firstColumn,$lastColumn){
        $this->query .= $this->dml->limit($firstColumn,$lastColumn);
        
        return $this;
    }
}

