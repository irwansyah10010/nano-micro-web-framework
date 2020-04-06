<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controller;


/**
 * Description of ControllerExample
 *
 * @author Irwansyah
 */

use model\ModelExample;
use engine\abstraction\Controller;

class ControllerExample extends Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    
    public function create(){
        $this->response->view('help/index');
    }
    
    public function save(){
        $namaDepan = $this->request->post('namaDepan','null');
        $namaBelakang = $this->request->post('namaBelakang','null');
        $umur = $this->request->post('umur','null');
        
        $exampleValidation = [
            $namaDepan => 'number/null',
            $namaBelakang => 'number/null',
            $umur => 'number/null'
        ];
        
        //$this->request->validation($exampleValidation);
        
        $model = new ModelExample();
        
        $model->fields = [$namaDepan,$namaBelakang,$umur];
        $model->save();
        
        $this->response->redirect('help/','data berhasil ditambah');
        
    }
    
    function update() {
        $id = $this->request->post('id','null');
        $namaDepan = $this->request->post('namaDepan','null');
        $namaBelakang = $this->request->post('namaBelakang','null');
        $umur = $this->request->post('umur','number');
        
        $model = new ModelExample();
        
        $model->fields = [$namaDepan,$namaBelakang,$umur];
        $model->update($id);
        
        $this->response->redirect('help/','data berhasil diperbarui');
    }
    
    function remove() {
        $id = $this->request->get(1);
        
        $model = new ModelExample();
        
        $model->remove($id);
        
        setcookie('akua', 'air seni kuda', time()+200,'/');
        
        $this->response->redirect('help/','data berhasil di hapus');
    }
    
    function search() {
        $colom = $this->request->post('sort','mhsID');
        $type = $this->request->post('type','ASC');
        
        echo $colom;
        echo $type;
        
        $this->response->redirect('help/1/column/'.$colom.'/tipe/'.$type.'/');
    }
}

?>