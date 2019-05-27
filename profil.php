<!-- atention, si on ouvre on page de profil, il faut toujours en get la personne dont on regarde le profil -->
<?php
require("util.php");
?>
<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title>EISTI - BOOK </title>
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css"
          rel="stylesheet" type="text/css">
    <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css"
          rel="stylesheet" type="text/css"> -->
          <link href="./base.css"
          rel="stylesheet" type="text/css">
          <link href="./fil.css"
          rel="stylesheet" type="text/css">
           <link href="./profil.css"
          rel="stylesheet" type="text/css">
</head>


<?php 

if (empty($_GET) || !existe($_GET["perso"]) ) { 
	echo "<div class='error'>Cette page n'existe pas. </div>";
	$acces='none';
	// même message dans le cas où la page de profil recherchée n'existe pas ? 
} else {
	// page profil de qui : récup les identifiants dans la session
	$pageDe=$_GET["perso"];
	
	// vérifier que la personne connectée est un utilisateur (si visiteur ou session vide : message d'erreur)
	if (empty($_SESSION) || $_SESSION['type']=='visiteur') {
		echo "<div class='error'> Vous ne pouvez pas accéder à cette page, veuillez vous connecter. </div>";
		$acces='none';
		
	} elseif ($_SESSION['type']=='admin') {
		//l'administrateur a accès à toutes les données personnelles et peut les modifier
		$acces='all';
	} else {

		// regarder si la personne connectée est la personne dont le profil est chargé 
		if ($pageDe==$_SESSION['login']) {
			// si oui : afficher les infos personnelles + possibilité de tout modifier. 
			$acces="mypage";
		} elseif (amis($pageDe,$_SESSION['login'])) {
			// affiche certaines données privées en plus 
			$acces="ami";
		} else {
			// seulement les informations publiques
			$acces='etranger';
		}
	}
}
?>

<body>

<!-- <h1 class="titre"> EISTI - BOOK </h1> -->
<div class="entete">
<img class="logo" src="EISTIB6.png">



<div class="section3">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <ul >
                   
                    <li class="menuli" >
                        <a class="nonlien" href="profil.php?perso=<?php echo $_SESSION['login']; ?>"> Mon profil </a>
                    </li>
                    <li class="menuli">
                        <a class="nonlien" href="publi.php"> Mon fil d'actualité </a>
                    </li>

		            <li class="menuli">
                        <a class="nonlien" href="amis.php"> Gérer mes amitiés amis </a>
                    </li>

		            <li class="menuli">
                        <a class="nonlien" href="messagerie.php"> Messagerie </a>
                    </li>

                    <li class="menuli">
                        <a class="nonlien" href="deco.php"> Me déconnecter </a>
                    </li>

                    <li  class="menuli">
                        <a class="nonlien" href="http://www.eisti.fr"> EISTI </a>
                    </li>
                    
                    <?php
                    if ($acces=="mypage") {
                    	echo "<li  class='menuli'> <a class='nonlien' href='edit_profil.php?perso=".$_SESSION['login']."'> Editer mon profil </a> </li>";
                    }
                    ?>

                </ul>
            </div>
        </div>
    </div>
</div>


</div>


<div class="deb"></div>




<?php

// on charge toutes les infos puis on sélectionne celles qu'il faut afficher
// if terminé tout en bas de la page
if ($acces<>"none") {
	$tableau=chargerInfos($pageDe);
	$infos=$tableau[0];
		
	$amis=chargerListeAmis($pageDe);



echo "  <h2 class='soustitre'>"; 
if ($acces=="mypage") {
	echo "Mon Profil ";
} else {
	echo "Profil de ".$infos['LOGIN'];
}

echo "</h2><div class='gauche'>";
	
// photo de profil
if (isset($infos['photo'])) {
	$src=$infos['photo'];
	echo "<p><img class='photoprofil' src='".$src."'></img></p>";
} else {
	echo "<p><img class='photoprofil' src='poulet.jpg'></img></p>";
}

// informations générales
echo "
	<h3> ".$infos['NOM']." </h3>
    	<h4> ".$infos['PRENOM']."</h4>
    	<h5> Promo ".$infos['PROMOTION']." </h5>";

if (!empty($infos['CITATION'])) {
	echo '"'.$infos['CITATION'].'"';
}


echo "</div>";

	
// liste d'amis 
echo "  <div class='droit'>";
if ($acces=="mypage") {
	echo "<h3>Ma liste d'amis</h3>";
} else {
	echo "<h3>Tous les amis de ".$infos['LOGIN']."</h3>";
}


if (!empty($amis)) {
	affichageAmisProfil($amis);
} else { 
	if ($acces=="mypage") {
		echo "Vous n'avez pas d'amis :( <br/> Vous pouvez retrouver des connaissances dans l'onglet 'gérer mes amis'";
	} else {
		echo "Cet utilisateur n'a pas d'amis enregistré.";
	} 
}
echo "</div>";
	

// validation ou erreur après modification du profil 
echo "<div>";
if (isset($_GET['valid'])) {
	if ($_GET['valid']) {
		echo "Vos modifications ont bien été enrgistrées.";
	} else {
		echo "Vos modifications n'ont pas pu être réalisées. Vous pouvez réessayer ou contacter nos services si le problème subsiste.";
	}
}	
echo "</div>";


	
// autres informations et publications	
echo "	<div class='milieu'>";

// introduction 
if (!empty($infos['INTRO'])) {
	echo "<div class='intro'>".$infos['INTRO']."</div>";
}


echo "<h3> Informations du profil </h3>";

echo "<div class='info'>".$infos['PRENOM']." est né le ".$infos['NAISSANCE'];

if (!empty($infos['PROFESSION'])) {
	echo "<div class='info'>".$infos['PRENOM']." est ".$infos['PROFESSION'];
	if (!empty($infos['EMPLOI'])) {
		echo "chez ".$infos['EMPLOI'];
	}
	echo "</div>";
}

if (!empty($infos['DIPLOME'])) {
	echo "<div class='info'>".$infos['PRENOM']." a obtenu le diplome suivant : ".$infos['DIPLOME']."</div>";
}

if (!empty($infos['VILLE'])) {
	echo "<div class='info'>".$infos['PRENOM']." habite à ".$infos['VILLE']."</div>";
}

if (!empty($infos['LOISIR'])) {
	echo "<div class='info'>Ses loisirs : ".$infos['LOISIR']."</div>";
}

echo "<br/><br/>";
// informations plus privées : 
if ($acces<>"etranger") {
	// caractère
	$caract=$tableau[1];
	if (!empty($caract)) {
		echo "<div class='info'><b>CARACTERE : </b>";
		foreach ($caract as $unit) {
			echo $unit.", ";
		}
		echo "</div>";	
	}
	
	// compétences 
	$comp=$tableau[2];
	if (!empty($comp)) {
		echo "<div class='info'><b>COMPETENCES : </b>";
		foreach ($comp as $unit) {
			echo $unit.", ";
		}
		echo "</div>";	
	}
	
	// langues parlées
	$langues=$tableau[3];
	if (!empty($langues)) {
		echo "<div class='info'><b>LANGUES PARLEES : </b>";
		foreach ($langues as $unit) {
			echo $unit.", ";
		}
		echo "</div>";	
	}
	
	// outils maitrisés
	$outils=$tableau[4];
	if (!empty($outils)) {
		echo "<div class='info'><b>OUTILS MAITRISES : </b>";
		foreach ($outils as $unit) {
			echo $unit.", ";
		}
		echo "</div>";	
	}
	
	
} 
	
echo "</div></div>";


	

//publications de ce profil 
echo "<div class='milieu'>";
if ($acces=="mypage") {
	echo "<h3> Mes publications récentes</h3>";
} else {
	echo "<h3> Publications récentes de ".$infos['LOGIN']." </h3>";
}

chargerPubli_profil($infos['PRENOM']." ".$infos['NOM']);


echo "</div>";

} 

?>
</body>
</html>