<?php
require('util.php');
$mc=$_POST['motsClefs'];

echo $_SESSION['login'];
$db = connecterBDD();

// mettre un split pour le cas ou on met "nom [espace] prenom" + un foreach TODO 
$mots=explode(" ", $mc)
if (!empty($mots)) {
	$query="SELECT NOM,PRENOM,LOGIN,PHOTO FROM EISTI_BOOK_UTILISATEUR WHERE "
	foreach ($mots as $m) {
		$query.="LOGIN LIKE '%$m%' OR NOM LIKE '%$m%' OR PRENOM LIKE '%$m%'";
	}
$res = mysqli_query($db, $query) or die('Request error : '.$query);

if (mysqli_num_rows($res)>0) {
	$i=0;
	while ($row = mysqli_fetch_assoc($res)) {
		$tableau[$i]=$row;
		$i++;
	}
}


if (!empty($tableau)) {
	foreach ($tableau as $resultat) {
		echo "<div class=''>";
		echo "<a href='profil.php?perso=".$resultat['LOGIN']."'>";
		if (!empty($resultat['PHOTO'])) {
			$src=$resultat['PHOTO'];
			echo "<p><img class='photoprofil' src='".$src."'></img></p>";
		} else {
			echo "<p><img class='photoprofil' src='poulet.jpg'></img></p>";
		}
		echo "<h4> ".$resultat['NOM']." ".$resultat['PRENOM']." ".$resultat['LOGIN']." </h4></a>";
		
		// regarder si amis + boutons ajouter ou supprimer amitié 
		if ( amis($_SESSION['login'],$resultat['LOGIN']) ) {
			// bonton supprimer de mes amis
			echo "<input class='buton' type='button' value='Supprimer de mes amis' id='".$resultat['LOGIN']."' onclick='supprimerAmi(this)' />";
		} else {
			// bouton ajouter à mes amis
			echo "<input class='buton' type='button' value='Ajouter à mes amis'  id='".$resultat['LOGIN']."' onclick='ajouterAmi(this)' />";
		}
		
		echo "</div>";
	}
}

deconnecterBDD($db);



//TODO 
	// condition quand on fait une recherche et qu'on tombe sur son propre profil
	//recherche par nom prenom



?>
