<?php

require 'Personnage.php';

$truc = new Personnage;
$mopi = new Personnage;

$truc->frapper($mopi);
$truc->gagner_experience();

$mopi->frapper($truc);
$mopi->gagner_experience();

$truc->afficher_experience();
$mopi->afficher_experience();
?>
