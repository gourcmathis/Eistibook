<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title> Page administrateur </title>
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css"
          rel="stylesheet" type="text/css">
    <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css"
          rel="stylesheet" type="text/css"> -->
    <script type="text/javascript" src="admin.js"></script>
           <link href="./inscription.css"
          rel="stylesheet" type="text/css">
</head>

<body>

<?php
    include("admin_fonctions.php");


if ($_SESSION['type']<>'admin') {                   //Si l'utilisateur n'a pas le droit d'accéder à la page admin, on affiche un message d'erreur et on l'invite à retourner sur son profil.
  echo "<div class='error'>Vous ne pouvez pas accéder à cette page. </div>";
  $access="none";
  echo "<br>";
  echo "<a href='profil.php?perso=".$_SESSION['login']."'>Retourner sur mon profil</a>";  
} else {
  $access="all";
}

if ($access=='all') {
  echo "<h1 class='titre'> Page Administrateur </h1>
<a href='deco.php'> Me déconnecter </a>
<br>
<a href='signalement.php'>Voir les signalements</a>

<h2> <u>Liste de tous les utilisateurs</u> </h2>";

$tabEleve=getUserList();

echo '<select id="eleve" name="eleve">';
for ($i=0; $i < count($tabEleve) ; $i++) { 
  $res=$i+1;
  echo '<option value="'.$tabEleve[$i]['id_util'].'">'.$tabEleve[$i]['nom'].' '.$tabEleve[$i]['prenom'].'</option>';
}
echo '</select>';

$tmp='"menu"';

echo "<h2> <u>Choix d'une action pour cet élève</u> </h2>
<hr>
  <input type='button' name='info' value='Voir informations personnelles' onclick='execInfo()'>
  <br><span id='affichage'></span><hr>";
 echo "<input type='button' name='modif' value='Modifier informations personnelles' onclick='reveal($tmp)'>";
  echo ' <span id="menu" hidden>';


    echo "<br>Que souhaitez-vous modifier ?<br>";

$tabInfo=getInfos();

  $key_tab=array_keys($tabInfo[0]);

$tmp='"remplace"';
echo "<select id='cle' name='cle' onchange='execPrint();reveal($tmp)'>"; 
                                                  
  for ($i=1; $i <20 ; $i++) {                             //Affichage d'une liste déroulante contenant tous les types d'information qu'il est possible de modifier. On initialise l'itérateur à 1 car on ne veut pas la première colonne 'type' ( on ne modifie pas le type d'un utilisateur).
    if ($i<>14) {
      echo '<option>'.$key_tab[$i]."</option>";
    } 
}
  echo '<option>langues</option>';
  echo '<option>caractere</option>';
  echo '<option>competences</option>';
  echo '<option>outils</option>';
  echo '</select>';
  echo '</span>';


echo "<span id='nouveau'>  </span>

<span id='remplace' hidden>
<input type='button' name='valide' value='Valider' onclick='execRemplace();'>       
</span>
<br><span id='confirm'></span>


  <hr>
  <input type='button' name='delete' value='Supprimer ce compte' onclick='supprAccount()'>
  <br>
  <span id='del'></span>
  <hr>";

echo "<input type='button' name='ban' value='Bannir ce compte' onclick='changeBan(1)'>
  <br>
  <span id='ban'></span>
  <hr>";

echo "<input type='button' name='deban' value='Retirer le bannissement de ce compte' onclick='changeBan(0)'>
  <br>
  <hr>";

echo "<input type='button' name='mesag' value='Consulter la messagerie de cet utilisateur' onclick='getMessagerie()'>
  <br>
  <span id='msg'></span>
  <hr>";
}
?>
</body>
</html>