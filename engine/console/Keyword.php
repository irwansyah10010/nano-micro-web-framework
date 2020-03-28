<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace engine\console;

/**
 * Description of Keyword
 *
 * @author Irwansyah
 */
class Keyword {
    
    var $method1 = ['create','update','remove','list','query'];
    
    var $subMethod = 
            [
            'create' => ['controller','model','view','tables'], // complete
            'update' =>['tables'], // model
            'remove' =>['tables'], // model
            'list' =>['libav','model','controller','objek'],
            'query' => ['eksekusi']
        ];
    
    
    
    
    
    var $penjelasanMethod = 
            [
            'create' => 'membuat file komponen yang diperlukan', 
            'update' =>'memperbarui tables dan data tables',
            'remove' =>'menghapus tables dan data tables',
            'list' =>'menampilkan data-data yang tersedia',
            'query' => 'mengeksekusi script sql pada file QueryCustoming'
        ];
    
    var $model = [
        "Dalam membuat model sesuaikan nama filenya dengan objek nyata seperti Mahasiswa, Dosen.",
        "Setelah model berhasil dibuat, maka akan muncul file tabel yang digunakan untuk membuat tabel dalam folder database"
    ];
    
    var $controller = [
        "Dalam membuat controller bisa dibuat dengan nama file bebas namun "
        . "disarankan nama filenya didahulukan dengan objek nyata lalu diikuti "
        . "kata controller seperti MahasiswaController, DosenController."
    ];

    var $view =[
        "Dalam membuat view bisa dibuat dengan nama file bebas "
    ];
    
    var $tables = [
        "kelasName, nama kelas disesuaikan dengan file yang berada didalam folder database",
        "eksekusiName, nama eksekusi disesuaikan dengan method dari kelasname tersebut",
        "Tables terbagi menjadi dua bagian, yaitu pertama bagian mengelola table dan kedua bagian mengelola data table."
    ];
            
}
