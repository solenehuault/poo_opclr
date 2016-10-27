<?php
class Warrior extends Brute {
	public function is_hit(Brute $brute_hitter) {
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

		$this->_life -= ($brute_hitter->_strength - $this->_asset);

		if ($this->_life <= 0)
			return self::TARGET_DEAD;
		return self::TARGET_HIT;
	}
}
?>
