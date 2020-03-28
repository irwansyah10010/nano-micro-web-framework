<?php

/*
 * init variabel dengan variabel random
 * jika menampilkan data berdasarkan kategori tertentu
 * route->get(url, view, acces)
 * route->get(url data -> url default namaprojek/public/,
 *            tampilan yang ingin digunakan bisa dengan halaman web atau controller dengan fungsi view dari objek response,
 *              hak akses dari halaman tersebut -> default bisa akses oleh semua, ['nama session' => 'value'] or ['nama session' => ['value1','value2','valueN']]);
 * route->post(url, view, button, acces)
 * route->post(url data -> url default namaprojek/public/,
 *            tampilan yang ingin digunakan bisa dengan halaman web atau controller dengan fungsi view dari objek response, nama tombol submit dari form,
 *              hak akses dari halaman tersebut -> default bisa akses oleh semua, ['nama session' => 'value'] or ['nama session' => ['value1','value2','valueN']]);
 * 
 */

use engine\http\Route;
use engine\http\Response;
use engine\errors\ErrorCode;
use engine\errors\SessionError;

class Routing{
    public $routes,$response;
    
    public function __construct() {
        
        
        
        $this->routes = new Route();
        $this->response = new Response();
        
        $route = $this->routes;

        /*
        * set error location
		* page error = halaman error
		* lokasi error = folder lokasi error
        */
        ErrorCode::setPageError("error-configuration.php");
        ErrorCode::setLocationError("view");

		/*
        * set Session Error location 
        */
        SessionError::setLocationSession('Logout/');

        /*
        * Add Route this
        */

       // homepage
       $route->get('', function (){
            $this->response->view('index');
       });

       /*
       $route->get('Mahasiswa/add/', function ($array){
           $array['id'] = 1;
           $array['sort'] = 'mhsID';
           $array['type'] = 'ASC';
           $this->response->view('home/Mahasiswa/formInput');
       },['name' => ['dwi']]);
       
       $route->post('addMahasiswa/', function (){
           $this->response->view('MahasiswaController&store');
       },'submit');


       $route->get('Mahasiswa/perbarui/(id)/', function ($array){
           $array['id'] = 1;
           $array['sort'] = 'mhsID';
           $array['type'] = 'ASC';
           $this->response->view('home/Mahasiswa/formPerbarui',$array);
       });
       
       $route->post('perbaruiMahasiswa/', function (){
           $this->response->view('MahasiswaController&update');
       },'submit');
       
       $route->get('hapusMahasiswa/(id)/', function ($array){
           $this->response->view('MahasiswaController&remove',$array);
       });

       $route->post('searchForm/', function (){
           $response->view('ControllerExample&search');
       },'search');
       */
       



       // End added route

       $route->checkRoute();
    }
}
?>