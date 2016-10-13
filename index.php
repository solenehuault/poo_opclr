<?php

require 'Personnage.php';

function status(Personnage $perso) {
	echo $perso->get_nom()."<br />".$perso->get_force()." force,<br />".$perso->get_experience()." experience<br />".$perso->get_degats()." dégats.<br /><br />";
}

$truc = new Personnage;
$mopi = new Personnage;

$truc->set_nom('Truc');
$truc->set_force(10);
$mopi->set_nom('Mopi');
$mopi->set_force(5);

echo 'Statut initial <br />';
status($truc);
status($mopi);

$truc->frapper($mopi);
$truc->gagner_experience();

$mopi->frapper($truc);
$mopi->gagner_experience();

echo '<br />Statut après un coup <br />';
status($truc);
status($mopi);
?>
