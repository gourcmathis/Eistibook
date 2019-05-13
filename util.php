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
		echo "l'inscription a bien été effectuée" ;
	} else {
		echo "il y a eu une erreur";
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
			echo "vos identifiants sont faux !";
		}
	}
	deconnecterBDD($db);
}



function deleteLogin($username) {
	$db = connecterBDD("127.0.0.1", "chatryroxa", "V84mC47");
	$query="DELETE FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='$username'";
	$res = mysqli_query($db, $query) or die('Request error : '.$query);
	if ($res) { 
		echo "Votre compte a bien été supprimé." ;
	} else {
		echo "Il y a eu une erreur...";
	}
}



?>













