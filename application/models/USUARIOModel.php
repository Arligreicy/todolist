<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class USUARIOModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public $IDUSUARIO;
    public $NOME;
    public $SENHA;
    public $STATUS;
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

    function listar($filter = ""){

        $this->db->from('USUARIO');

        // Aplicar filtros dinâmicos, se existirem
        if ($filter != '') {
            foreach ($filter as $f) {
                $campo = $f['field'];
                $operador = $f['type']; // '=', 'LIKE', '>=', etc.
                $valor = $f['value'];

                if ($campo === 'compare') {
                    $this->db->where($valor, null, false);
                } else {
                    // LIKE deve ser tratado de forma especial
                    if (strtoupper(trim($operador)) == 'LIKE') {
                        $this->db->like($campo, $valor);
                    } else {
                        $this->db->where("$campo $operador", $valor);
                    }
                }
            }
        }

        // Executa a query
        $query = $this->db->get();
        return $query->result();
    } // Fim da função listar


    function listar_ajax($page, $size, $offset, $filter = "", $sort = "") {

        $this->db->select("USUARIO.*");
        $this->db->from("USUARIO");

        // Filtros dinâmicos
        if ($filter != '') {
            foreach ($filter as $f) {
                $campo = $f['field'];
                $operador = $f['type'];
                $valor = $f['value'];

                if ($campo === 'compare') {
                    $this->db->where($valor, null, false);
                } else {
                    if (strtoupper(trim($operador)) == 'LIKE') {
                        $this->db->like($campo, $valor);
                    } else {
                        $this->db->where("$campo $operador", $valor);
                    }
                }
            }
        }

        // Ordenação
        if ($sort != '') {
            $this->db->order_by($sort[0]['field'], $sort[0]['dir']);
        } else {
            $this->db->order_by("USUARIO.IDUSUARIO", "desc");
        }

        // Paginação (limit e offset)
        $this->db->limit($size, $offset);

        // Executa a query
        $query = $this->db->get();
        return $query->result();

    } // Fim da função listar_ajax

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

    function atualizar(){
	
		$sql = "UPDATE 
					USUARIO
					
				SET
					NOME = ?,
					SENHA = ?,
					STATUS = ?,
					DATACAD = ?
				
					
				WHERE
					IDUSUARIO = ?";			
		
		$query = $this->db->query($sql, array($this->NOME,
											  $this->SENHA,
											  $this->STATUS,
											  $this->DATACAD,
											  $this->IDUSUARIO));
		
		return $query;
	
	}//Fim da função atualizar

}
?>