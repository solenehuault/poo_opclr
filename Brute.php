<?php

class Brute {
	protected $_id,
						$_name,
						$_life,
						$_strength,
						$_xp,
						$_asset,
						$_time_asleep,
						$_type;

	const TARGET_INVALID = 1; //const returned if hit method hits itself
	const TARGET_DEAD = 2; //const returned if hit method killed the other brute
	const TARGET_HIT = 3; //const returned if hit method actually did hit the other brute
	const TARGET_SPELLED = 4; //const returned from cast_spell if method actually spelled the other brute
	const TARGET_ASLEEP = 5; //const returned from hit method if target is asleep

	public function __construct(array $data) {
		$this->hydrate($data);
		$this->_type = strtolower(static::class);
	}

	//getters & setters
	public function get_id() { return $this->_id; }
	public function get_name() { return $this->_name; }
	public function get_life() { return $this->_life; }
	public function get_strength() { return $this->_strength;	}
	public function get_xp() { return $this->_xp;	}
	public function get_asset() { return $this->_asset; }
	public function get_time_asleep() { return $this->_time_asleep; }
	public function get_type() { return $this->_type; }
	
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

	public function set_asset($asset) {
		$asset = (int) $asset;
		if ($asset >= 0 && $asset <= 5)
			$this->_asset = $asset;
	}

	public function set_time_asleep($time) {
		$this->_time_asleep = (int) $time;
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

		if ($this->is_asleep())
			return self::TARGET_ASLEEP;

		return $brute->is_hit($this);
	}

	public function is_hit(Brute $brute_hitter) {
		$this->_life -= $brute_hitter->_strength;
		if ($this->_life <= 0)
			return self::TARGET_DEAD;
		return self::TARGET_HIT;
	}

	public function is_asleep() {
		return $this->_time_asleep > time();
	}

	public function wake_up() {
		$sec = $this->_time_asleep;
		$sec -= time();
		
		$hours = floor($sec / 3600);
		$sec -= $hours * 3600;
		$min = floor($sec / 60);
		$sec -= $min * 60;

		$hours .= $hours <= 1 ? ' hour' : ' hours';
		$min .= $min <= 1 ? ' minute' : ' minutes';
		$sec .= $sec <= 1 ? ' seconde' : ' secondes';

		return $hours.', '.$min.' and '.$sec;
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
