<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TAREFAModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public $IDTAREFA;
    public $TITULO;
    public $DESCRICAO;
    public $PRIORIDADE;
    public $STATUS;
    public $PRAZO;
    public $DATACRIACAO;
    public $DATACONCLUSAO;
    public $JUSTIFICATIVA;
    public $IDUSUARIO;
    public $IDCATEGORIA;

    /*  -------------------  Métodos de Banco  -------------------  */

    function inserir() {
        $dados_inserir = $this;
        unset($dados_inserir->IDTAREFA);

        $query = $this->db->insert("TAREFA", $dados_inserir);

        if ($query) {
            return $this->db->insert_id(); 
        } else {
            return false;
        }
    }// Fim da função inserir

    function listar($filter = "") {

        $this->db->select("TAREFA.*, 
                        USUARIO.NOME AS NOMEUSUARIO, 
                        CATEGORIA.NOME AS NOMECATEGORIA,
						TAREFA.DESCRICAO AS DESCRICAO");
        $this->db->from('TAREFA');
        $this->db->join('USUARIO', 'USUARIO.IDUSUARIO = TAREFA.IDUSUARIO', 'left');
        $this->db->join('CATEGORIA', 'CATEGORIA.IDCATEGORIA = TAREFA.IDCATEGORIA', 'left');


        if (!empty($filter)) {
            foreach ($filter as $f) {
                $campo = $f['field'];
                $operador = $f['type'];
                $valor = $f['value'];

                if ($campo === 'compare') {
                    $this->db->where($valor, null, false);
                } else {
                    $this->db->where("$campo $operador", $valor);
                }
            }
        }

        $query = $this->db->get();
        return $query->result();

    }// Fim da função listar

	function listar_ajax($page, $size, $offset, $filter = "", $sort = []) {

		$this->db->select("TAREFA.*, 
						USUARIO.NOME AS NOMEUSUARIO, 
						CATEGORIA.NOME AS NOMECATEGORIA,
						TAREFA.DESCRICAO AS DESCRICAO");
		$this->db->from('TAREFA');
		$this->db->join('USUARIO', 'USUARIO.IDUSUARIO = TAREFA.IDUSUARIO', 'left');
		$this->db->join('CATEGORIA', 'CATEGORIA.IDCATEGORIA = TAREFA.IDCATEGORIA', 'left');

		// Filtros dinâmicos
		if (!empty($filter)) {

			foreach ($filter as $f) {
				$campo = $f['field'];
				$operador = $f['type'];
				$valor = $f['value'];

				if ($campo === 'compare') {
					$this->db->where($valor, null, false);
				} else {
					$this->db->where("$campo $operador", $valor);
				}
			}
		}
		// Ordenação
		if (!empty($sort) && isset($sort[0]['field'], $sort[0]['dir'])) {
			$campo_sort = $sort[0]['field'];
			$direcao = $sort[0]['dir'];

			// Evita erro de tipos em campos como DESCRICAO (MS SQL Server)
			if ($campo_sort === 'DESCRICAO') {
				$campo_sort = "CONVERT(VARCHAR(MAX), TAREFA.DESCRICAO)";
				$this->db->order_by($campo_sort, $direcao, false); // não escapa
			}

			$this->db->order_by($campo_sort, $direcao);
		} else {
			$this->db->order_by("TAREFA.IDTAREFA", "desc");
		}

		// Paginação
		$this->db->limit($size, $offset);

		$query = $this->db->get();
		return $query->result();
		
	}//Fim da função listar_ajax

    
    function atualizar(){
	
		$sql = "UPDATE 
					TAREFA
					
				SET
					TITULO = ?,
					DESCRICAO = ?,
                    PRIORIDADE = ?,
					STATUS = ?,
                    PRAZO = ?,
                    DATACRIACAO = ?,
					DATACONCLUSAO = ?,
                    JUSTIFICATIVA = ?,
					IDUSUARIO = ?,
					IDCATEGORIA = ?
										
				WHERE
					IDTAREFA = ?";			

		$query = $this->db->query($sql, array($this->TITULO,
											  $this->DESCRICAO,
											  $this->PRIORIDADE,
											  $this->STATUS,
											  $this->PRAZO,
											  $this->DATACRIACAO,
											  $this->DATACONCLUSAO,
                                              $this->JUSTIFICATIVA,
											  $this->IDUSUARIO,
											  $this->IDCATEGORIA,
										
											  $this->IDTAREFA));

		return $query;
	
	}//Fim da função atualizar

    function excluir() {

        $sql = "DELETE FROM TAREFA WHERE IDTAREFA = ?";
        $query = $this->db->query($sql, array($this->IDTAREFA));
        return $query;

    } // Fim da excluir

}
?>