<?php
include("admin_fonctions.php");

$id_util=$_POST['id_util'];          //Récupère l'ID de l'utilisateur sélectionné

$db = connecterBDD();
$query="DELETE FROM EISTI_BOOK_UTILISATEUR WHERE ID_UTILISATEURS=$id_util";		//Supprime le compte l'utilisateur choisi
$res = mysqli_query($db, $query) or die('erreur requête 2 : '.$query);
deconnecterBDD($db);

echo 'Le compte ayant pour ID Utilisateur '.$id_util.' a bien été supprimé !';


?>