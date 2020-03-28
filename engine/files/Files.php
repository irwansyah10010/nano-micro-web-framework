<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace engine\files;

/**
 * Description of Files
 *
 * @author Irwansyah
 */

class Files {
    protected $file = null;
            
    function upload($filename,$new_name,$folder){
        $pesan="";

        $allowed_ext = array('jpeg','png','jpg','JPEG','PNG','JPG');
        $file_name = $_FILES[$filename]['name'];

        $file_ext = explode(".", $file_name);

        $file_size = $_FILES[$filename]['size'];
        $file_temp = $_FILES[$filename]['tmp_name'];

        $panjang = count($file_ext) - 1;

        $file_ext_new = $file_ext[$panjang];

        $file = $folder.$new_name.'.'.$file_ext_new;
        $lokasi = "../files/".$folder.$new_name. '.' .$file_ext_new;
        
        $in = move_uploaded_file($file_temp, $lokasi);

        if (in_array($file_ext_new, $allowed_ext) === true) {
            if ($file_size < 1044070) {
                $file = $folder.$new_name.'.'.$file_ext_new;
                $lokasi = "../files/".$folder.$new_name. '.' .$file_ext_new;
                
                $in = move_uploaded_file($file_temp, $lokasi);
                
                if ($in){
                    $pesan = '';
                }else{
                    
                }
            } else {
                $pesan = 'File error: besar maksimal 1 MB';
                
            }
        } else {
            $pesan = 'ekstensi file tidak di izinkan';
            
        }
        

        $uploadArray = array('pesan' => $pesan,'file' => $file);

        return $uploadArray;
    }
    
    function createFile($filename,$content,$message = ''){
        $boolean = 0;
        if(!file_exists($filename)){
            $this->file = fopen($filename, 'a+');
            fwrite($this->file, $content);
            echo $message;
            $boolean = 1;

            fclose($this->file);
        }
        return $boolean;
    }
    
    function updateFile($filename,$data,$message = ''){
        $boolean = 0;
        if(!file_exists($filename)){
            $this->file = fopen($filename, 'w+');
            fwrite($this->file, $data);
            echo $message;
            $boolean = 1;

            fclose($this->file);
        }
        
        return $boolean;
    }

    function assets($filename){
        return $this->json->getValue($this->loader->loaderFile('environment.json'), 'App', 'App_import').$filename;
    }

    function getFiles($filename){
        return $this->json->getValue($this->loader->loaderFile('environment.json'), 'App', 'App_files').$filename;
    }
    
}
