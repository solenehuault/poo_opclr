<?php

class Brute {
	private _id;
	private _name;
	private _life;

	const TARGET_INVALID = 1;
	const TARGET_DEAD = 2;
	const TARGET_HIT = 3;

	//getters & setters
	public function get_id() {
		return $this->_id;
	}

	public function get_name() {
		return $this->_name;
	}

	public function set_name($name) {
		if (is_string($name))
			$this->_name = $name;
	}
	
	public function get_life() {
		return $this->_life;
	}

	public function set_life($life) {
		$life = (int) $life;
		if ($life >= 0 && $life <= 100)
			$this->_life = $life;
	}


	public function hit(Brute $brute) {

	}

	public function get_hit() {

	}
}
?>
