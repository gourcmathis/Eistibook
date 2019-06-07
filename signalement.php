<?php
require("admin_fonctions.php");
?>
<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title> Signalements </title>

    <link href="./inscription.css"
          rel="stylesheet" type="text/css">
</head>

<body>

<?php
if ($_SESSION['type']<>'admin') {			//Si l'utilisateur n'a pas le droit d'accéder à la page admin, on affiche un message d'erreur et on l'invite à retourner sur son profil.
  echo "<div class='error'>Vous ne pouvez pas accéder à cette page. </div>";
  $access="none";
  echo "<br>";
  echo "<a href='profil.php?perso=".$_SESSION['login']."'>Retourner sur mon profil</a>";  
} else {
  $access="all";
}


if ($access=="all") {
	echo "<h1 class='titre'> Liste des signalements </h1>

<a href='admin.php'>Retour à la page administrateur</a>
<br>
<br>";

$tabSignal=chargeSignalement();
for ($i=0; $i < count($tabSignal) ; $i++) { 
	echo "<hr>";
	echo "<b>Message envoyé</b> par l'utilisateur numéro ".$tabSignal[$i]['id_expediteur'];
	echo "<br> <b>Message reçu</b> par l'utilisateur numéro ".$tabSignal[$i]['id_destinataire'];
	echo "<br> <b>Date</b> du message : ".$tabSignal[$i]['date'];
	echo "<br> <b>Motif</b> de signalement : ".$tabSignal[$i]['signalement_motif'];
	echo "<br> <b>Message</b> de signalement : ".$tabSignal[$i]['signalement_msg'];
	echo "<hr>";
}


}

?>