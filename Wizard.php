<?php
class Wizard extends Brute {
	public function cast_spell(Brute $brute) {
		if ($this->_life >= 0 && $this->_life <= 25)
			$this->_asset = 5;
		elseif ($this->_life > 25 && $this->_life <= 50)
			$this->_asset = 4;
		elseif ($this->_life > 50 && $this->_life <= 75)
			$this->_asset = 3;
		elseif ($this->_life > 75 && $this->_life <= 90)
			$this->_asset = 2;
		else
		$this->_asset = 1;

		if ($brute->_id == $this->_id)
			return self::TARGET_INVALID;
		if ($this->is_asleep())
			return self::TARGET_ASLEEP;
		$brute->_time_asleep = time() + ($this->_asset * 2) * 3600;
		return self::TARGET_SPELLED;
	}
}
?>
