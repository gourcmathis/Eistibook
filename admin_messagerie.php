<?php
include("admin_fonctions.php");

$id_util=$_POST['id_util'];

$tabMsg=chargeMessagerie($id_util);
echo "<hr>";
for ($i=0; $i < count($tabMsg); $i++) { 
	$idMsg=$tabMsg[$i]['id'];
	echo "ID du message : ".$idMsg."<br>";
	echo "<br>ID de l'expéditeur : ".$tabMsg[$i]['id_expediteur'];
	echo "<br>Date du message : ".$tabMsg[$i]['date'];
	echo "<br>Titre : ".$tabMsg[$i]['titre'];
	echo "<br>Message : ".$tabMsg[$i]['message']."<br><br>";
	echo "<input type='button' class='bouton_admin' value='Supprimer message' onclick='supprMsg($idMsg)'/>";
	echo "<span id='del_msg'></span>";
	echo "<hr>";
}
?>