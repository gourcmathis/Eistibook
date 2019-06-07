<?php
include("admin_fonctions.php");

$id_util=$_POST['id_util'];          //Récupère l'ID de l'utilisateur sélectionné
$ban=$_POST['val'];			//0 -> retire le bannissement de cet utilisateur ; 1 -> bannit cet utilisateur
modifInfo($id_util,'BAN',$ban);

if ($ban==0) {
	echo 'Le bannissement du compte ayant pour ID Utilisateur '.$id_util.' a bien été retiré !';
} else {
	echo "Le compte ayant pour ID Utilisateur ".$id_util." a été banni !";
}
?>