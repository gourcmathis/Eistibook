<?php
session_start();
require("core.php");



function getListeAbonnes() {

	$lstAbonnes = [];

//	$lstAbonnes = [
//	['prenom'=>'Prenom1', 'nom'=>'Nom1'],
//	['prenom'=>'Prenom2', 'nom'=>'Nom2'],
//	['prenom'=>'Prenom3', 'nom'=>'Nom3']
//	];
	//paramètres = serveur, user, password
	$db = connecterBDD("127.0.0.1", "chatryroxa", "V84mC47");

	//TODO Générer le contenu de la variable $tab en fonction des données présentes dans la BDD
//	$servername = "localhost";
//	$username = "erc";
//	$password = "7uN$3kREt";
//	$dbname = "2017_database_erc";

	$query = "SELECT nom, prenom FROM Abonnes";
	$res = mysqli_query($db, $query) or die('Request error : '.$query);
	if (mysqli_num_rows($res) > 0) {
		$i=0;
		while($row = mysqli_fetch_assoc($res)) {
			$lstAbonnes[$i]= array('prenom'=>$row['prenom'], 'nom'=>$row['nom']) ;
			$i++;
		}
	} else {
    		echo "No results";
    	}


	deconnecterBDD($db);
	return $lstAbonnes;
}


function insertAbonne($formdata) {

	$nom = $formdata['nom'];
	$prenom = $formdata['prenom'];
	$tel = $formdata['tel'];
	$email = $formdata['email'];
	$motDePasse = $formdata['password'];

	$db = connecterBDD("127.0.0.1", "chatryroxa", "V84mC47");
    
	$query="INSERT INTO Abonnes (nom,prenom,tel,email,motDePasse) VALUES ('$nom', '$prenom', '$tel', '$email', '$motDePasse')";
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
	$db = connecterBDD("127.0.0.1", "chatryroxa", "V84mC47");
	
	$query = "SELECT email, motDePasse FROM Abonnes";
	
	$res=mysqli_query($db,$query) or die('Request error : '.$query);
	
	if (mysqli_num_rows($res)>0) {
		$trouve=false;
		while ($row = mysqli_fetch_assoc($res)) {
			if ( $row['email']==$email && $row['motDePasse']==$motDePasse ) {
				$trouve=true;
				$req="SELECT * FROM Abonnes WHERE email='".$email."' AND motDePasse='".$motDePasse."'";
				$reponse=mysqli_query($db,$req) or die("erreur : ".$req);
				$donnees=mysqli_fetch_assoc($reponse);
				$_SESSION['email']=$email;
				$_SESSION['motDePasse']=$motDePasse;
				$_SESSION['id']=$donnees['id'];
				$_SESSION['nom']=$donnees['nom'];
				$_SESSION['prenom']=$donnees['prenom'];
				$_SESSION['tel']=$donnees['tel'];
				echo "<p>vous etes enregistre</p>";
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
	$query="DELETE FROM Abonnes WHERE email='$username'";
	$res = mysqli_query($db, $query) or die('Request error : '.$query);
	if ($res) { 
		echo "Votre compte a bien été supprimé." ;
	} else {
		echo "Il y a eu une erreur...";
	}
	
	    
}



















