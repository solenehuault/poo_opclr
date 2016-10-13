<?php

require 'Personnage.php';

$perso = new Personnage;
$perso->afficher_experience();
$perso->gagner_experience();
$perso->afficher_experience();

?>
