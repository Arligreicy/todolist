<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CATEGORIAModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public $IDCATEGORIA;
    public $NOME;
    public $IDUSUARIO;
   
    /*  -------------------  Métodos de Banco  -------------------  */

    function inserir() {
        $dados_inserir = $this;
        unset($dados_inserir->IDCATEGORIA);

        $query = $this->db->insert("CATEGORIA", $dados_inserir);

        if ($query) {
            return $this->db->insert_id(); 
        } else {
            return false;
        }
    }// Fim da função inserir

    function listar() {

        $query = $this->db->query("SELECT * FROM CATEGORIA");

        return $query->result();

    }// Fim da função listar

    function carregar() {

        $query = $this->db->query("SELECT * FROM CATEGORIA WHERE IDCATEGORIA = ?", array($this->IDCATEGORIA));
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

    function atualizar(){
	
		$sql = "UPDATE 
					CATEGORIA
					
				SET
					NOME = ?,
					IDUSUARIO = ?
										
				WHERE
					IDCATEGORIA = ?";			

		$query = $this->db->query($sql, array($this->NOME,
											  $this->IDUSUARIO,
											  $this->IDCATEGORIA));

		return $query;

    }//Fim da função atualizar

    function excluir() {

        $sql = "DELETE FROM CATEGORIA WHERE IDCATEGORIA = ?";
        $query = $this->db->query($sql, array($this->IDCATEGORIA));
        return $query;

    } // Fim da excluir

}
?>