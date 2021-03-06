<!-- atention, si on ouvre on page de profil, il faut toujours en get la personne dont on regarde le profil -->
<?php
require('util.php');
// on vérifie toujours qu'il s'agit d'un membre qui est connecté
if (!isset($_SESSION['login'])) {
	// si ce n'est pas le cas, on le redirige vers l'accueil
	header ('Location: login.php');
	exit();
}
// on teste si le formulaire a bien été soumis
if (isset($_GET['go']) && $_GET['go'] == 'Envoyer') {
	if ( empty($_GET['motif']) ) {
	$erreur = 'Veuillez rentrer un motif';
	}
	else {


	$db = connecterBDD();

	// si tout a été bien rempli, on insère le message dans notre table SQL
	$sql = 'UPDATE messages SET signalement_motif ="'.mysqli_escape_string($db,$_GET['motif']).'", signalement_msg = "'.mysqli_escape_string($db,$_GET['message']).'" WHERE id='.$_GET['id_message'].'';
	
	mysqli_query($db,$sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error());
	mysqli_close($db);
	echo "<script>alert(\"Merci de nous avoir prévenu, nous nous en occupons.\")</script>";
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
           <link href="./profil.css"
          rel="stylesheet" type="text/css">
           <link href="./messagerie.css"
          rel="stylesheet" type="text/css">
</head>


<?php 


	$pageDe=$_SESSION['login'];
	$acces="mypage";
	
	
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
                        <a class="nonlien" href="amis.php"> Gérer mes amitiés</a>
                    </li>

		            <li class="menuli">
                        <a class="nonlien" href="messagerie.php"> Messagerie </a>
                    </li>                                      
                    
                    <li  class='menuli'> <a class='nonlien' href='edit_profil.php?perso=".$_SESSION['login']."'> Editer mon profil </a> </li>
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

	$tableau=chargerInfos($pageDe);
	$infos=$tableau[0];
		
	$amis=chargerListeAmis($pageDe);



echo "  <h2 class='soustitre'>"; 
echo "Messagerie ";


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
	



// autres informations et publications	
echo "<div class='milieu'>";
echo "<h4>Signaler le message</h4>";


	// si au moins un membre qui n'est pas nous même a été trouvé, on affiche le formulaire d'envoie de message
	?>
	<form action="signaler.php" method="get">
	<?php

	echo '<input type="hidden" name="id_message" value="'.$_GET['id_message'].'">'
	?>
	<br />
	Motif : <input type="text" name="motif" value="<?php if (isset($_GET['motif'])) echo stripslashes(htmlentities(trim($_GET['motif']))); ?>"><br />
	Message : <textarea name="message"><?php if (isset($_GET['message'])) echo stripslashes(htmlentities(trim($_GET['message']))); ?></textarea><br />
	<input type="submit" class="bouton" name="go" value="Envoyer">
	</form>
	<?php



echo"</select>";



// si une erreur est survenue lors de la soumission du formulaire, on l'affiche
if (isset($erreur)) echo '<br /><br />',$erreur;

echo "</div>";

?>

<!-- TODO 
	. ajouter les publications récentes de cette personne
	. mettre en forme les différentes infos
	. fonction d'édition (nouvelle page similaire)
	. mettre des liens sur les amis vers leur profil (dans afficher_amis, util.php)
	
-->
</body>
</html>