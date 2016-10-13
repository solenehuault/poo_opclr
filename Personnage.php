<?php
class Personnage {
	private $_force = 1;
	private $_localisation;
	private $_experience = 0;
	private $_degats = 5;

	//accesseur (getters)
	public function get_force() {
		return $this->_force;
	}

	public function get_localisation() {
		return $this->_localisation;
	}

	public function get_experience() {
		return $this->_experience;
	}

	public function get_degats() {
		return $this->_degats;
	}

	//methods
	public function deplacer() {}

	public function frapper(Personnage $perso_a_frapper) {
		//le perso_a_frapper va voir ses dégâts augmenter en fonction de la force du perso qui le frappe
		$perso_a_frapper->_degats += $this->_force;
	}

	public function gagner_experience() {
		$this->_experience++;
	}
}
