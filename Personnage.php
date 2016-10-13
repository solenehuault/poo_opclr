<?php
class Personnage {
	private $_nom;
	private $_force = 1;
	private $_localisation;
	private $_experience = 0;
	private $_degats = 5;

	//accesseur (getters) mutateurs (setters)
	public function get_nom() {
		return $this->_nom;
	}

	public function set_nom($nom) {
		$this->_name = $nom;
	}

	public function get_force() {
		return $this->_force;
	}

	public function set_force($force) {
		
		if (!is_int($force)) {
			trigger_error('La force d’un personnage doit être un nombre entier.', E_USER_WARNING);
			return;
		}
		
		if ($force > 100) {
			trigger_error('La force d’un personnage ne peut dépasser 100.', E_USER_WARNING);
			return;
		}
		
		$this->_force = $force;
	}

	public function get_localisation() {
		return $this->_localisation;
	}

	public function set_localisation($localisation) {
		$this->_localisation = $localisation;
	}

	public function get_experience() {
		return $this->_experience;
	}

	public function set_experience($experience) {
		
		if (!is_int($experience)) {
			trigger_error('L’expérience d’un personnage doit être un nombre entier.', E_USER_WARNING);
			return;
		}
		
		if ($experience > 100) {
			trigger_error('L’expérience d’un personnage ne peut dépasser 100.');
			return;
		}
		
		$this->_experience = $experience;
	}

	public function get_degats() {
		return $this->_degats;
	}

	public function set_degats($degats) {
		
		if (!is_int($degats)) {
			trigger_error('Le niveau de dégats d’un personnage doit être un nombre entier.', E_USER_WARNING);
		}

		$this->_degats = $degats;
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
