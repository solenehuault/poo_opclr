<?php
class Personnage {
	private $_force = 1;
	private $_localisation;
	private $_experience = 0;
	private $_degats = 5;

	public function deplacer() {}
	public function frapper($perso_a_frapper) {
		//le perso_a_frapper va voir ses dégâts augmenter en fonction de la force du perso qui le frappe
		$perso_a_frapper->_degats += $this->_force;
	}
	public function afficher_experience() {
		echo $this->_experience;
	}
	public function gagner_experience() {
		$this->_experience++;
	}
}
