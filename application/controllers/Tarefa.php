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

	function listar_ajax() {

		header('Content-Type: application/json');

		$this->load->model("TAREFAModel");
		$t = $this->TAREFAModel;


		// inputs do post que o Tabulator realiza
		$page = $this->input->post('page');
		$size = $this->input->post('size');
		
		$offset = ($page - 1) * $size;
		$filter = isset($_POST['filter']) ? $_POST['filter'] : "";
		$sort = isset($_POST['sort']) ? $_POST['sort'] : "";
		
		$total = count($t->listar($filter));

		$lastPage = ceil($total / $size);

		$resultado = $t->listar_ajax($page, $size, $offset, $filter, $sort);
	
		// Esse echo json_encode nunca será executado com o exit acima
		echo json_encode(["last_page"=> $lastPage, "data" => $resultado, "total" => $total]);
	}

	function alterar_status(){
		
		header('Content-Type: application/json');

		$this->load->model("TAREFAModel");
		$t = $this->TAREFAModel;
		$t->IDTAREFA = $this->input->post("idtarefa");
		$t->carregar();

		if($t->STATUS == 'pendente'){
			$t->STATUS = 'concluida';
		}
		else if($t->STATUS == 'concluida'){
			$t->STATUS = 'pendente';
		}

		if($t->atualizar()){
			echo json_encode(['sucesso' => true]);
		}
		else{
			echo json_encode(['sucesso' => false,'mensagem' => 'Erro ao atualizar o status da tarefa.','debug' => $this->db->last_query() ]);
		}

	}//Fim da função alterar_status

	function carregartarefa() {

		$id = $this->input->post("id");

		$this->load->model("TAREFAModel");
		$t= $this->TAREFAModel;
		$t->IDTAREFA = $id;
		$dados = $t->carregar();

    	echo json_encode($dados);
	}

}












