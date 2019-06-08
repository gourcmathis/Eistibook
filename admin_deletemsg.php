<?php
include("admin_fonctions.php");

$idMsg=$_POST['idMsg'];

$db = connecterBDD();
$query="DELETE FROM messages WHERE id=$idMsg";		//Supprime le message ayant l'id sélectionné
$res = mysqli_query($db, $query) or die('erreur requête 2 : '.$query);
deconnecterBDD($db);
?>