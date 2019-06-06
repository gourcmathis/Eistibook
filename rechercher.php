<?php
require('util.php');
$mc=$_POST['motsClefs'];

$db = connecterBDD();

// on sépare pour faire la recherche dans les cas où plusieurs mots clefs sont donnés
$mots=explode(" ", $mc);
$n=count($mots);
$query="SELECT NOM,PRENOM,LOGIN,PHOTO FROM EISTI_BOOK_UTILISATEUR WHERE ";
for ($i=0;$i<$n-1;$i++) {
	$m=$mots[$i];
	$query.="LOGIN LIKE '%$m%' OR NOM LIKE '%$m%' OR PRENOM LIKE '%$m%' OR ";
	}
$m=$mots[$n-1];
$query.="LOGIN LIKE '%$m%' OR NOM LIKE '%$m%' OR PRENOM LIKE '%$m%';";
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
		echo "<div class='prof'>";
		echo "<a href='profil.php?perso=".$resultat['LOGIN']."'>";
		if (!empty($resultat['PHOTO'])) {
			$src=$resultat['PHOTO'];
			echo "<p><img class='photoprofil' src='".$src."'></img></p>";
		} else {
			echo "<p><img class='photoprofil' src='poulet.jpg'></img></p>";
		}
		echo "<h4> ".$resultat['NOM']." ".$resultat['PRENOM']." ".$resultat['LOGIN']." </h4></a>";
		
		
		// si on tombe sur son propre profil 
		if ($_SESSION['login']==$resultat['LOGIN']) {
			echo "C'est vous ! ";
		// regarder si amis + boutons ajouter ou supprimer amitié 
		 } elseif ( amis($_SESSION['login'],$resultat['LOGIN']) ) {
			// bonton supprimer de mes amis
			echo "<input class='buton' type='button' value='Supprimer de mes amis' id='".$resultat['LOGIN']."' onclick='supprimerAmi(this,0)' />";
		} else {
			// bouton ajouter à mes amis
			echo "<input class='buton' type='button' value='Ajouter à mes amis'  id='".$resultat['LOGIN']."' onclick='ajouterAmi(this)' />";
		}
		
		echo "</div>";
	}
}

deconnecterBDD($db);




?>