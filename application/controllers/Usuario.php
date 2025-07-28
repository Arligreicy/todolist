<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

    public function __construct(){

            parent::__construct();

            date_default_timezone_set('America/Sao_paulo');
                
            session_start();

        }

        function login(){

            if (isset($_SESSION['login'])) {
                
                redirect(base_url("Tarefa/listar"));
            }
            $this->load->view('LoginView');
        }//Fim da função login

       function logar() {
        
            header('Content-Type: application/json');

            $this->load->model("USUARIOModel");
            $u = $this->USUARIOModel;

            $nome = $this->input->post("nome");
            $senha = $this->input->post("senha");

            // Chama a função que autentica e preenche os dados do usuário
            $u->autenticar($nome, $senha);

            if ($u->IDUSUARIO) {
                // Login OK
                $_SESSION['login'] = true;
                $_SESSION['idusuario'] = $u->IDUSUARIO;
                $_SESSION['nome'] = $u->NOME;

                echo json_encode([
                    "codigo" => "ok",
                    "mensagem" => "Login efetuado com sucesso, redirecionando..."
                ]);
            } else {
                // Login inválido
                echo json_encode([
                    "codigo" => "error",
                    "mensagem" => "Usuário ou senha incorretos!"
                ]);
            }
        } //Fim da função logar

        function logout(){

            session_destroy();
            redirect(base_url("Usuario/login"));

        }//Fim da função logout

         function cadastrar()
        {
            $this->load->view('CadastroView.php');

        } // Fim da função cadastrar

        function salvar_cadastro() {

             header('Content-Type: application/json');

            $nome = $this->input->post('nome');
            $senha = $this->input->post('senha');

            if (empty($nome) || empty($senha)) {
                echo json_encode(['status' => 'erro', 'mensagem' => 'Nome e senha são obrigatórios.']);
                return;
            }

            $this->load->model('USUARIOModel');
            $u = $this->USUARIOModel;
            $u->NOME = $nome;
            $u->SENHA = password_hash($senha, PASSWORD_DEFAULT);

            if ($u->inserir()) {
                echo json_encode(['status' => 'ok']);
            } else {
                echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao cadastrar usuário.']);
            }
        }

    }


?>