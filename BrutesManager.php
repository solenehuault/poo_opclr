<?php
class BrutesManager {
	private $_db;

	public function __construct($db) {
		$this->set_db($db);
	}

	public function set_db($db) {
		$this->_db = $db;
	}

	//exists() can take a int or a string as arg, and seek in the db for an matching id or name
	//return a bool depending is the Brute exist or not
	public function exists($info) {
		$sql = (is_int($info))?
			'SELECT * FROM brutes WHERE id = :info':
			'SELECT * FROM brutes WHERE name = :info';
		$query = $this->_db->prepare($sql);
		$query->bindValue(':info', $info);
		$query->execute();
		return (bool) $query->fetchColumn();
	}

	//get() can take a int or a str as arg, and seek in the db for a matching id or name
	//return the information associated
	public function get($info) {
		$sql = (is_int($info))?
			'SELECT * FROM brutes WHERE id = :info':
			'SELECT * FROM brutes WHERE name = :info';
		$query = $this->_db->prepare($sql);
		$query->bindValue(':info', $info);
		$query->execute();
		$data = $query->fetch(PDO::FETCH_ASSOC);
		return new Brute($data);
	}

	//add() take an Brute instance as arg, insert the name in the db, then hydrate the Brute instance
	public function add(Brute $brute) {
		$sql = 'INSERT INTO brutes (name) VALUES (:name)';
		$query = $this->_db->prepare($sql);
		$query->bindValue(':name', $brute->get_name());
		$query->execute();
		$brute->hydrate([
			'id' => $this->_db->lastInsertId(),
			'life' => 100,
			'strength' => 1,
			'xp' => 0
		]);
	}

	//update() update the life of a particular Brute
	public function update(Brute $brute) {
		$sql = 'UPDATE brutes SET life = :life, strength = :strength, xp = :xp WHERE id = :id';
		$query = $this->_db->prepare($sql);
		$query->bindValue(':life', $brute->get_life());
		$query->bindValue(':strength', $brute->get_strength());
		$query->bindValue(':xp', $brute->get_xp());
		$query->bindValue(':id', $brute->get_id());	
		$query->execute();
	}

	//delete() deletes the information of a particular brute
	public function delete(Brute $brute) {
		$sql = 'DELETE FROM brutes WHERE id= :id';
		$query = $this->_db->prepare($sql);
		$query->bindValue(':id', $brute->get_id());
		$query->execute();
	}

	//Count the number of brutes in the db
	public function count() {
		$sql = 'SELECT COUNT(*) FROM brutes';
		$query = $this->_db->prepare($sql);
		$query->execute();
		return $query->fetchColumn();
	}

	//get the list of all the brutes exept one
	public function get_list($name) {
		$sql = 'SELECT * FROM brutes WHERE name <> :name ORDER BY name';
		$query = $this->_db->prepare($sql);
		$query->bindValue(':name', $name);
		$query->execute();
		$brutes = [];
		while ($data = $query->fetch(PDO::FETCH_ASSOC))
			$brutes[] = new Brute($data);
		return $brutes;
	}

	//get the list of all brutes
	public function list_all() {
		$sql = 'SELECT * FROM brutes ORDER BY name';
		$query = $this->_db->prepare($sql);
		$query->execute();
		$brutes = [];
		while ($data = $query->fetch(PDO::FETCH_ASSOC))
			$brutes[] = new Brute($data);
		return $brutes;
	}
}
?>
