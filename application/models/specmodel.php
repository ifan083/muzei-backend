<?php
class Specmodel extends CI_Model {
	public function getAllLike($table, $array) {
		$this->db->like ( $array );
		$q = $this->db->get ( $table );
		return $q->result_array ();
	}
	public function removeLocations($table, $id) {
		$data = array (
				'location' => NULL 
		);
		$this->db->where ( 'id', $id );
		$this->db->update ( $table, $data );
	}
	public function insertWithReturnedId($table, $data) {
		$this->db->insert ( $table, $data );
		return $this->db->insert_id ();
	}
	public function getLocationsForFloor($id) {
		$this->db->where ( 'floor', $id );
		$q = $this->db->get ( Welcome::TABLE_LOCATIONS );
		return $q->result_array ();
	}
	public function getArtifactWithLocation($location) {
		$this->db->where ( 'location', $location );
		$q = $this->db->get ( Welcome::TABLE_ARTIFACTS );
		return $q->row ();
	}
	public function changeDefaultFloor($id) {
		$data ['isdefault'] = 0;
		$this->db->update ( Welcome::TABLE_FLOORS, $data );
		
		$data ['isdefault'] = 1;
		$this->db->where ( 'id', $id );
		$this->db->update ( Welcome::TABLE_FLOORS, $data );
	}
	public function updateStatus($status) {
		$q = $this->db->get ( Welcome::TABLE_UPDATE );
		$row = $q->row ();
		if (empty ( $row )) {
			$data ['version'] = 1;
			$data ['status'] = $status;
			$this->db->insert ( Welcome::TABLE_UPDATE, $data );
		} else {
			$data ['version'] = ((int) $row -> version) + 1;
			$data ['status'] = $status;
			$this->db->update ( Welcome::TABLE_UPDATE, $data );
		}
	}
}