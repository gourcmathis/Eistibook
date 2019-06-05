<?php
include("admin_fonctions.php");

$id_util=$_POST['id_util'];

$tabMsg=chargeMessagerie($id_util);

echo "<hr>";
for ($i=0; $i < count($tabMsg); $i++) { 
	echo "ID du message : ".$tabMsg[$i]['id']."<br>";
	echo "<br>ID de l'expéditeur : ".$tabMsg[$i]['id_expediteur'];
	echo "<br>Date du message : ".$tabMsg[$i]['date'];
	echo "<br>Titre : ".$tabMsg[$i]['titre'];
	echo "<br>Message : ".$tabMsg[$i]['message'];
	echo "<hr>";
}
?>