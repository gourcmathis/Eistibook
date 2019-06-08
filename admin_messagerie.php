<?php
include("admin_fonctions.php");

$id_util=$_POST['id_util'];

$tabMsg=chargeMessagerie($id_util);               //Tableau contenant tous les messages reçus par l'id utilisateur entré en paramètre
echo "<hr>";
for ($i=0; $i < count($tabMsg); $i++) {                 //On affiche le contenu du tableau
	$idMsg=$tabMsg[$i]['id'];                      
	echo "ID du message : ".$idMsg."<br>";
	echo "<br>ID de l'expéditeur : ".$tabMsg[$i]['id_expediteur'];
	echo "<br>Date du message : ".$tabMsg[$i]['date'];
	echo "<br>Titre : ".$tabMsg[$i]['titre'];
	echo "<br>Message : ".$tabMsg[$i]['message']."<br><br>";
	echo "<input type='button' class='bouton_admin' value='Supprimer message' onclick='supprMsg($idMsg)'/>";        //Génération d'un bouton doté d'une fonction onclick pour supprimer ce message
	echo "<span id='del_msg'></span>";
	echo "<hr>";
}
?>