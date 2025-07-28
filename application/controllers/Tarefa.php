<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tarefa extends CI_Controller {

    public function __construct(){

            parent::__construct();

            date_default_timezone_set('America/Sao_paulo');
                
            session_start();

        }

    function listar(){

		$this->load->view("DashboardView.php");
        
	} // Fim da função listar

	function listar_ajax(){

		header('Content-Type: application/json');

        $this->load->model("TAREFAModel");
		$t = $this->TAREFAModel;

		//inputs do post que o Tabulator realiza
		$page = $this->input->post('page');
		$size = $this->input->post('size');
		$offset = ($page - 1) * $size;
		$filter = isset($_POST['filter']) ? $_POST['filter'] : "";
		$sort = isset($_POST['sort']) ? $_POST['sort'] : "";

		$total = count($t->listar($filter));
		$lastPage = ceil(count($t->listar($filter)) / $size);
		$resultado = $t->listar_ajax($page, $size, $offset, $filter, $sort);

		echo json_encode(["last_page"=> $lastPage, "data" => $resultado, "total" => $total]);

	}//Fim da função listar ajax

        
    }

?>












