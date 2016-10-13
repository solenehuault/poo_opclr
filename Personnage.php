<?php
class Personnage {
	private $_force = 1;
	private $_localisation;
	private $_experience = 0;
	private $_degats = 5;

	public function deplacer() {}
	public function frapper() {}
	public function afficher_experience() {
		echo $this->_experience;
	}
	public function gagner_experience() {
		$this->_experience = $this->_experience + 1;
	}
}
