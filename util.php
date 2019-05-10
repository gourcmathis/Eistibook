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
	$query = "SELECT nom, prenom FROM Abonnes";
	$res = mysqli_query($db, $query) or die('Request error : '.$query);
	if (mysqli_num_rows($res) > 0) {
		$i=0;
		while($row = mysqli_fetch_assoc($res)) {
			$lstEleves[$i]= array('prenom'=>$row['prenom'], 'nom'=>$row['nom']) ;
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
	$tel = $formdata['tel'];
	$email = $formdata['email'];
	$motDePasse = $formdata['password'];

	$db = connecterBDD();
    
	$query="INSERT INTO ????? (nom,prenom,tel,email,motDePasse) VALUES ('$nom', '$prenom', '$tel', '$email', '$motDePasse')";
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
	
	$query = "SELECT email, motDePasse FROM ???? ";
	
	$res=mysqli_query($db,$query) or die('Request error : '.$query);
	
	if (mysqli_num_rows($res)>0) {
		$trouve=false;
		while ($row = mysqli_fetch_assoc($res)) {
			if ( $row['email']==$email && $row['motDePasse']==$motDePasse ) {
				$trouve=true;
				$req="SELECT * FROM ????? WHERE email='".$email."' AND motDePasse='".$motDePasse."'";
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
	$query="DELETE FROM ????? WHERE email='$username'";
	$res = mysqli_query($db, $query) or die('Request error : '.$query);
	if ($res) { 
		echo "Votre compte a bien été supprimé." ;
	} else {
		echo "Il y a eu une erreur...";
	}
}




?>













