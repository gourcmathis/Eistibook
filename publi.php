<?php
require('util.php');
if (!isset($_SESSION['login'])) {
    echo "<script>if (confirm('Vous ne pouvez pas accéder à cette page. Voulez-vous retourner à la page de connexion ? ')) { 
                document.location.replace('login.php'); }</script>";    
}
$pageDe=$_SESSION['login'];
    $acces="mypage";
$tableau=chargerInfos($pageDe);
    $infos=$tableau[0];
        
    $amis=chargerListeAmis($pageDe);

// on teste si le formulaire a été validé
if (isset($_POST['go']) && $_POST['go']=='Poster') {
	// on se connecte à notre base
	$db=connecterBDD();

	// on teste la déclaration de nos variables
	if ( !isset($_POST['publi'])) {
	$erreur = 'Les variables nécessaires au script ne sont pas définies.';
	}
	else {
	if ( empty($_POST['publi'])) {
		$erreur = 'Le champ est vide.';
	}
	// si tout est bon, on peut commencer l'insertion dans la base
	else {
		// lancement de la requête d'insertion
		$sql = 'INSERT INTO publication VALUES("", "'.$infos['PRENOM']." ".$infos['NOM'].'", "'.date("Y-m-d H:i:s").'", "'.mysqli_escape_string($db,$_POST['publi']).'")';

		// on lance la requête (mysqli_query) et on impose un message d'erreur si la requête ne se passe pas bien (or die)
		mysqli_query($db,$sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error());

		// on ferme la connexion à la base de données
		mysqli_close($db);

		// on redirige vers la page d'accueil du site (attention, cette redirection ne fonctionne que si vous avez placé cette page dans un répertoire à partir de la racine du site). Si ce n'est pas le cas, veuillez entrer ici le bon chemin d'accès afin de retomber sur la page d'accueil du site.
		header('Location: ./publi.php');
		// on termine le script courant
		exit();
	}
	}
}
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
           <link href="./actualite.css"
          rel="stylesheet" type="text/css">
          <link rel="icon" href="EISTIB7.ico" />
</head>



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
                        <a class="nonlien" href="amis.php"> Gérer mes amitiés</a>
                    </li>

                    <li class="menuli">
                        <a class="nonlien" href="messagerie.php"> Messagerie </a>
                    </li>                                      
                    
                    <li  class='menuli'> <a class='nonlien' href='edit_profil.php?perso=<?php echo $_SESSION['login'];?>'> Editer mon profil </a> </li>
                    <li  class="menuli">
                        <a class="nonlien" href="http://www.eisti.fr"> EISTI </a>
                    </li>

                    <li class="menuli">
                        <a class="nonlien" href="deco.php"> Me déconnecter </a>
                    </li>

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

    



echo "  <h2 class='soustitre'>"; 
echo "Publications ";


echo "</h2><div class='gauche'>";
    
// photo de profil
if (isset($infos['PHOTO'])) {
    $src=$infos['PHOTO'];
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
        echo "Vous n'avez pas d'amis :( <br/> Vous pouvez retrouver des connaissances dans l'onglet 'gérer mes amitiés'";
    } else {
        echo "Cet utilisateur n'a pas d'ami enregistré.";
    } 
}
echo "</div>";
?>
<div class="milieu">
<h3> Mes actualités </h3>
<p> 

<form action="publi.php" method="post" class="formpubl">

<textarea name="publi" cols="50" rows="10" placeholder="Exprimez vous !"><?php if (isset($_POST['publi'])) echo htmlentities(trim($_POST['publi'])); ?></textarea>

<input type="submit" name="go" class="menuli" class="nonlien" value="Poster">

</form>
<?php
// on affiche les erreurs éventuelles
if (isset($erreur)) echo '<br /><br />',$erreur;
?>








<?php

// on se connecte à notre base
$db=connecterBDD();

// lancement de la requête. on sélectionne les publi que l'on va ordonner suivant l'ordre "inverse" des dates (de la plus récente à la plus vieille : DESC) tout en ne sélectionnant que le nombre voulu de publi à afficher (LIMIT)
$sql = 'SELECT auteur, date, texte FROM publication ORDER BY date DESC;';

// on lance la requête (mysql_query) et on impose un message d'erreur si la requête ne se passe pas bien (or die)
$req = mysqli_query($db, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error());

// on compte le nombre de publi stockées dans la base de données
$nb_publi = mysqli_num_rows($req);

$presence_de_publi=false;

if ($nb_publi != 0) {
    // si on a au moins une publi, on l'affiche
    while ($data = mysqli_fetch_array($req)) {
		$nom=explode(" ",$data['auteur']);
		$sql2="SELECT LOGIN FROM EISTI_BOOK_UTILISATEUR WHERE NOM='".$nom[1]."' AND PRENOM='".$nom[0]."'";
		$req2 = mysqli_query($db, $sql2) or die('Erreur SQL !<br />'.$sql2.'<br />'.mysqli_error());
		// si il n'y a aucun résultat, peut-être que la personne a été supprimée de la base de données 
		if (mysqli_num_rows($req2)!=0) {
			$res=mysqli_fetch_assoc($req2);
			
			//on n'affiche que les publications de ses amis
			if (amis($res['LOGIN'],$_SESSION['login']) | $res['LOGIN']==$_SESSION['login']) {
			
				$presence_de_publi=true;
			
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
    }
}
if (!$presence_de_publi) {
	echo 'Aucune publication enregistrée.';
}
// on libère l'espace mémoire alloué aux requêtes
mysqli_free_result ($req);
mysqli_free_result ($req2);

// on ferme la connexion à la base de données
mysqli_close ($db);
?>


</p>
</div>

</body>
</html>