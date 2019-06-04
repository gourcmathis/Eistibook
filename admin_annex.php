<?php
include("admin_fonctions.php");

/* Toutes les informations considérées comme "annexes" sont les informations qui ont nécessitées la création de table de référencement dans la BDD. Ainsi, leur récupération, leur modification et leur suppression sont différentes des informations contenues dans la table principale de chaque utilisateur appelée 'EISTI_BOOK_UTILISATEUR'. */



$modif=$_POST['modif'];
$key=$_POST['key'];
$id_util=$_POST['id_util'];
$new_data=$_POST['new_data'];

modifAnnex($key,$id_util,$new_data,$modif);		
if ($modif=='ajout') {				//Message de confirmation différent selon la valeur de $modif
	echo "<br>L'information '".$new_data."' a été ajoutée !";
} else {
	echo "<br>L'information '".$new_data."' a été supprimée !";
}
?>