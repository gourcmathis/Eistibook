<?php
include("admin_fonctions.php");

$id_util=$_POST['id_util'];
$cle=$_POST['key'];
$valeur=$_POST['new_data'];
modifInfo($id_util, $cle, $valeur);     //Après avoir récupéré les informations nécessaires, modifie l'élément de la colonne '$cle' sélectionnée avec la nouvelle donnée '$valeur'
?>