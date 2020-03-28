<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace engine\console;

use engine\utility\ArrayManipulation;
use engine\utility\JsonManipulation;

use engine\database\order\DDLQuery;
use engine\database\order\DMLQuery;
use engine\database\Connection;
use engine\database\order\OtherQuery;

use engine\files\Files;
use engine\console\Keyword;
use engine\Loader;

class Rules {
    // varibel init
    protected $keyword,
            $arrayManipulation,$jsonManipulation,
            $files,$loader,
            $ddl,$dml,$con,$other;
    
    // Method yang tersedia
    protected $method;
    
    /* Type yang tersedia
    protected $type = ['controller','model','view','configuration','add']; 
    
    // Alur susunan argument console
    protected $flow = ['method','type','name']; */
    
    // Alur susunan argument beserta isi dari alur yang tersedia
    protected $flows = array();
    
    // Alur argument yang sesuai
    protected $flowAgree = array();

    // Nama dari file atau konfigurasi yang digunakan
    protected $name;
    
    // Array untuk menampung variabel argument
    protected $argument = array();
    
    // nilai maksimal dari argument
    protected $maxArgument = 4;


    public function __construct() {
        $this->keyword = new Keyword();
        
        $this->arrayManipulation = new ArrayManipulation();
        $this->jsonManipulation = new JsonManipulation();
        $this->files = new Files();
        $this->loader = new Loader();
        $this->ddl = new DDLQuery();
        $this->dml = new DMLQuery();
        $this->other = new OtherQuery();
        $this->con = new Connection();
        
        /*
        $this->flows = ['method' => $this->getMethodAll(),'type' => $this->getTypeAll()];
        */
        
       $this->method = $this->keyword->method1;
        
        $this->flowAgree = $this->keyword->subMethod;
    }
    
    public function setArgument($argument){
        $this->argument = $argument;
    }
    
    public function getArgument($key){
        $argv = $this->arrayManipulation->getArrayValue($this->argument, $key,'2D');
        
        return $argv;
    }
    
    public function countArgument() {
        return count($this->argument);
    }
    
    function getMaxArgument() {
        return $this->maxArgument;
    }
    
    public function getMethod($key) {
        $method = $this->arrayManipulation->getArrayValue($this->method, $key,'2D');
        
        return $method;
    }
    
    public function getMethodAll(){
        return $this->method;
    }
    
    /*
    public function getType($key) {
        return $this->arrayManipulation->getArrayValue($this->type, $key,'2D');
    }
    
    public function getTypeAll(){
        return $this->type;
    }
    
    // mengembalikan nilai flow
    public function getFlowAll() {
        return $this->flow;
    }
    */
    
    // mengembalikan nilai flow dengan kunci dan subkunci
    public function getFlowAgree($key,$keysub ='none') {
        $flows = '';
        if($keysub == 'none'){
            $flows = $this->arrayManipulation->getArrayValue($this->flowAgree, $key, '2D');
        }else{
            $flows = $this->arrayManipulation->getArrayValue($this->flowAgree, $key, '2D',$keysub);
        }
        return $flows;
    }
    
    public function getFlowAgreeAll() {
        return $this->flowAgree;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    protected function getName() {
        return $this->name;
    }
    
    // eksekusi console
    function onReady($array) {
        switch ($array[1]) {
            
            // create
            case 'create':
                if(count($array) > 3){
                    
                    // view
                    if($array[2] == 'view'){
                        // membuat view
                        $class = explode('.', $array[3]);
                        $text = file_get_contents("engine/example/".$array[2]."Example");
                        $text2 = str_replace($array[2]."Example", $class[0], $text);

                        $this->files->createFile('public/'.$array[3],$text2,$array[2].' has Succesfull');
                        
                    // model
                    }else if($array[2] == 'model'){
                        
                        // membuat model
                        $class = explode('.', $array[3]);
                        $text = file_get_contents("engine/example/".$array[2]."Example");
                        $text2 = str_replace($array[2]."Example", $class[0], $text);


                        $record = $this->files->createFile($array[2].'/'.$array[3],$text2,$array[2].' has Succesfull');

                        if($record == 1){
                            // membuat data create table
                            $text = file_get_contents("engine/example/DatabaseExample");
                            $text2 = str_replace("databaseExample", $class[0], $text);

                            $this->files->createFile('database/'.$array[3],$text2,'');

                            // init model
                            require_once 'view/initial.php';
                            $in = new \Initial();
                            $arrayList = array();
                            foreach ($in->model as $key => $value){
                                $arrayList[] = "'$key' => '$value'";
                            }

                            $string = $arrayList[count($arrayList)-1];
                            $varbaru = "'$class[0]' => 'model'";

                            $tes = file_get_contents("view/initial.php");
                            $text = str_replace($string, $string.",\n\t$varbaru", $tes);
                            file_put_contents("view/initial.php", $text);    
                        }
                        
                        
                    // tables
                    }else if($array[2] == 'tables'){
                        $method = explode("@", $array[3]);

                        // create table
                        if(file_exists("database/$method[0].php")){
                            require_once 'database/'.$method[0].'.php';
                            $column = "";
                            $objek = new $method[0];    
                            if(method_exists("$method[0]","create")){
                                $objek->create();

                                $desc = $this->other->describe($method[0]);
                                $this->other->execute($desc);

                                while($row = $this->other->getStatement()->fetch()){
                                    $column .= $row[0]." ";
                                }
                                echo $column;

                                // create file dml
                                $text = file_get_contents("engine/example/runningData");
                                $text2 = str_replace("runningData", $method[0]."Data", $text);
                                $text3 = str_replace("TandaTanya", $column, $text2);

                                $this->files->createFile('database/data/'.$method[0].'Data.php',$text3,'');
                            }

                        // tambah data
                        }else if(file_exists("database/data/$method[0].php")){
                            require_once 'database/data/'.$method[0].'.php';
                            $objek = new $method[0];
                            if(method_exists("$method[0]", "go")){
                                $objek->go();
                            }

                        }else{
                            echo "file $method[0].php not found";
                        }
                    // complete
                    }else if($array[2] == 'complete'){

                    
                    }else{
                        $class = explode('.', $array[3]);                    
                        $text = file_get_contents("engine/example/".$array[2]."Example");
                        $text2 = str_replace($array[2]."Example", $class[0], $text);

                        $this->files->createFile($array[2].'/'.$array[3],$text2,$array[2].' has Succesfull');
                        
                        if($array[2] == 'controller'){
                            
                            // init controller
                            require_once 'view/initial.php';
                            $in = new \Initial();
                            $arrayList = array();
                            foreach ($in->controller as $key => $value){
                                $arrayList[] = "'$key' => '$value'";
                            }

                            $string = $arrayList[count($arrayList)-1];
                            $varbaru = "'$class[0]' => 'controller'";

                            $tes = file_get_contents("view/initial.php");
                            $text = str_replace($string, $string.",\n \t$varbaru", $tes);
                            file_put_contents("view/initial.php", $text);
                        }
                        
                    }//end create
                }else{
                    // cek keyword semua type
                    // view
                    if($array[2] == 'view'){
                        $this->pola($array, "filename.php");
                        $this->komentar($this->keyword->view);
                    // model
                    }else if($array[2] == 'model'){
                        $this->pola($array, "filename.php");
                        $this->komentar($this->keyword->model);
                    // tables
                    }else if($array[2] == 'tables'){
                        $this->pola($array, "kelasName@eksekusiName");
                        $this->komentar($this->keyword->tables);
                    // complete
                    }else if($array[2] == 'complete'){
                        $this->pola($array, "filename.php");
                        $this->komentar(["Belum tersedia"]);
                    }else if($array[2] == 'controller'){
                        $this->pola($array, "filename.php");
                        $this->komentar($this->keyword->controller);
                    }
                }
                
                break;
            case 'update' :
                if(count($array) > 3){
                    if($array[2] == 'tables'){
                        $method = explode("@", $array[3]);

                        //alter tabel
                        if(file_exists("database/$method[0].php")){
                            require_once 'database/'.$method[0].'.php';
                            $objek = new $method[0];
                            if(method_exists("$method[0]", "alter")){
                                $objek->alter();
                            }
                        // update data
                        }else if(file_exists("database/data/$method[0].php")){
                            require_once 'database/data/'.$method[0].'.php';
                            $objek = new $method[0];
                            if(method_exists("$method[0]", "update")){
                                if(count($array) > 5){
                                    $objek->update($array[4],$array[5]);
                                }else{
                                    echo "column and key not null";
                                }

                            }
                        }else{
                            echo "file $method[0].php not found";
                        }
                    }
                }else{
                    // cek semua type 
                    if($array[2] == 'tables'){
                        $this->pola($array, "kelasName@eksekusiName");
                        $this->komentar($this->keyword->tables);
                    }
                }
                break;
                
            // remove
            case 'remove' :
                if(count($array) > 3){
                    if($array[2] == 'tables'){
                    
                        $method = explode("@", $array[3]);


                        // mengosongkan tabel
                        if(file_exists("database/$method[0].php")){
                            require_once 'database/'.$method[0].'.php';
                            $objek = new $method[0];

                            if(method_exists("$method[0]", "$method[1]")){
                                if($method[1] == "truncate"){
                                    $objek->truncate();
                                }else if($method[1] == "drop"){
                                    $objek->drop();
                                }
                            }
                        // hapus data
                        }else if(file_exists("database/data/$method[0].php")){
                            require_once 'database/data/'.$method[0].'.php';
                            $objek = new $method[0];

                            if(method_exists("$method[0]", "delete")){
                                if(count($array) > 5){
                                    $objek->delete($array[4],$array[5]);
                                }else{
                                    echo "column and key not null";
                                }
                            }
                        }else{
                            echo "file $method[0].php not found";
                        }
                    }
                }else{
                    // cek semua type 
                    if($array[2] == 'tables'){
                        $this->pola($array, "kelasName@eksekusiName");
                        $this->komentar($this->keyword->tables);
                    }
                }
                break;
                
            // list
            case 'list':
                require_once 'view/initial.php';
                
                $init = new \Initial();
                
                $arrayList = array();
                
                if($array[2] == 'libav'){
                    $this->showArray(["Nama Library","Lokasi Direktori"], $init->web);
                }else if($array[2] == 'model'){
                    $this->showArray(["Nama Model","Lokasi Direktori"], $init->model);
                }else if($array[2] == 'controller'){
                    $this->showArray(["Nama Controller","Lokasi Direktori"], $init->controller);
                }else if($array[2] == 'objek'){
                    $this->showArray(["Nama Objek","Lokasi Direktori"], $init->getter);
                }
                
                break;
            case 'query':
                require_once 'database/QueryCustoming.php';
                
                if($array[2] == 'eksekusi'){
                    $query = new \QueryCustoming();
                    $query->exe();
                }
                
                break;
            default:
                break;
        }
    }
    
    // fungsi untuk menampilkan keseluruhan array dengan 2 column
    function showArray($arrayHeader,$array) {
        $space = " ";
        
        $maxMethod = 0;
        $maxPenjelasan = 0;
        
        $header = $arrayHeader[0];
        $header2 = $arrayHeader[1];
        
        $garisBatas = " ";
        
           
        if(strlen($header) > $maxMethod){
            $maxMethod = strlen($header);
        }
        
        if(strlen($header2) > $maxPenjelasan){
            $maxPenjelasan = strlen($header2);
        }
        
        foreach ($array as $key => $value) {
            if(strlen($key) > $maxMethod){
                $maxMethod = strlen($key);
            }
            
            if(strlen($value) > $maxPenjelasan){
                $maxPenjelasan = strlen($value);
            }
        }
        
        // garis batas
        echo $space;
        for($i=0;$i < $maxMethod+$maxPenjelasan+3;$i++){
            echo $garisBatas;
        }
        // header
        echo "\n $header ";
        
        for($i=0;$i < $maxMethod - strlen($header);$i++){
            echo $space;
        }
        
        // header 2
        echo " $header2 ";
        
        for($i=0;$i < $maxPenjelasan - strlen($header2);$i++){
            echo $space;
        }
        
        echo " \n";
        
        // garis batas
        echo $space;
        for($i=0;$i < $maxMethod+$maxPenjelasan+3;$i++){
            echo $garisBatas;
        }
        echo "\n";
        
        foreach ($array as $key => $value) {
            echo " $key ";
            
            for($i=0;$i < $maxMethod - strlen($key);$i++){
                echo $space;
            }
            
            echo " $value ";
            
            for($i=0;$i < $maxPenjelasan - strlen($value);$i++){
                echo $space;
            }
            
            echo " \n";
        }
        
        // garis batas
        echo $space;
        for($i=0;$i < $maxMethod+$maxPenjelasan+3;$i++){
            echo $garisBatas;
        }
        echo "\n";
        
    }
    
    function pola($array,$content) {
        echo "Pola Console : PHP ".$array[0]." ".$array[1]." ".$array[2]." ".$content."\n";
    }
    
    function komentar($array){
        echo "Penjelasan : \n";
        foreach ($array as $value) {
            echo $value."\n\n";
        }
    }
    
    function queryChecked($param) {
        
    }

    function executeFunction(){

    }
}
