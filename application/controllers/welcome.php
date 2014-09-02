<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Welcome extends CI_Controller {
	const TABLE_ACHIEVEMENTS = "achievements";
	const TABLE_ARTIFACTS = "artifacts";
	const TABLE_CHARACTERS = "characters";
	const TABLE_CRITERIAS = "criterias";
	const TABLE_FLOORS = "floors";
	const TABLE_LOCATIONS = "locations";
	const TABLE_UPDATE = "update";
	const STATUS_OK = "status ok";
	const STATUS_MUST_UPDATE_APK = "status must update apk";
	const ZIP = "update.zip";
	public function __construct() {
		parent::__construct ();
		// loading models
		$this->load->model ( 'umodel' );
		$this->load->model ( 'specmodel' );
		$this->load->library ( 'form_validation' );
		$this->load->helper ( 'file' );
	}
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * http://example.com/index.php/welcome
	 * - or -
	 * http://example.com/index.php/welcome/index
	 * - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 *
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {
		$this->load->view ( 'master-page' );
	}
	public function characters() {
		$data ['data'] = $this->umodel->getAll ( self::TABLE_CHARACTERS );
		$this->load->view ( 'characters', $data );
	}
	public function achievements() {
		$data ['categories'] = $this->umodel->getAll ( self::TABLE_CHARACTERS );
		$data ['achievements'] = $this->umodel->getAll ( self::TABLE_ACHIEVEMENTS );
		$data ['criterias'] = $this->umodel->getAll ( self::TABLE_CRITERIAS );
		$this->load->view ( 'achievements', $data );
	}
	public function artifacts() {
		$data ['categories'] = $this->umodel->getAll ( self::TABLE_CHARACTERS );
		$data ['artifacts'] = $this->umodel->getAll ( self::TABLE_ARTIFACTS );
		$this->load->view ( 'artifacts', $data );
	}
	public function maps() {
		$data ['floors'] = $this->umodel->getAll ( self::TABLE_FLOORS );
		$data ['locations'] = $this->umodel->getAll ( self::TABLE_LOCATIONS );
		$this->load->view ( 'maps', $data );
	}
	public function app_update() {
		$result = $this->umodel->getAll ( self::TABLE_UPDATE);
		if(!empty($result)) {
			$result = $result[0];
		}
		$data ['updatedata'] = $result;
		$this->load->view ( 'app_update', $data );
	}
	public function handleUpload($filedata) {
		$target_path = "images/";
		$target_path = $target_path . basename ( $filedata ['name'] );
		
		if (move_uploaded_file ( $filedata ['tmp_name'], $target_path )) {
			return $target_path;
		} else {
			return null;
		}
	}
	
	// CHARACTERS
	public function save_character() {
		$uploadedFile = $this->handleUpload ( $_FILES ['file'] );
		if ($uploadedFile != null) {
			$data ['name'] = $this->input->post ( 'char_name' );
			$data ['category'] = $this->input->post ( 'char_category' );
			$data ['picture_filename'] = $uploadedFile;
			$data ['mapper'] = $this->input->post ( 'mapper' );
			$this->umodel->insert ( self::TABLE_CHARACTERS, $data );
			header ( "Location: " . base_url () );
			
			// return ok
		}
		
		// return problem
	}
	public function delete_character() {
		$this->umodel->delete ( self::TABLE_CHARACTERS, $this->input->get ( 'id' ) );
		// check if other rows in the db use the same picture, if not, delete it from the images / uploads folder
	}
	public function update_character() {
		$data ['name'] = $this->input->post ( 'name' );
		$data ['category'] = $this->input->post ( 'category' );
		$data ['mapper'] = $this->input->post ( 'mapper' );
		
		$this->umodel->update ( self::TABLE_CHARACTERS, $data, $this->input->post ( 'id' ) );
	}
	
	// ARTIFACTS
	public function save_artifact() {
		$uploadedFile = $this->handleUpload ( $_FILES ['file'] );
		if ($uploadedFile != null) {
			$data ['name'] = $this->input->post ( 'art_name' );
			$data ['category'] = $this->input->post ( 'art_category' );
			$data ['picture'] = $uploadedFile;
			$data ['description'] = $this->input->post ( 'art_desc' );
			$data ['difficulty'] = $this->input->post ( 'art_diff' );
			
			$this->umodel->insert ( self::TABLE_ARTIFACTS, $data );
			header ( "Location: " . base_url () );
			// return ok
		}
	}
	public function delete_artifact() {
		$this->umodel->delete ( self::TABLE_ARTIFACTS, $this->input->get ( 'id' ) );
	}
	public function update_artifact() {
		$data ['name'] = $this->input->post ( 'name' );
		$data ['description'] = $this->input->post ( 'description' );
		$data ['difficulty'] = $this->input->post ( 'difficulty' );
		
		$this->umodel->update ( self::TABLE_ARTIFACTS, $data, $this->input->post ( 'id' ) );
	}
	
	// LOCATIONS
	public function remove_location() {
		// remove the location id from the artifact entry
		$this->umodel->delete ( self::TABLE_LOCATIONS, $this->input->get ( 'location' ) );
		
		// remove the location entry
		$this->specmodel->removeLocations ( self::TABLE_ARTIFACTS, $this->input->get ( 'id' ) );
	}
	public function add_location() {
		// get location from request
		$data ['xpercent'] = $this->input->post ( 'x' );
		$data ['ypercent'] = $this->input->post ( 'y' );
		$data ['floor'] = $this->input->post ( 'floor' );
		// save the new location
		$insertedId = $this->specmodel->insertWithReturnedId ( self::TABLE_LOCATIONS, $data );
		
		// get id of inserted location
		$updateData ['location'] = $insertedId;
		// update location id in artifacts
		$this->umodel->update ( self::TABLE_ARTIFACTS, $updateData, $this->input->post ( 'id' ) );
		
		// get like from request
		$like ['name'] = $this->input->post ( 'like' );
		echo json_encode ( $this->specmodel->getAllLike ( self::TABLE_ARTIFACTS, $like ) );
	}
	public function get_artifact_by_location() {
		echo json_encode ( $this->specmodel->getArtifactWithLocation ( $this->input->get ( 'id' ) ) );
	}
	
	// CRITERIAS
	public function add_criteria() {
		$data ['name'] = $this->input->post ( 'name' );
		$this->umodel->insert ( self::TABLE_CRITERIAS, $data );
		echo json_encode ( $this->umodel->getAll ( self::TABLE_CRITERIAS ) );
	}
	public function remove_criteria() {
		$this->umodel->delete ( self::TABLE_CRITERIAS, $this->input->post ( 'id' ) );
		echo json_encode ( $this->umodel->getAll ( self::TABLE_CRITERIAS ) );
	}
	public function update_criteria() {
		$data ['name'] = $this->input->post ( 'name' );
		$this->umodel->update ( self::TABLE_CRITERIAS, $data, $this->input->post ( 'id' ) );
		echo json_encode ( $this->umodel->getAll ( self::TABLE_CRITERIAS ) );
	}
	
	// ACHIEVEMENTS
	public function save_achievement() {
		$data ['name'] = $this->input->post ( 'name' );
		$data ['description'] = $this->input->post ( 'description' );
		$data ['criteria'] = $this->input->post ( 'criteria' );
		$data ['continuous'] = $this->input->post ( 'continuous' );
		$data ['difficulty'] = $this->input->post ( 'difficulty' );
		$data ['category'] = $this->input->post ( 'category' );
		
		$this->umodel->insert ( self::TABLE_ACHIEVEMENTS, $data );
		header ( "Location: " . base_url () );
	}
	public function delete_achievement() {
		$this->umodel->delete ( self::TABLE_ACHIEVEMENTS, $this->input->get ( 'id' ) );
	}
	public function update_achievement() {
		$data ['name'] = $this->input->post ( 'name' );
		$data ['description'] = $this->input->post ( 'description' );
		$data ['criteria'] = $this->input->post ( 'criteria' );
		$data ['continuous'] = $this->input->post ( 'continuous' );
		$data ['difficulty'] = $this->input->post ( 'difficulty' );
		
		$this->umodel->update ( self::TABLE_ACHIEVEMENTS, $data, $this->input->post ( 'id' ) );
	}
	
	// MAPS
	public function save_floor() {
		$uploadedFile = $this->handleUpload ( $_FILES ['file'] );
		if ($uploadedFile != null) {
			$data ['name'] = $this->input->post ( 'name' );
			$data ['level'] = $this->input->post ( 'level' );
			$data ['picture'] = $uploadedFile;
			
			$this->umodel->insert ( self::TABLE_FLOORS, $data );
			header ( "Location: " . base_url () );
			// return ok
		}
	}
	public function delete_floor() {
		$this->umodel->delete ( self::TABLE_FLOORS, $this->input->get ( 'id' ) );
	}
	
	// AUTO-COMPLETE
	public function get_like_artifacts() {
		$data ['name'] = $this->input->get ( 'name' );
		echo json_encode ( $this->specmodel->getAllLike ( self::TABLE_ARTIFACTS, $data ) );
	}
	
	// FLOORS
	public function change_default_floor() {
		$this->specmodel->changeDefaultFloor ( $this->input->get ( 'id' ) );
	}
	
	// APP UPDATE
	public function download_update() {
	}
	private function connectArtifactsWithLocations($artifacts, $locations) {
		for($i = 0; $i < count ( $artifacts ); $i ++) {
			if (! isset ( $artifacts [$i] ['location'] )) {
				continue;
			} else {
				foreach ( $locations as $loc ) {
					if ($artifacts [$i] ['location'] == $loc ['id']) {
						$artifacts [$i] ['location'] = $loc;
						break;
					}
				}
			}
		}
		return $artifacts;
	}
	public function prepare_zip() {
		$data ['characters'] = $this->umodel->getAll ( self::TABLE_CHARACTERS );
		$artifacts = $this->umodel->getAll ( self::TABLE_ARTIFACTS );
		$locations = $this->umodel->getAll ( self::TABLE_LOCATIONS );
		$data ['artifacts'] = $this->connectArtifactsWithLocations ( $artifacts, $locations );
		$data ['floors'] = $this->umodel->getAll ( self::TABLE_FLOORS );
		$data ['achievements'] = $this->umodel->getAll ( self::TABLE_ACHIEVEMENTS );
		
		delete_files ( './download' );
		$this->createZip ( $data );
		// make an entry to the db
		$this->specmodel->updateStatus ( $this->input->get ( 'status' ) );
		echo 'ok';
	}
	private function createZip($files) {
		$zip = new ZipArchive ();
		$DelFilePath = "download/" . self::ZIP;
		if (file_exists ( $DelFilePath )) {
			unlink ( $DelFilePath );
		}
		if ($zip->open ( $DelFilePath, ZIPARCHIVE::CREATE ) != TRUE) {
			die ( "Could not open archive" );
		}
		//adding files
		foreach($files as $key => $value) {
			$zip->addFromString($key.'.json',  json_encode($value));
		}
		//adding images
		$zip->addEmptyDir('images');
		$images = scandir('images/');
		foreach ($images as $image) {
			if($image == '.' || $image == '..') {
				continue;
			}
			$zip->addFile('images/'.$image, 'images/'.$image);
		}
		
		// close and save archive
		$zip->close ();
		header('Content-disposition: attachment; filename=\''.self::ZIP.'\'');
		header('Content-type: application/zip');
	}
} 

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */