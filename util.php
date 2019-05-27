<?php
session_start();

//login: protonguil
//pass: 8vQvim2
//Bdd: 2018_p0_cpi02_protonguil
function connecterBDD() {

        $DBconn = mysqli_connect("127.0.0.1","protonguil", "8vQvim2" , "2018_p0_cpi02_protonguil");
        if (!$DBconn) {
            die("Erreur: " . mysqli_connect_error());
        }

        return $DBconn;
    }

function deconnecterBDD($DBconn) {
        if (isset($DBconn)) {
            mysqli_close($DBconn);
        }
    }


function getListeEleves() {

	$lstEleves = [];
	$db = connecterBDD();
	$query = "SELECT NOM, PRENOM FROM EISTI_BOOK_UTILISATEUR";
	$res = mysqli_query($db, $query) or die('Request error : '.$query);
	if (mysqli_num_rows($res) > 0) {
		$i=0;
		while($row = mysqli_fetch_assoc($res)) {
			$lstEleves[$i]= array('prenom'=>$row['PRENOM'], 'nom'=>$row['NOM']) ;
			$i++;
		}
	} else {
    		echo "No results";
    	}
	deconnecterBDD($db);
	return $lstEleves;
}

function getInfos() {

	$lstInfos = [];
	$db = connecterBDD();
	$query = "SELECT TYPE, NOM, PRENOM, LOGIN, PROFESSION, VILLE, INTRO, CITATION, LOISIR, SEXE, PHOTO, EMPLOIS, DIPLOME, MDP, ID_UTILISATEURS, SIGNALEMENT, BLOCAGE, MUR, NAISSANCE, PROMOTION FROM EISTI_BOOK_UTILISATEUR";
	$res = mysqli_query($db, $query) or die('Request error : '.$query);
	if (mysqli_num_rows($res) > 0) {
		$i=0;
		while($row = mysqli_fetch_assoc($res)) {
			$lstInfos[$i]= array('type'=>$row['TYPE'], 'nom'=>$row['NOM'], 'prenom'=>$row['PRENOM'], 'login'=>$row['LOGIN'], 'profession'=>$row['PROFESSION'], 'ville'=>$row['VILLE'], 'intro'=>$row['INTRO'], 'citation'=>$row['CITATION'], 'loisir'=>$row['LOISIR'], 'sexe'=>$row['SEXE'], 'photo'=>$row['PHOTO'], 'emplois'=>$row['EMPLOIS'], 'diplome'=>$row['DIPLOME'], 'mdp'=>$row['MDP'], 'id_utilisateurs'=>$row['ID_UTILISATEURS'], 'signalement'=>$row['SIGNALEMENT'], 'blocage'=>$row['BLOCAGE'], 'mur'=>$row['MUR'], 'naissance'=>$row['NAISSANCE'], 'promotion'=>$row['PROMOTION']) ;
			$i++;
		}
	} else {
    		echo "No results";
    	}
	deconnecterBDD($db);
	return $lstInfos;
}

function insertEleve($formdata) {

	$nom = $formdata['nom'];
	$prenom = $formdata['prenom'];
	$ddn = $formdata['ddn'];
	$email = $formdata['email'];
	$promo = $formdata['promo'];
	$motDePasse = $formdata['password'];

	$db = connecterBDD();
   
	$query="INSERT INTO EISTI_BOOK_UTILISATEUR (NOM,PRENOM,LOGIN,MDP,NAISSANCE,PROMOTION) VALUES ('$nom', '$prenom', '$email', '$motDePasse','$ddn', '$promo')";
	$res = mysqli_query($db, $query) or die('Request error : '.$query);
	if ($res) { 
		echo '<script> alert("l\'inscription a bien été effectuée") </script>';
		// echo "l'inscription a bien été effectuée" ;
	} else {
		echo '<script> alert("il y a eu une erreur") </script>';
		// echo "il y a eu une erreur";
	}
    
	deconnecterBDD($db);
}



function tryLogin($formdata) {

	$email = $formdata['email'];
	$motDePasse = $formdata['password'];
	$db = connecterBDD();
	
	$query = "SELECT LOGIN, MDP FROM EISTI_BOOK_UTILISATEUR ";
	
	$res=mysqli_query($db,$query) or die('Request error : '.$query);
	
	if (mysqli_num_rows($res)>0) {
		$trouve=false;
		while ($row = mysqli_fetch_assoc($res)) {
			if ( $row['LOGIN']==$email && $row['MDP']==$motDePasse ) {
				$trouve=true;
				$req="SELECT TYPE FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='".$email."' AND MDP='".$motDePasse."'";
				$reponse=mysqli_query($db,$req) or die("erreur : ".$req);
				$donnees=mysqli_fetch_assoc($reponse);
				$_SESSION['login']=$email;
				$_SESSION['MDP']=$motDePasse;
				$_SESSION['type']=$donnees['TYPE'];
			}	
		}
		if (!$trouve) {
			// echo "vos identifiants sont faux !";
			echo '<script> alert("Vos identifiants sont faux !") </script>';
		}
	}
	deconnecterBDD($db);
}



function deleteLogin($username) {
	$db = connecterBDD();
	$query="DELETE FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='$username'";
	$res = mysqli_query($db, $query) or die('Request error : '.$query);
	if ($res) { 
		echo '<script> alert("Votre compte a bien été supprimé.") </script>';
		// echo "Votre compte a bien été supprimé." ;
	} else {
		echo '<script> alert("Il y a eu une erreur...") </script>';
		// echo "Il y a eu une erreur...";
	}
	deconnecterBDD($db);
}



// vérifie que le profil existe 
function existe($login) {
	$db = connecterBDD();
	$query="SELECT * FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='$login'";
	$res = mysqli_query($db, $query) or die('Request error : '.$query);
	if (mysqli_num_rows($res)==0) {
		// il n'y a pas d'utilisateur avec ce login
		$rep=false;
	} else {
		$rep=true;
	}	
	deconnecterBDD($db);
	return $rep;
}


// regarde si util1 et util2 sont amis 
// paramètres : les 2 logins,
// retourne un booléen
function amis($util1,$util2) {
	$db = connecterBDD();
	// on selectionne tous les amis de util1
	$query="SELECT LOGIN FROM EISTI_BOOK_UTILISATEUR WHERE ID_UTILISATEURS IN (SELECT ID_AMIS FROM AMIS WHERE ID_UTILISATEURS=(SELECT ID_UTILISATEURS FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='$util1'));";
	$res = mysqli_query($db, $query) or die('Request error : '.$query);
	// puis on regarde si util2 en fait partie
	$amis=false;
	if (mysqli_num_rows($res)>0) {
		while ($row = mysqli_fetch_assoc($res)) {
			if ( $row["LOGIN"]==$util2 ) {
				$amis=true;
			}
		}
	}
	deconnecterBDD($db);	
	return($amis);
}


// récupère toutes les infos utilisateur liées à un profil
// ne fonctionne pas pour toutes 
function chargerInfos($login) {
	$db = connecterBDD();
	// on selectionne toutes les infos utilisateur
	$query="SELECT * FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='$login'";
	$res = mysqli_query($db, $query) or die('Request error : '.$query);
	$tableau = mysqli_fetch_assoc($res);
	
	// puis on selectionne les infos de caractère ... 
	$queryCa="SELECT NOM FROM CARACTERE WHERE ID_CARACTERE IN (SELECT ID_CARACTERE FROM MATCH_CARACTERE c WHERE c.ID_UTILISATEURS=(SELECT ID_UTILISATEURS FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='$login'))";
	$resCa = mysqli_query($db, $queryCa) or die('Request error : '.$queryCa);
	$caract=array();
	if (mysqli_num_rows($resCa)>0) {
		$i=0;
		while ($row = mysqli_fetch_assoc($resCa)) {
			$caract[$i]=$row['NOM'];
			$i++;
		}
	}
	
	// ... puis de compétences ...
	$queryComp="SELECT NOM FROM COMPETENCES WHERE ID_COMPETENCES IN (SELECT ID_COMPETENCES FROM MATCH_COMPETENCES c WHERE c.ID_UTILISATEURS=(SELECT ID_UTILISATEURS FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='$login'))";
	$resComp = mysqli_query($db, $queryComp) or die('Request error : '.$queryComp);
	$comp=array();
	if (mysqli_num_rows($resComp)>0) {
		$i=0;
		while ($row = mysqli_fetch_assoc($resComp)) {
			$comp[$i]=$row['NOM'];
			$i++;
		}
	}

	// ... puis de langues ...
	$queryL="SELECT NOM FROM LANGUE WHERE LANGUE.ID_LANGUE IN (SELECT ID_LANGUE FROM MATCH_LANGUE c WHERE c.ID_UTILISATEURS=(SELECT ID_UTILISATEURS FROM EISTI_BOOK_UTILISATEUR e WHERE e.LOGIN='$login'))";
	$resL = mysqli_query($db, $queryL) or die('Request error : '.$queryL);
	$langues=array();
	if (mysqli_num_rows($resL)>0) {
		$i=0;
		while ($row = mysqli_fetch_assoc($resL)) {
			$langues[$i]=$row['NOM'];
			$i++;
		}
	}
	
	// ... et enfin d'outils
	$queryOu="SELECT NOM FROM OUTILS WHERE ID_OUTILS IN (SELECT ID_OUTILS FROM MATCH_OUTILS c WHERE c.ID_UTILISATEURS=(SELECT ID_UTILISATEURS FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='$login'))";
	$resOu = mysqli_query($db, $queryOu) or die('Request error : '.$queryOu);
	$outils=array();
	if (mysqli_num_rows($resOu)>0) {
		$i=0;
		while ($row = mysqli_fetch_assoc($resOu)) {
			$outils[$i]=$row['NOM'];
			$i++;
		}
	}
	
	deconnecterBDD($db);
	return array($tableau,$caract,$comp,$langues,$outils);
}

// récupère le nom prénom et photo de tous les amis du profil donné
function chargerListeAmis($login) {
	$db = connecterBDD();
	// on selectionne tous les amis de login (c'est à dire les personnes avec qui il est amis et pas ceux qui sont amis avec lui)
	$query="SELECT LOGIN, NOM, PRENOM, PHOTO FROM EISTI_BOOK_UTILISATEUR e WHERE e.ID_UTILISATEURS IN (SELECT ID_AMIS FROM AMIS WHERE ID_UTILISATEURS  = (SELECT ID_UTILISATEURS FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='$login'))";
	$res = mysqli_query($db, $query) or die('Request error : '.$query);
	if (mysqli_num_rows($res)>0) {
		$i=0;
		while ($row = mysqli_fetch_assoc($res)) {
			$tableau[$i]=$row;
			$i++;
		}
		return $tableau;
	}
}

// affiche sur la page de profil les infos des amis à partir de la liste d'amis
function affichageAmisProfil($liste) {
	foreach ($liste as $ami) {
		echo "<a href='profil.php?perso=".$ami['LOGIN']."'><div class='ami'>";
		if (isset($ami['photo'])) {
			$src=$ami['photo'];
			echo "<p><img class='photoprofil' src='".$src."'></img></p>";
		} else {
			echo "<p><img class='photoprofil' src='poulet.jpg'></img></p>";
		}
		echo "<h4> ".$ami['NOM']." ".$ami['PRENOM']." </h4></div></a>";
	}
}



// charge toutes les options de caractère, langue, compétences et outils pour former les checkbox de edit_profil
// TODO à vérifier !!! 
function chargerOptions() {
	$db = connecterBDD();
	
	// on selectionne les options de caractère ... 
	$queryCa="SELECT * FROM CARACTERE";
	$resCa = mysqli_query($db, $queryCa) or die('Request error : '.$queryCa);
	$caract=array();
	if (mysqli_num_rows($resCa)>0) {
		$i=0;
		while ($row = mysqli_fetch_assoc($resCa)) {
			$caract[$i]=array($row['NOM'],$row['ID_CARACTERE']);
			$i++;
		}
	}
	
	// ... puis de compétences ...
	$queryComp="SELECT * FROM COMPETENCES";
	$resComp = mysqli_query($db, $queryComp) or die('Request error : '.$queryComp);
	$comp=array();
	if (mysqli_num_rows($resComp)>0) {
		$i=0;
		while ($row = mysqli_fetch_assoc($resComp)) {
			$comp[$i]=array($row['NOM'],$row['ID_COMPETENCES']);
			$i++;
		}
	}

	// ... puis de langues ...
	$queryL="SELECT * FROM LANGUE";
	$resL = mysqli_query($db, $queryL) or die('Request error : '.$queryL);
	$langues=array();
	if (mysqli_num_rows($resL)>0) {
		$i=0;
		while ($row = mysqli_fetch_assoc($resL)) {
			$langues[$i]=array($row['NOM'],$row['ID_LANGUE']);
			$i++;
		}
	}
	
	// ... et enfin d'outils
	$queryOu="SELECT * FROM OUTILS";
	$resOu = mysqli_query($db, $queryOu) or die('Request error : '.$queryOu);
	$outils=array();
	if (mysqli_num_rows($resOu)>0) {
		$i=0;
		while ($row = mysqli_fetch_assoc($resOu)) {
			$outils[$i]=array($row['NOM'],$row['ID_OUTILS']);
			$i++;
		}
	}
	
	deconnecterBDD($db);
	return array($caract,$comp,$langues,$outils);
}




//Charge toutes les publications d'un profil donné 
function chargerPubli_profil($profil) {
	$db=connecterBDD();
	$query = "SELECT auteur, date, texte FROM publication WHERE auteur='".$profil."'ORDER BY date DESC;";
	$res = mysqli_query($db, $query) or die('Erreur SQL !<br />'.$query.'<br />'.mysqli_error());

	// on compte le nombre de publi correspondant
	$nb_publi = mysqli_num_rows($res);

	if ($nb_publi == 0) {
	    echo 'Aucune publication enregistrée.';
	} else {
    		// si on a au moins une publi, on l'affiche
    		while ($data = mysqli_fetch_array($res)) {

    			// on décompose la date
   			sscanf($data['date'], "%4s-%2s-%2s %2s:%2s:%2s", $an, $mois, $jour, $heure, $min, $sec);

    			// on affiche les résultats
   			 echo '<div class="publication" >' ;
   			 echo '<p class="nom" >' ;
   			 echo '<br />Publication de : ' , htmlentities(trim($data['auteur'])) , '<br />';
   			 echo 'Le : ' , $jour , '/' , $mois , '/' , $an , ' à ' , $heure , ':' , $min , ':' , $sec , '<br /><br />';
   			 echo '</p>' ;
   			 echo '' , nl2br(htmlentities(trim($data['texte']))) , '<br />';
   			 echo "</div>";
    		}
    	}
    	
	// on libère l'espace mémoire alloué à cette requête
	mysqli_free_result ($res);

	// on ferme la connexion à la base de données
	mysqli_close ($db);
}

?>













