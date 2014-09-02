<?php
class Umodel extends CI_Model {
	public function insert($table, $data) {
		$this->db->insert ( $table, $data );
	}
	public function getAll($table) {
		$q = $this->db->get ( $table );
		return $q->result_array ();
	}
	public function delete($table, $id) {
		$this->db->where ( 'id', $id );
		$this->db->delete ( $table );
	}
	public function update($table, $data, $id) {
		$this->db->where ( 'id', $id );
		$this->db->update ( $table, $data );
	}
}