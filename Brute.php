<?php

class Brute {
	private _id;
	private _name;
	private _life;

	const TARGET_INVALID = 1; //const returned if hit method hits itself
	const TARGET_DEAD = 2; //const returned if hit method killed the other brute
	const TARGET_HIT = 3; //const returned if hit method actually did hit the other brute

	public function __construct(array $data) {
		$this->hydrate($data);
	}

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

	//hydrate function
	public function hydrate(array $data) {
		foreach ($data as $key => $value) {
			$method = 'set_'.$key;
			if ($method_exists($this, $method))
				$this->$method($value);
		}
	}

	
	public function hit(Brute $brute) {
		if ($brute->get_id() == $thid->_id)
			return self::TARGET_INVALID;
		return $brute->is_hit();
	}

	public function is_hit() {
		$this->_life -= 5;
		if ($this->_life <= 0)
			return self::TARGET_DEAD;
		return self::TARGET_HIT;
	}
}
?>
