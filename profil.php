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



<body>
<!-- <h1 class="titre"> EISTI - BOOK </h1> -->
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

                        <a class="nonlien" href="messagerie.php">Messagerie </a>
                    </li>
                    <li class="menuli">
                        <a class="nonlien" href="deco.php?action=logout">Me déconnecter</a>

                    </li>

                    <li  class="menuli">
                        <a class="nonlien" href="http://www.eisti.fr"> EISTI </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>










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
			// seulement els informations publiques
			$acces='etranger';
		}
	}
}
// charger les infos de la page de profil + en fonction de acces différentes fonctionnalités

// on charge toutes les infos puis on sélectionne celles qu'il faut afficher
if ($acces<>"none") {
	$tableau=chargerInfos($pageDe);
	$infos=$tableau[0];

	print_r($tableau[1]);
	echo "<br/>";
	
	print_r($tableau[2]);
	echo "<br/>";
	
	print_r($tableau[3]);
	echo "<br/>";
	
	$amis=chargerListeAmis($pageDe);
	print_r($amis);


echo "  <h2 class='soustitre'>    Mon Profil </h2>
	<div class='gauche'>";
	
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
    	<h5> Promo ".$infos['PROMOTION']." </h5>
    	<h5> ".$infos['NAISSANCE']." </h5>
	</div>";

	
// liste d'amis 
echo "  <div class='droit'><h3>Liste d'amis</h3>";
affichageAmisProfil($amis);
echo "	</div>";
	
	
// autres informations et publications	
echo "	<div class='milieu'>
	<h3> Informations du profil </h3>

	<h3> Publications par ce profil </h3>
	<p> 
	 ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	</p>
	</div>
	<?php 
	";
} 
?>

</body>
</html>
