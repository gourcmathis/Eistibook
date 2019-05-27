<?php
include("util.php");

/* Toutes les informations considérées comme "annexes" sont les informations qui ont nécessitées la création de table de référencement dans la BDD. Ainsi, leur récupération, leur modification et leur suppression sont différentes des informations contenues dans la table principale de chaque utilisateur appelée 'EISTI_BOOK_UTILISATEUR'. */

function getInfoAnnexe($id_util, $nature) {              //Selon la valeur de '$nature', récupère les informations de l'utilisateur liées aux langues, aux caractères, aux compétences, aux outils et aux amis
	$liste = [];
	$db = connecterBDD();

	switch ($nature) {		//La requête diffère selon la valeur de '$nature'
    case 0:
        $query="SELECT nom FROM LANGUE WHERE ID_LANGUE in (SELECT m.ID_LANGUE FROM MATCH_LANGUE m, LANGUE l WHERE m.ID_LANGUE=l.ID_LANGUE AND ID_UTILISATEURS='$id_util')";
        break;
    case 1:
        $query="SELECT nom FROM CARACTERE WHERE ID_CARACTERE in (SELECT m.ID_CARACTERE FROM MATCH_CARACTERE m, CARACTERE l WHERE m.ID_CARACTERE=l.ID_CARACTERE AND ID_UTILISATEURS='$id_util')";
        break;
    case 2:
        $query="SELECT nom FROM COMPETENCES WHERE ID_COMPETENCES in (SELECT m.ID_COMPETENCES FROM MATCH_COMPETENCES m, COMPETENCES l WHERE m.ID_COMPETENCES=l.ID_COMPETENCES AND ID_UTILISATEURS='$id_util')";
        break;
    case 3:
        $query="SELECT nom FROM OUTILS WHERE ID_OUTILS in (SELECT m.ID_OUTILS FROM MATCH_OUTILS m, OUTILS l WHERE m.ID_OUTILS=l.ID_OUTILS AND ID_UTILISATEURS='$id_util')";
        break;
    case 4:
    	  $query="SELECT nom, prenom FROM EISTI_BOOK_UTILISATEUR WHERE ID_UTILISATEURS in (SELECT ID_AMIS FROM AMIS WHERE ID_UTILISATEURS='$id_util')";
        break;
      default:
      echo "erreur";
}




	$res = mysqli_query($db, $query) or die('Request error : '.$query);
	if (mysqli_num_rows($res) > 0) {
		while($row = mysqli_fetch_assoc($res)) {
			array_push($liste, $row);							//On stocke les informations dans le tableau '$liste'
			}
	}
    	deconnecterBDD($db);
    	return $liste;
}



function str_annex($id_util, $nature) {				//Transforme un tableau de chaine de caractères en chaine de caractères selon la valeur de '$nature'
		$tabTmp=getInfoAnnexe($id_util, $nature);
		$str="";
		if ($nature<>4) {							
			for ($i=0; $i < count($tabTmp) ; $i++) { 
			$str.=' | '.$tabTmp[$i]['nom'];
		}
		} else {   									// $nature == 4 : Cas où chaque case du tableau contient un nom et un prénom pour identifier un ami 
			for ($i=0; $i < count($tabTmp) ; $i++) { 
				$str.=' | '.$tabTmp[$i]['nom'].' '.$tabTmp[$i]['prenom'];
			}
		}

		$str .=" |";
		return $str;
}


function get_AllNames($table) {              //Récupère tous les noms présents dans la table en paramètre (ex : toutes les langues, tous les caractères, ...) et les met dans un tableau
  $liste = [];
  $db = connecterBDD();
  $query= "SELECT nom FROM $table";
  $res = mysqli_query($db, $query) or die('Request error : '.$query);
  if (mysqli_num_rows($res) > 0) {
    while($row = mysqli_fetch_assoc($res)) {
      array_push($liste, $row);								//On stocke les informations dans le tableau '$liste'
      }	
  }
      deconnecterBDD($db);
      return $liste;
}


//Paramètres : - $cle : 'langues', 'caractere', 'competences' ou 'outils' , i.e. type d'info à changer
//		   - $id_util : id de l'utilisateur (entier)
//		   - $valeur : donnée (string)
//		   - $modif : 'ajout' ou 'suppr' , permet de savoir si l'information doit être ajoutée ou supprimée de la table pour cet utilisateur
function modifAnnex($cle, $id_util, $valeur, $modif) {		//Ajoute ou supprime la valeur donnée en paramètre pour un certain utilisateur dans la bonne table
	$liste = [];
	$db = connecterBDD();
	switch ($cle) {           //Requête qui change en fonction de la valeur de la clé
		case 'langues':
			$query = "SELECT ID_LANGUE FROM LANGUE WHERE nom='$valeur'";
			$res = mysqli_query($db, $query) or die('Request error : '.$query);
			if (mysqli_num_rows($res) > 0) {
				while($row = mysqli_fetch_assoc($res)) {
					array_push($liste, $row);
					}
			}
			
			$id=$liste[0]['ID_LANGUE'];     //ID_LANGUE est unique donc $liste est de taille 1, on récupère juste la première et unique valeur
			break;
		case 'caractere':
			$query = "SELECT ID_CARACTERE FROM CARACTERE WHERE nom='$valeur'";
			$res = mysqli_query($db, $query) or die('Request error : '.$query);
			if (mysqli_num_rows($res) > 0) {
				while($row = mysqli_fetch_assoc($res)) {
					array_push($liste, $row);
					}
			}
			
			$id=$liste[0]['ID_CARACTERE'];	//ID_CARACTERE est unique donc $liste est de taille 1, on récupère juste la première et unique valeur
			break;
		case 'competences':
			$query = "SELECT ID_COMPETENCES FROM COMPETENCES WHERE nom='$valeur'";
			$res = mysqli_query($db, $query) or die('Request error : '.$query);
			if (mysqli_num_rows($res) > 0) {
				while($row = mysqli_fetch_assoc($res)) {
					array_push($liste, $row);
					}
			}
			$id=$liste[0]['ID_COMPETENCES'];	//ID_COMPETENCES est unique donc $liste est de taille 1, on récupère juste la première et unique valeur
			break;
		case 'outils':
			$query = "SELECT ID_OUTILS FROM OUTILS WHERE nom='$valeur'";
			$res = mysqli_query($db, $query) or die('Request error : '.$query);
			if (mysqli_num_rows($res) > 0) {
				while($row = mysqli_fetch_assoc($res)) {
					array_push($liste, $row);
					}
			}
			$id=$liste[0]['ID_OUTILS'];	//ID_OUTILS est unique donc $liste est de taille 1, on récupère juste la première et unique valeur
			break;
		default:
			break;
	}

	if ($modif=="ajout") {			//Infos qui doivent être ajoutées

		switch ($cle) {
			case 'langues':
				$query = "INSERT INTO MATCH_LANGUE (`ID_UTILISATEURS`, `ID_LANGUE`) VALUES ('$id_util','$id')";
				break;
			case 'caractere':
				$query = "INSERT INTO MATCH_CARACTERE (`ID_UTILISATEURS`, `ID_CARACTERE`) VALUES ('$id_util','$id')";
				break;
			case 'competences':
				$query = "INSERT INTO MATCH_COMPETENCES (`ID_UTILISATEURS`, `ID_COMPETENCES`) VALUES ('$id_util','$id')";
				break;
			case 'outils':
				$query = "INSERT INTO MATCH_OUTILS (`ID_UTILISATEURS`, `ID_OUTILS`) VALUES ('$id_util','$id')";
				break;
			default:
				break;
		}		
	} else {						//Cas où $modif=='suppr' donc que les informations doivent être supprimées

	switch ($cle) {
			case 'langues':
				$query = "DELETE FROM MATCH_LANGUE WHERE ID_UTILISATEURS='$id_util' AND ID_LANGUE='$id'";
				break;
			case 'caractere':
				$query = "DELETE FROM MATCH_CARACTERE WHERE ID_UTILISATEURS='$id_util' AND ID_CARACTERE='$id'";
				break;
			case 'competences':
				$query = "DELETE FROM MATCH_COMPETENCES WHERE ID_UTILISATEURS='$id_util' AND ID_COMPETENCES='$id'";
				break;
			case 'outils':
				$query = "DELETE FROM MATCH_OUTILS WHERE ID_UTILISATEURS='$id_util' AND ID_OUTILS='$id'";
				break;
			default:
				break;

}	
}
	$res = mysqli_query($db, $query) or die('Request error : '.$query);	//Envoie la requête SQL à la base de données
	deconnecterBDD($db);
}

//Paramètres : - $id_util : id de l'utilisateur (entier)
//		   - $cle : colonne de la table principale de la BDD : 'EISTI_BOOK_UTILISATEUR' , i.e. type d'info à changer
//		   - $valeur : nouvelle donnée qui doit remplacer l'ancienne (string)
function modifInfo($id_util, $cle, $valeur) {	
	$db = connecterBDD();
	$query = "UPDATE EISTI_BOOK_UTILISATEUR SET $cle = '$valeur' WHERE ID_UTILISATEURS = '$id_util'"; 
	$res = mysqli_query($db, $query) or die('Request error : '.$query);
	deconnecterBDD($db);
}



?>