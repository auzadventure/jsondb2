<?php

class JsonDB {
	
	public $filename;
	public $rows;
	
	
	
	public function __construct($filename) {
		$this->filename = $filename; 
		
	}
	
	// insert 
	public function insert(array $row) {
		$rows = $this->findAll(true);
		$lastID = $this->getLastID();
		$_lastID = $lastID + 1; 
		$_row = [$_lastID=>$row]; 

		$rows['data'] = $rows['data'] + $_row;
		$rows['conf'] = ['lastID'=>$_lastID]; 
		$this->save($rows);
	

	}
	
	
	public function find(string $field, string $val) {
		$rows = $this->findAll()->data;

		foreach($rows as $row) {
			if($row->$field == $val) {
				return (array) $row;
			}
		}
		return [];
	}
	
	public function findOne($id) {
		
		return $this->findAll()->data->$id ?? "Not Found";
	}

	
	public function findAll($toArray = false) {
		if(!file_exists($this->filename)) $this->createEmpty();
		
		$rows = json_decode(file_get_contents($this->filename),$toArray);
		
		return $rows;
	}
	
	
	

	public function getLastID() {	
		$rows = $this->findAll();
		$lastID = $rows->conf->lastID;
		return $lastID;
	}
	

	
	public function delete(string $field, string $val) {
		$data = $this->findAll();
		$rows = $data->data;
		$_rows = [];
		$isDelete = false;
		
		foreach($rows as $row) {
			if($row->$field != $val) {
				$_rows[] = $row;
			}
			else $isDelete = true;
			
		}
		
		$data->data = $_rows; 
		
		$this->save($data);
		return $isDelete; 
	}	
	
	public function deleteByID($id) {
		$data = $this->findAll(); 
		unset($data->data->{$id});
		$this->save($data);
		
	}

	private function save($data) {
		file_put_contents($this->filename,json_encode($data, JSON_PRETTY_PRINT));
	}
	
	private function createEmpty() {
		$a = ['data'=>[],'conf'=>['lastID'=>0]];
		$str = json_encode($a);
		file_put_contents($this->filename,$str);
	}

}

?>


<?php 
