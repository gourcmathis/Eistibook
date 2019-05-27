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

	mysqli_free_results($query);
	
	
	
// on supprime l'utilisateur et toutes ses occurences dans les autres tables (match_...)
	$query2="DELETE FROM MATCH_CARACTERE WHERE ID_UTILISATEUR=$id;
		DELETE FROM MATCH_COMPETENCES WHERE ID_UTILISATEUR=$id;
		DELETE FROM MATCH_LANGUES WHERE ID_UTILISATEUR=$id;
		DELETE FROM MATCH_OUTILS WHERE ID_UTILISATEUR=$id;
		DELETE FROM EISTI_BOOK_UTILISATEUR WHERE ID_UTILISATEUR=$id;";
		
	$res2 = mysqli_query($db, $query2) or die('Request error : '.$query); // booléen qui indique si ça a foncionné
	
	
		



// on recrée l'utilisateur 
	if ($res2) {
		$query3="INSERT INFO EISTI_BOOK_UILISATEUR VALUES ('$type', '$nom', '$prenom', '$login','$_POST['profession']', '$POST['ville']', '$POST['intro']', '$POST['citation'], '$POST['loisir'], '$sexe', '$POST['photo']', '$POST['emploi']', '$POST['dimplome']', '$mdp', '$id', '$signalements', '$blocages', '$mur', '$naissance', '$POST['promotion']') ";
		$res3 = mysqli_query($db, $query2) or die('Request error : '.$query);
		// TODO à vérifier + ... 
		
			
	}
	
	
// on replace dans les tables ses compétences, caractères ... 

















deconnecterBDD($db);

?>
