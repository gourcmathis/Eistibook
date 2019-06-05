<?php


require('util.php');

$login=  $_SESSION['login']; //$_POST['login'];

$tableau = chargerListeAmis($login);

if (!empty($tableau)) {
	affichageAmisProfil($tableau); 
} else {
	echo "vous n'avez pas d'amis";
}


?>