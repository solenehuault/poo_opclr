<?php
class BrutesManager {
	private $_bd;

	public function __construct($db) {
		$this->set_db($db);
	}

	public function set_db($bd) {
		$this->_db = $db;
	}

	public function exists($info) {
		
	}

	public function get($info) {

	}

	public function add(Brute $brute) {
		$sql = 'INSERT INTO brutes (name) VALUES (:name)';
		$query = $this->_db->prepare($sql);
		$query->bindValue(':name', $brute->get_name());
		$query->execute();
		$brute->hydrate([
			'id' => $this->_db->lastInsertId(),
			'life' => 100
		]);
	}

	public function update(Brute $brute) {
		
	}

	public function delete(Brute $brute) {

	}

	public function count() {

	}

	public function get_list($name) {

	}
}
?>
