<?php
require("util.php");

// on récupère l'ancien mdp
	$db = connecterBDD();
	$login=$_GET['perso'];
	$query="SELECT MDP FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='$login'";
	$res = mysqli_query($db, $query) or die('Request error : '.$query);
	$rep= mysqli_fetch_array($res);
	$ancien=$rep[0];
	


// on vérifie que c'est le meme que le mot de passe actuel donné
	if (md5($_POST['actuel'])==$ancien) {
		// si oui, on change le mot de passe dans la bdd
		$query2="UPDATE EISTI_BOOK_UTILISATEUR SET MDP='".md5($_POST['nouveau'])."' WHERE LOGIN='".$login."' ";
		$res2=mysqli_query($db, $query2) or die('Request error : '.$query2);
	}

deconnecterBDD($db);
	
// on redirige vers la page de profil ($res2 indique si les modifications ont fonctionné ou non)
echo "<script>document.location.replace('profil.php?perso=".$login."&valid=".$res2."')</script>";


?>
