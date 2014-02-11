<?php
class barn_model extends CI_Model {
	
	private $tbl_barnizadoras = 'tbl_barnizadoras'; //porque private?
	
	function __construct(){
		parent::__construct();
	}
	
	function list_all(){
		$this->db->order_by('Apli_producto','asc','Idprogramacion','asc');
		return $this->db->get($this->tbl_barnizadoras);
	}
	
	function list_all_group(){
		$this->db->group_by('Apli_producto');
		//$this->db->order_by('Apli_producto','asc','Idprogramacion','asc');
		return $this->db->get($this->tbl_barnizadoras);
	}
	
	function count_all(){
		return $this->db->count_all($this->tbl_barnizadoras);
	}
	
	/*function get_paged_list($limit = 10, $offset = 0){
		$this->db->order_by('Idprogramacion','asc');
		return $this->db->get($this->tbl_barnizadoras, $limit, $offset);
	}*/
	
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->order_by('Apli_producto','asc');
		return $this->db->get($this->tbl_barnizadoras, $limit, $offset);
	}
	
	
	function get_by_id($id){
		$this->db->where('Idprogramacion', $id);
		return $this->db->get($this->tbl_barnizadoras);
	}

	function list_by_apli($apli){
		$this->db->where('Apli_producto', $apli);
		return $this->db->get($this->tbl_barnizadoras);
	}
	
	
	/*function save($person){
		$this->db->insert($this->tbl_person, $person);
		return $this->db->insert_id();
	}*/
	
	function update($id, $barnizadora){
		$this->db->where('Idprogramacion', $id);
		$this->db->update($this->tbl_barnizadoras, $barnizadora);
	}
	
	/*function delete($id){
		$this->db->where('Idprogramacion', $id);
		$this->db->delete($this->tbl_person);
	}*/
}
?>