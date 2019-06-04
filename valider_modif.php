<?php 
require('util.php');

// cette page permet de valider des modifications dans un profil



// on récupère le loin de la personne concernée
	$login=$_SESSION['page_modifiee'];


//on récupère aussi les infos non modifiables dans le profil (signalements, blocages, id, nom, prenom, date de naissance, type, sexe s'il existe )
	$db = connecterBDD();
	$query="SELECT * FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='".$login."'";
	$res = mysqli_query($db, $query) or die('Request error : '.$query);
	$infos=mysqli_fetch_assoc($res);
	$signalements=$infos['SIGNALEMENT'];
	$blocages=$infos['BLOCAGE'];
	$id=$infos['ID_UTILISATEURS'];
	$mur=$infos['MUR'];
	$nom=$infos['NOM'];
	$prenom=$infos['PRENOM'];
	$naissance=$infos['NAISSANCE'];
	$type=$infos['TYPE'];
	$mdp=$infos['MDP'];
	
	// cas du sexe pas forcément défini (si il était déjà défini il n'est pas modifiable)
	if (isset($_POST['genre'])) {
		$sexe=$_POST['genre'];
	} elseif (isset($infos['SEXE'])) {
		$sexe=$infos['SEXE'];
	} else {
		$sexe="";
	}

	
	
	
// on supprime l'utilisateur et toutes ses occurences dans les autres tables (match_...)
	$query2="DELETE FROM MATCH_CARACTERE WHERE ID_UTILISATEURS='".$id."';";
	$res2 = mysqli_query($db, $query2) or die('Request error : '.$query2); // booléen qui indique si ça a fonctionné
	
	$query3="DELETE FROM MATCH_COMPETENCES WHERE ID_UTILISATEURS='".$id."';";
	$res3 = mysqli_query($db, $query3) or die('Request error : '.$query3); 

	$query4="DELETE FROM MATCH_LANGUE WHERE ID_UTILISATEURS='".$id."';";
	$res4 = mysqli_query($db, $query4) or die('Request error : '.$query4);
	
	$query5="DELETE FROM MATCH_OUTILS WHERE ID_UTILISATEURS='".$id."';";
	$res5 = mysqli_query($db, $query5) or die('Request error : '.$query5); 
	
	$query6="DELETE FROM EISTI_BOOK_UTILISATEUR WHERE ID_UTILISATEURS='".$id."';";
	$res6 = mysqli_query($db, $query6) or die('Request error : '.$query6); 
	
	
	$resf=($res2 && $res3 && $res4 && $res5 && $res6);	



// on recrée l'utilisateur et on replace dans les tables ses compétences, caractères ... 
	if ($resf) {
		
		// requete Utilisateur
			$query3="INSERT INTO EISTI_BOOK_UTILISATEUR VALUES ('".$type."', '".$nom."', '".$prenom."', '".$login."','".$_POST['profession']."', '".$_POST['ville']."', '".$_POST['intro']."', '".$_POST['citation']."', '".$_POST['loisir']."', '".$sexe."', '".$_POST['photo']."', '".$_POST['emploi']."', '".$_POST['diplome']."', '".$mdp."', '".$id."', '".$signalements."', '".$blocages."', '".$mur."', '".$naissance."', '".$_POST['promo']."');";
		$res3 = mysqli_query($db, $query3) or die('Request error : '.$query3);
		
		// requête caractère 
			$res_c=true;
			if (!empty($_POST['caractere']) ) {
				$caract=$_POST['caractere'];
				$values="";
				$len=count($caract);
				for ($i=0; $i<$len-1; $i++) {
					$values.="('".$id."','".$caract[$i]."'),";
				}
				$values.="('".$id."','".$caract[$len-1]."')";		
				$query_caract="INSERT INTO MATCH_CARACTERE VALUES $values;";
				$res_c = mysqli_query($db, $query_caract) or die('Request error : '.$query_caract);
			}
		// requête compétences
			$res_co=true;
			if (isset($_POST['competences']) ) {
				$comp=$_POST['competences'];
				$values="";
				$len=count($comp);
				for ($i=0; $i<$len-1; $i++) {
					$values.="('".$id."','".$comp[$i]."'),";
				}
				$values.="('".$id."','".$comp[$len-1]."')";		
				$query_comp="INSERT INTO MATCH_COMPETENCES VALUES $values;";
				$res_co = mysqli_query($db, $query_comp) or die('Request error : '.$query_comp);
			}
		// requête langues 
			$res_l=true;
			if (isset($_POST['langues']) ) {
				$langues=$_POST['langues'];
				$values="";
				$len=count($langues);
				for ($i=0; $i<$len-1; $i++) {
					$values.="('".$id."','".$langues[$i]."'),";
				}
				$values.="('".$id."','".$langues[$len-1]."')";	
				$query_langues="INSERT INTO MATCH_LANGUE VALUES $values;";
				$res_l = mysqli_query($db, $query_langues) or die('Request error : '.$query_langues);
			}
		// requête outils 
			$res_o=true;
			if (isset($_POST['outils']) ) {
				$outils=$_POST['outils'];
				$values="";
				$len=count($outils);
				for ($i=0; $i<$len-1; $i++) {
					$values.="('".$id."','".$outils[$i]."'),";
				}
				$values.="('".$id."','".$outils[$len-1]."')";		
				$query_outils="INSERT INTO MATCH_OUTILS VALUES $values;";
				$res_o = mysqli_query($db, $query_outils) or die('Request error : '.$query_outils);
			}	
		
	}

// teste la réussite de la manipulation
	$reus=($res3 && $res_c && $res_co && $res_l && $res_o);
deconnecterBDD($db);

//redirection vers la page de profil (modifiée)
echo "<script>document.location.replace('profil.php?perso=".$login."&valid=".$reus."')</script>";

?>