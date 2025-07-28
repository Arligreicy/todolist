<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct(){

            parent::__construct();

            date_default_timezone_set('America/Sao_paulo');
                
            session_start();

        }

        function index(){

             $this->load->view('LoginView.php');

        }//Fim da função login

        
    }

?>