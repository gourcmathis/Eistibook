<?php
include("admin_fonctions.php");

/* Chaque information à modifier n'est pas affichée de la même façon. Exemple : au lieu de laisser un champ de texte à remplir pour le choix du sexe d'un utilisateur, un champ de type radio est affiché avec les trois choix disponibles : Homme, Femme et Autre. */


$id_util=$_POST['id_util'];   //Récupère l'ID de l'utilisateur sélectionné 
$cle=$_POST['key'];         //Récupère le type d'information choisi

if ($cle == 'type') {         //Choix du rang de cet utilisateur via un champ de type radio
	echo "<span id='rank'>        
<br>                                        
  visiteur<input type='radio' name='type' value='visiteur'>
  abonne<input type='radio' name='type' value='abonne'>
  admin <input type='radio' name='type' value='admin'>
</span>";
} elseif ($cle == 'sexe') {         //Choix du sexe de cet utilisateur via un champ de type radio
	echo "<span id='sex'>
<br>
  Homme<input type='radio' name='sexe' value='Homme'>
  Femme<input type='radio' name='sexe' value='Femme'>
  Autre<input type='radio' name='sexe' value='Autre'>
</span>";
} elseif ($cle == 'mdp') {            //Choix du mot de passe de cet utilisateur via un champ de type 'password'
  echo "<span id='pwd'>
<br>Entrer le nouveau mot de passe : <br>
<input type='password' id='new' name='new'> 
</span>";

} 

/* Même choix pour gérer les langues parlées, les compétences acquises, les caractères et les outils maitrisés de l'utilisateur :
une liste déroulante contenant, par exemple, les langues que l'utilisateur ne parle pas avec un bouton Ajouter et une autre liste avec les langues que ce dernier parle accompagnée d'un bouton Supprimer */

  elseif ($cle == 'langues') {              
  $tabLangues=get_AllNames('LANGUE');       //tableau de toutes les langues contenues dans la base de données
  $tabLanguesUtil=getInfoAnnexe($id_util,0);  //tableau contenant les langues parlées par l'utilisateur
  $j=0;
  for ($i=0; $i <count($tabLangues) ; $i++) {         //Création du tableau qui contient les langues que l'utilisateur ne parle PAS
  if (!(in_array($tabLangues[$i], $tabLanguesUtil))) {
  $notLangue[$j]=$tabLangues[$i];
  $j=$j+1;
 } 
}
  echo "<br><br>Langue à ajouter : <br>";
  echo "<select id='notlangues'>";            //Affichage de la liste déroulante des langues non parlées par l'utilisateur
  for ($i=0; $i < count($notLangue); $i++) {            
    echo "<option>".$notLangue[$i]['nom']."</option>";
  }
  echo "</select>";
  echo "<input type='button' value='Ajouter' onclick='ajoutAnnex()'>";
  echo "<br><br>Langue à supprimer : <br>";
  echo "<select id='langues'>";             //Affichage de la liste déroulante des langues parlées par l'utilisateur
  for ($i=0; $i < count($tabLanguesUtil); $i++) { 
    echo "<option>".$tabLanguesUtil[$i]['nom']."</option>";
  }
  echo "</select>";
  echo "<input type='button' value='Supprimer' onclick='supprAnnex()'>";    
  echo "<span id='status'></span>";     //Message de confirmation du bon déroulement de la requête de l'utilisateur

} elseif ($cle == 'caractere') {
  $tabCarac=get_AllNames('CARACTERE');    //tableau de tous les caractères dans la base de données
  $tabCaracUtil=getInfoAnnexe($id_util,1);      //tableau contenant les caractères de l'utilisateur
  $j=0;
  for ($i=0; $i <count($tabCarac) ; $i++) {         //Création du tableau qui contient les caracteres que l'utilisateur n'a PAS
  if (!(in_array($tabCarac[$i], $tabCaracUtil))) {
  $notCarac[$j]=$tabCarac[$i];
  $j=$j+1;
 } 
}
  echo "<br><br>Caractère à ajouter : <br>";
  echo "<select id='notcaractere'>";          //Affichage de la liste déroulante des caractères que l'utilisateur n'a pas
  for ($i=0; $i < count($notCarac); $i++) { 
    echo "<option>".$notCarac[$i]['nom']."</option>";
  }
  echo "</select>";
  echo "<input type='button' value='Ajouter' onclick='ajoutAnnex()'>";
  echo "<br><br>Caractère à supprimer : <br>";
  echo "<select id='caractere'>";               //Affichage de la liste déroulante des caractères de l'utilisateur
  for ($i=0; $i < count($tabCaracUtil); $i++) { 
    echo "<option>".$tabCaracUtil[$i]['nom']."</option>";
  }
  echo "</select>";
  echo "<input type='button' value='Supprimer' onclick='supprAnnex()'>";    
  echo "<span id='status'></span>";

  } elseif ($cle == 'competences') {
  $tabComp=get_AllNames('COMPETENCES');       //tableau de toutes les compétences présentes dans la base de données
  $tabCompUtil=getInfoAnnexe($id_util,2);      //tableau contenant les compétences de l'utilisateur
  $j=0;
  for ($i=0; $i <count($tabComp) ; $i++) {         //Création du tableau qui contient les compétences que l'utilisateur n'a PAS
  if (!(in_array($tabComp[$i], $tabCompUtil))) {
  $notComp[$j]=$tabComp[$i];
  $j=$j+1;
 } 
}
  echo "<br><br>Compétence à ajouter : <br>";
  echo "<select id='notcompetences'>";        //Affichage de la liste déroulante des compétences que l'utilisateur n'a pas
  for ($i=0; $i < count($notComp); $i++) { 
    echo "<option>".$notComp[$i]['nom']."</option>";
  }
  echo "</select>";
  echo "<input type='button' value='Ajouter' onclick='ajoutAnnex()'>";
  echo "<br><br>Compétence à supprimer : <br>";
  echo "<select id='competences'>";           //Affichage de la liste déroulante des compétences de l'utilisateur
  for ($i=0; $i < count($tabCompUtil); $i++) { 
    echo "<option>".$tabCompUtil[$i]['nom']."</option>";
  }
  echo "</select>";
  echo "<input type='button' value='Supprimer' onclick='supprAnnex()'>";    
  echo "<br><span id='status'></span>";

  } elseif ($cle == 'outils') {
  $tabOutil=get_AllNames('OUTILS');       //tableau de tous les outils présents dans la base de données
  $tabOutilUtil=getInfoAnnexe($id_util,3);    //tableau contenant les outils maitrisés par l'utilisateur
  $j=0;
  for ($i=0; $i <count($tabOutil) ; $i++) {         //Création du tableau qui contient les Outils que l'utilisateur ne maitrise pas
  if (!(in_array($tabOutil[$i], $tabOutilUtil))) {
  $notOutil[$j]=$tabOutil[$i];
  $j=$j+1;
 } 
}
  echo "<br><br>Outil à ajouter : <br>";
  echo "<select id='notoutils'>";       //Affichage de la liste déroulante des outils que l'utilisateur ne maitrise pas
  for ($i=0; $i < count($notOutil); $i++) { 
    echo "<option>".$notOutil[$i]['nom']."</option>";
  }
  echo "</select>";
  echo "<input type='button' value='Ajouter' onclick='ajoutAnnex()'>";
  echo "<br><br>Outil à supprimer : <br>";
  echo "<select id='outils'>";        //Affichage de la liste déroulante des outils que l'utilisateur maitrise
  for ($i=0; $i < count($tabOutilUtil); $i++) { 
    echo "<option>".$tabOutilUtil[$i]['nom']."</option>";
  }
  echo "</select>";
  echo "<input type='button' value='Supprimer' onclick='supprAnnex()'>";    
  echo "<span id='status'></span>";

  } elseif ($cle == 'naissance') {        //Affichage champ de texte avec un pattern pour la date de naissance
	echo "<span id='date'>
  <br>Nouvelle date de naissance : <br>
  <input type='text' id='new' pattern='\d{1,2}/\d{1,2}/\d{4}' name='date' placeholder='jj/mm/aaaa  Ex: 30/05/1990' />
</span>";
} elseif ($cle == 'promotion') {      //Affichage champ de texte avec un pattern pour l'année de promotion
  echo "<span id='promo'>
  <br>Année de diplôme : <br>
  <input type='text' pattern='\d{4}' id='new' placeholder='aaaa  Ex: 2024' />
</span>";
} else {
	echo "<span id='txt'>
<br>Entrer la nouvelle donnée : <br>
<input type='text' id='new' name='new' placeholder='Nouvelle donnée'> 
</span>";
}


?>