<?php


require('util.php');
$login= $_POST['login'];

$tableau = chargerListeAmis($login);

affichageAmisProfil($tableau); 



?>
