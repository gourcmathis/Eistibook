<?php


require('util.php');

$login=  $_SESSION['login']; //$_POST['login'];

$tableau = chargerListeAmis($login);

affichageAmisProfil($tableau); 



?>