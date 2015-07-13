<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class PersonModel extends CI_Model {
    // table name
    private $tbl_person= 'tbl_person';

    function __construct(){
        parent::__construct();
    }
    // get number of persons in database
    public function count_all(){
        return $this->db->count_all($this->tbl_person);
    }
    // get persons with paging
    public function get_paged_list($limit = 10, $offset = 0){        
        $this->db->order_by('id','asc');
        return $this->db->get($this->tbl_person, $limit, $offset);
    }
    // get person by id
    public function get_by_id($id){
        $this->db->where('id', $id);
        return $this->db->get($this->tbl_person);
    }
    // add new person
    public function save($person){
        $this->db->insert($this->tbl_person, $person);
        return $this->db->insert_id();
    }
    // update person by id
    public function update($id, $person){
        $this->db->where('id', $id);
        return $this->db->update($this->tbl_person, $person);
    }
    // delete person by id
    public function delete($id){
        $this->db->where('id', $id);
        $this->db->delete($this->tbl_person);
    }
}
?>
