<?php

class Brute {
	private $_id;
	private $_name;
	private $_life;
	private $_strength;
	private $_xp;

	const TARGET_INVALID = 1; //const returned if hit method hits itself
	const TARGET_DEAD = 2; //const returned if hit method killed the other brute
	const TARGET_HIT = 3; //const returned if hit method actually did hit the other brute

	public function __construct(array $data) {
		$this->hydrate($data);
	}

	//getters & setters
	public function get_id() { return $this->_id; }
	public function get_name() { return $this->_name; }
	public function get_life() { return $this->_life; }
	public function get_strength() { return $this->_strength;	}
	public function get_xp() { return $this->_xp;	}
	
	public function set_id($id) {
		$id = (int) $id;
		if ($id > 0)
			$this->_id = $id;
	}

	public function set_name($name) {
		if (is_string($name))
			$this->_name = $name;
	}

	public function set_life($life) {
		$life = (int) $life;
		if ($life >= 0 && $life <= 100)
			$this->_life = $life;
	}

	public function set_strength($strength) {
		$strength = (int) $strength;
		if ($strength >= 0 && $strength <= 100)
			$this->_strength = $strength;
	}	

	public function set_xp($xp) {
		$xp = (int) $xp;
		if ($xp >= 0 && $xp <= 100)
			$this->_xp = $xp;
	}

	//hydrate function
	public function hydrate(array $data) {
		foreach ($data as $key => $value) {
			$method = 'set_'.$key;
			if (method_exists($this, $method))
				$this->$method($value);
		}
	}
	
	public function hit(Brute $brute) {
		if ($brute->get_id() == $this->_id)
			return self::TARGET_INVALID;
		return $brute->is_hit($this);
	}

	public function is_hit(Brute $brute_hitter) {
		$this->_life -= $brute_hitter->_strength;
		if ($this->_life <= 0)
			return self::TARGET_DEAD;
		return self::TARGET_HIT;
	}

	public function gain_xp(Brute $brute, $xp) {
		$xp = (int) $xp;
		if ($xp > 0 && $xp < 10)
			$this->_xp += $xp;
		if ($this->_xp >= 100) {
			$this->set_xp(0);
			$this->_strength++;
		}	
	}

	public function valid_name() {
		return !empty($this->_name);
	}
}
?>
