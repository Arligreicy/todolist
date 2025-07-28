<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class USUARIOModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public $IDUSUARIO;
    public $NOME;
    public $SENHA;
    public $DATACAD;

    /*  -------------------  Métodos de Banco  -------------------  */

    function inserir() {
        $dados_inserir = $this;
        unset($dados_inserir->IDUSUARIO);

        $query = $this->db->insert("USUARIO", $dados_inserir);

        if ($query) {
            return $this->db->insert_id(); 
        } else {
            return false;
        }
    }// Fim da função inserir

    function listar() {

        $query = $this->db->query("SELECT * FROM USUARIO");
        
        return $query->result();

    }// Fim da função listar

    function carregar() {

        $query = $this->db->query("SELECT * FROM USUARIO WHERE IDUSUARIO = ?", array($this->IDUSUARIO));
        $resultado = $query->result();

        if (count($resultado) > 0) {
            foreach ($query->list_fields() as $field) {
                $this->$field = $resultado[0]->$field;
            }
            return true;
        } else {
            return false;
        }

    } // Fim da função carregar

   function autenticar($nome, $senha) {
    $sql = "SELECT * FROM USUARIO WHERE NOME = ?";
    $query = $this->db->query($sql, array($nome));
    $resultado = $query->result();

    
    if (count($resultado) > 0) {
        $usuario = $resultado[0];
       
        if (password_verify($senha, $usuario->SENHA)) {
            foreach ($query->list_fields() as $field) {
                $this->$field = $usuario->$field;
            }
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

    function excluir() {

        $sql = "DELETE FROM USUARIO WHERE IDUSUARIO = ?";
        $query = $this->db->query($sql, array($this->IDUSUARIO));
        return $query;

    } // Fim da excluir

}
?>