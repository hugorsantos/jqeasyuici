<?php
/**
 * Classe controller agenda
 * @author HUGO REIS SANTOS
 * @copyright Testes Data: 07/08/2013
 * @access public
 * @package controllers/agenda
 * @version 1.0
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agenda extends CI_Controller {

    // num of records per page
    private $limit = 10;
    /**
     * Metodo construtor da classe
     */
    public function __construct(){
        parent::__construct();
        // load library
        $this->load->library(array('table','form_validation'));
        // load helper
        $this->load->helper('url');
        // load model
        $this->load->model('AgendaModel','',TRUE);
    }

    /**
     *  Metodo que abre a pagina inicial
     * @param int $offset
     */
    public function index($offset = 0){
        //abre a visao
        $this->load->view('agendaList');
    }

    /**
     * Metodo que retorna a listagem da paginacao
     */
    public function getListagem(){

        //pega os dados da paginacao       
        $page = $this->input->post('page')!=0 ? $this->input->post('page') : 1;
        $rows = $this->input->post('rows')!=0 ? $this->input->post('rows') : 10;
        $offset = ($page-1)*$rows;

        $result = array();
        //pega o total de registros para listagem
        $result["total"] = $this->AgendaModel->getCountListagem();
        //realiza a consulta para a listagem
        $listagenda = $this->AgendaModel->getListagem($offset,$rows)->result();
        
        $j=0;
        $arrrs = array();
        foreach ($listagenda as $agenda){
            $valor['id'] = $agenda->IDAGENDA;
            $valor['nome'] = $agenda->NOME;
            $valor['email'] = $agenda->EMAIL;
            $valor['telefone'] = $agenda->TELEFONE;
            $valor['celular'] = $agenda->CELULAR;
            $arrrs[$j] = $valor;
            $j++;
        }        
        //monta o array para o json
        $items = array();
        foreach ($arrrs as $value){
            array_push($items, $value);
        }
        $result["rows"] = $items;
        echo json_encode($result);
    }

    /**
     * Metodo que recebe as informacoes do formulario e insere no banco de dados
     */
    public function setInsert() {
        //monta um array com os dados do formulario de inclusao
        $agenda = array('nome' => $this->input->post('nome'),
                        'email' => $this->input->post('email'),
                        'telefone' => $this->input->post('telefone'),
                        'CELULAR' => $this->input->post('CELULAR'));
        //salva os registro no banco de dados        
        if ($this->AgendaModel->save($agenda)){
            echo json_encode(array('success'=>true));
        } else {
            echo json_encode(array('msg'=>'Ocorreio um erro, ao incluir o registro.'));
        }
    }

    /**
     * Metodo que recebe as informacoes do formulario para realizar o update do
     * registro no banco de dados.
     */
    public function setUpdate($id){
        $agenda = array('nome' => $this->input->post('nome'),
                        'email' => $this->input->post('email'),
                        'telefone' => $this->input->post('telefone'),
                        'celular' => $this->input->post('celular'));
        if ($this->AgendaModel->update($id,$agenda)){
            echo json_encode(array('success'=>true));
        } else {
            echo json_encode(array('msg'=>'Ocorreio um erro, ao atualizar o registro.'));
        }
        
    }

    /**
     * Metodo que apaga o registro da tabela
     * @param <type> $id
     */
    public function setDelete($id){
        if ($this->AgendaModel->delete($id)){
            echo json_encode(array('success'=>true));
        } else {
            echo json_encode(array('msg'=>'Ocorreio um erro, ao excluir o registro.'));
        }
    }
    
}

?>

