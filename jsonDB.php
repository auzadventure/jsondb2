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
		$rows = $rows + $row;
		$this->save($rows);
	}
	

	public function find(string $field, string $val) {
		$rows = $this->findAll();

		foreach($rows as $row) {
			if($row->$field == $val) {
				return (array) $row;
			}
		}
		return [];
	}

	
	public function findAll($toArray = false) {
		if(!file_exists($this->filename)) $this->createEmpty();
		
		$rows = json_decode(file_get_contents($this->filename),$toArray);
		return $rows;
	}
	

	

	
	public function delete(string $field, string $val) {
		$rows = $this->findAll();
		$_rows = [];
		$isDelete = false;
		
		foreach($rows as $row) {
			if($row->$field != $val) {
				$_rows = $row;
			}
			else $isDelete = true;
			
		}
		$this->save($_rows);
		return $isDelete; 
	}	

	private function save($data) {
		file_put_contents($this->filename,json_encode($data, JSON_PRETTY_PRINT));
	}
	
	private function createEmpty() {
		$a = [];
		$str = json_encode($a);
		file_put_contents($this->filename,$str);
	}

}

?>


<?php 

$jsonDB = new JsonDB('data.json');
$a = [ 'name'=>'john','last'=>'snow'];
//$jsonDB->insert($a); 

print_r($a);
