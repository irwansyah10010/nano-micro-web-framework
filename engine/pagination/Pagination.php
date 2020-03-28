<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace engine\pagination;

/**
 * Description of Pagination
 *
 * @author Irwansyah
 */
use engine\database\Connection;
use engine\pagination\Filter;

class Pagination {
    //put your code here
    private $con,$filter;
    private $amountArticle,$sql,$page,$pages,$total;
    
    public function __construct() {
        $this->con = new Connection();
        $this->filter = new Filter();
    }
    
    public function setSql($sql) {
        $this->sql = $sql;
    }
    
    public function getSql() {
        return $this->sql;
    }
    
    /*
     * Mendapatkan total jumlah total baris dari tabel
     * parameter $table = nama tabel atau view, tidak cocok untuk tabel berelasi.
     *  
     * 
     */
    public function setTotal($table){
        $sql = "SELECT count(*) from $table";
        $statement = $this->con->getConnection()->prepare($sql);
        $statement->execute();
        
        $result = $statement->fetch();
        
        $this->total = $result[0];
    }
    
    public function getTotal() {
        return $this->total;
    }
    
    /*
     * mengatur banyaknya artikel atau baris yang ditampilkan
     */
    public function setAmountArticle($amountArticle){
        $this->amountArticle = $amountArticle;
    }
    
    /*
     * mendapatkan nilai dari artikel jumlah artikel
     */
    public function getAmountArticle(){
        return $this->amountArticle;
    }
    
    /*
     * mengatur no page yang di dapat
     */
    public function setPage($page){
        $this->page = $page;
    }  
    
    /*
     * mendapatkan no page yang di dapat
     */
    public function getPage(){
        return $this->page;
    }
    
    /*
     * mendapatkan nilai pertama dari tiap page
     */
    public function getFirst(){
        return ($this->page > 1) ? ($this->page * $this->amountArticle) - $this->amountArticle : 0;
    }
    
    public function getPages(){
        return ceil($this->total/$this->amountArticle);
    }
    
    /*
     * melanjutkan ke halaman selanjutnya
     */
    public function next($id,$key=''){
        $this->page = $id;
        
        $this->page += 1;
        
        return $this->page;
    }
    
    /*
     * mengembalikan ke halamamn 
     */
    public function preview($id,$key='') {
        $this->page = $id;
        
        $this->page -= 1;
        
        return $this->page;
    }
    
}
