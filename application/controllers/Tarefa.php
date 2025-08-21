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

	function carregartarefa($id) {

		header('Content-Type: application/json');

		if (!is_numeric($id)) {
			echo json_encode(['sucesso' => false, 'mensagem' => 'ID inválido']);
			return;
		}

		$this->load->model("TAREFAModel");
		$t = $this->TAREFAModel;
		$t->IDTAREFA = $id;

		if ($t->carregar()) {
			// Prepara os dados para o retorno
			$dados = [
				'IDTAREFA' => $t->IDTAREFA,
				'TITULO' => $t->TITULO,
				'DESCRICAO' => $t->DESCRICAO,
				'JUSTIFICATIVA' => $t->JUSTIFICATIVA,
				'IDCATEGORIA' => $t->IDCATEGORIA,
				'STATUS' => $t->STATUS,
				'PRAZO' => $t->PRAZO
			];

			echo json_encode($dados);
		} else {
			echo json_encode(['sucesso' => false, 'mensagem' => 'Tarefa não encontrada']);
		}
	}

	function atualizar($id) {

		header('Content-Type: application/json');
		
		$this->load->model("TAREFAModel");
		$t = $this->TAREFAModel;
		$t->IDTAREFA = $id;
		$t->carregar();
			
		if (!$t->IDTAREFA) {
			echo json_encode(['sucesso' => false, 'mensagem' => 'Tarefa não encontrada']);
			return;
		}

		// Atualiza os campos
		$t->STATUS = $this->input->post("status");
		$t->TITULO = $this->input->post("titulo");
		$t->DESCRICAO = $this->input->post("descricao");
		$t->JUSTIFICATIVA = $this->input->post("justificativa");
		$t->IDCATEGORIA = $this->input->post("idcategoria");
		$t->PRAZO = $this->input->post("prazo");
		$t->IDTAREFA = $id;

		if ($t->atualizar()) {
			echo json_encode(['sucesso' => true]);
		} else {
			echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao atualizar a tarefa.']);
		}
	}//Fim da função atualizar

	function inserir() {

		header('Content-Type: application/json');

		$this->load->model("TAREFAModel");
		$t = $this->TAREFAModel;

		// Preenche os campos do model
		$t->TITULO = $this->input->post("titulo");
		$t->DESCRICAO = $this->input->post("descricao");
		$t->JUSTIFICATIVA = $this->input->post("justificativa");
		$t->PRIORIDADE = $this->input->post("prioridade");
		$t->STATUS = 'pendente'; // Status inicial
		$t->PRAZO = $this->input->post("prazo");
		$t->IDUSUARIO = $_SESSION['idusuario']; // ID do usuário logado
		$t->IDCATEGORIA = $this->input->post("categoria");
		$t->DATACRIACAO = date('Y-m-d H:i:s'); 
		$t->DATACONCLUSAO = null; // Inicialmente nulo

		if ($t->inserir()) {
			echo json_encode(['sucesso' => true]);
		} else {
			echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao cadastrar tarefa.']);
		}
		
	} // Fim da função inserir
	
	function excluir($id) {

		header('Content-Type: application/json');

		if (!is_numeric($id)) {
			echo json_encode(['sucesso' => false, 'mensagem' => 'ID inválido']);
			return;
		}

		$this->load->model("TAREFAModel");
		$t = $this->TAREFAModel;
		$t->IDTAREFA = $id;

		if ($t->excluir()) {
			echo json_encode(['sucesso' => true]);
		} else {
			echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao excluir a tarefa.']);
		}
		
	} // Fim da função excluir
}












