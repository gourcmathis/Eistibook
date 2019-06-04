<?php
require("util.php");
$maxsize=1048576;
$nom = $_FILES['icone']['name'];     //Le nom original du fichier, comme sur le disque du visiteur (exemple : mon_icone.png).
$type = $_FILES['icone']['type'];     //Le type du fichier. Par exemple, cela peut être « image/png ».
$taille = $_FILES['icone']['size'];     //La taille du fichier en octets.
$adressetemp = $_FILES['icone']['tmp_name']; //L'adresse vers le fichier uploadé dans le répertoire temporaire.
$codeerreur = $_FILES['icone']['error'];    //Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé.

if ($_FILES['icone']['error'] > 0) $erreur = "Erreur lors du transfert";

if ($_FILES['icone']['size'] > $maxsize) $erreur = "Le fichier est trop gros";

$val = date('Y-m-d H:i:s');


//Créer un dossier 'fichiers/1/'

  mkdir('image/'.$val.'/', 0777, true);

 $extension_upload = 'jpeg';

//Créer un identifiant difficile à deviner

  $nom = 'bonjour';

echo "$type";
  $nom = 'image/'.$val.'/'."bonjour.{$extension_upload}";

$resultat = move_uploaded_file($_FILES['icone']['tmp_name'],$nom);

if ($resultat) echo "Transfert réussi";
?>