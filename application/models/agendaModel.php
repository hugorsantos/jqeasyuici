<?php
/**
 * Classe que controla o model de agenda
 * @author hugo.hrs
 * @copyright Testes Data: 07/08/2013
 * @access public
 * @package controllers/agenda
 * @version 1.0
 */
class AgendaModel extends CI_Model {
	
    // table name
    private $tbl_agenda= 'agenda';
	
    function __construct(){
        parent::__construct();
    }
	
    /**
     * Metodo que retorna o total de registros na consulta
     * @return int
     */
    public function getCountListagem() {
       return $this->db->count_all($this->tbl_agenda);
    }
	
    /**
     * Metodo que retornas as informacoes para a listagem
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function getListagem($offset,$limit) {
        $this->db->order_by('IDAGENDA');
        return $this->db->get($this->tbl_agenda, $limit, $offset);
    }
	
    /**
     * Metodo que insere no banco de dados
     * @param array $person
     * @return resultset
     */
    public function save($agenda){
        $this->db->insert($this->tbl_agenda, $agenda);
        return $this->db->insert_id();
    }
	
    /**
     * Metodo que realiza um update do registro no banco de dados
     * @param int $id
     * @param array $person
     * @return resultset
     */
    public function update($id, $agenda){
        $this->db->where('IDAGENDA', $id);
        return $this->db->update($this->tbl_agenda, $agenda);
    }
	
    /**
     * Metodo que exclui o registro do banco de dados
     * @param id $id
     * @return resultset
     */
    public function delete($id){
        $this->db->where('IDAGENDA', $id);
        return $this->db->delete($this->tbl_agenda);
    }
    
}
?>
