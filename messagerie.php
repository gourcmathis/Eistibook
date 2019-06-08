<?php
require('util.php');
if (!isset($_SESSION['login'])) {
    echo "<script>if (confirm('Vous ne pouvez pas accéder à cette page. Voulez-vous retourner à la page de connexion ? ')) { 
                document.location.replace('login.php'); }</script>";    
}	
// on vérifie toujours qu'il s'agit d'un membre qui est connecté
if (!isset($_SESSION['login'])) {
	// si ce n'est pas le cas, on le redirige vers l'accueil
	header ('Location: login.php');
	exit();
}
// on teste si le formulaire a bien été soumis
if (isset($_POST['go']) && $_POST['go'] == 'Envoyer') {
	if (empty($_POST['destinataire']) || empty($_POST['titre']) || empty($_POST['message'])) {
	$erreur = 'Au moins un des champs est vide.';
	}
	else {

	$db = connecterBDD();

	// si tout a été bien rempli, on insère le message dans notre table SQL
	$sql = 'INSERT INTO messages VALUES("", "'.$_SESSION['id'].'", "'.$_POST['destinataire'].'", "'.date("Y-m-d H:i:s").'", "'.mysqli_escape_string($db,$_POST['titre']).'", "'.mysqli_escape_string($db,$_POST['message']).'","","")';
	mysqli_query($db,$sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error());

	mysqli_close($db);

	header('Location: messagerie.php');
	exit();
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
          <link rel="icon" href="EISTIB7.ico" />
</head>


<?php 


	$pageDe=$_SESSION['login'];
	$acces="mypage";
	
	
?>

<body>
<div class="entete">
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

	$tableau=chargerInfos($pageDe);
	$infos=$tableau[0];
		
	$amis=chargerListeAmis($pageDe);



echo "  <h2 class='soustitre'>"; 
echo "Messagerie ";


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
	

echo "<div class='milieu'>";
?>
<h4>Envoyer un message :</h4>

<?php
$db= connecterBDD();
// on prépare une requete SQL selectionnant tous les login des membres du site en prenant soin de ne pas selectionner notre propre login, le tout, servant à alimenter le menu déroulant spécifiant le destinataire du message
$sql = 'SELECT *, concat(EISTI_BOOK_UTILISATEUR.NOM," ",EISTI_BOOK_UTILISATEUR.PRENOM) as nom_destinataire, EISTI_BOOK_UTILISATEUR.ID_UTILISATEURS as id_destinataire FROM AMIS, EISTI_BOOK_UTILISATEUR WHERE AMIS.ID_UTILISATEURS="'.$_SESSION['id'].'"  AND ID_AMIS=EISTI_BOOK_UTILISATEUR.ID_UTILISATEURS AND EISTI_BOOK_UTILISATEUR.ID_UTILISATEURS <> "'.$_SESSION['id'].'" ORDER BY login ASC';
// on lance notre requete SQL
$req = mysqli_query($db, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error());
$nb = mysqli_num_rows ($req);

if ($nb == 0) {
	// si aucun membre n'a été trouvé, on affiche tout simplement aucun formulaire
	echo "Vous êtes le seul membre inscrit ou vous n'avez pas encore d'amis.";
}
else {
	// si au moins un membre qui n'est pas nous même a été trouvé, on affiche le formulaire d'envoie de message
	?>
	<form action="messagerie.php" method="post">
	Pour : <select name="destinataire">
	<?php
	// on alimente le menu déroulant avec les login des différents membres du site
	while ($data = mysqli_fetch_array($req)) {
	echo '<option value="' , $data['id_destinataire'] , '">' , stripslashes(htmlentities(trim($data['nom_destinataire']))) , '</option>';
	}
	?>
	</select><br />
	Titre : <input type="text" name="titre" value="<?php if (isset($_POST['titre'])) echo stripslashes(htmlentities(trim($_POST['titre']))); ?>"><br />
	Message : <textarea name="message"><?php if (isset($_POST['message'])) echo stripslashes(htmlentities(trim($_POST['message']))); ?></textarea><br />
	<input type="submit" class="bouton" name="go" value="Envoyer">
	</form>
	<?php
}
mysqli_free_result($req);
mysqli_close($db);

echo"</select>";



// si une erreur est survenue lors de la soumission du formulaire, on l'affiche
if (isset($erreur)) echo '<br /><br />',$erreur;

echo "</div>";




// autres informations et publications	
echo "<br/><div class='milieu'>";
echo "<h4>Messages reçus</h4>";

$db = connecterBDD();

// on prépare une requete SQL cherchant tous les titres, les dates ainsi que l'auteur des messages pour le membre connecté
$sql = 'SELECT *, titre, date, concat(EISTI_BOOK_UTILISATEUR.NOM," ",EISTI_BOOK_UTILISATEUR.PRENOM) as expediteur, messages.id as id_message, id_destinataire FROM AMIS, messages, EISTI_BOOK_UTILISATEUR WHERE AMIS.ID_UTILISATEURS=id_destinataire AND ID_AMIS=id_expediteur AND BLOQUE=0 AND id_destinataire="'.$_SESSION['id'].'" AND id_expediteur=EISTI_BOOK_UTILISATEUR.ID_UTILISATEURS ORDER BY date DESC';
// lancement de la requete SQL
$req = mysqli_query($db, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error());
$nb = mysqli_num_rows($req);

if ($nb == 0) {
	echo 'Vous n\'avez aucun message.';
}
else {
	// si on a des messages, on affiche la date, un lien vers la page lire.php ainsi que le titre et l'auteur du message
	while ($data = mysqli_fetch_array($req)) {
	echo $data['date'] , ' - <a class="messa" href="lire.php?id_message=' , $data['id_message'] ,'&iDdestinataire=',$data['id_destinataire'],'&iDexpediteur=',$data['id_expediteur'], '">' , stripslashes(htmlentities(trim($data['titre']))) , '</a> [ Message de ' , stripslashes(htmlentities(trim($data['expediteur']))) , ' ]<br />';
	}
}
mysqli_free_result($req);
mysqli_close($db);


?>
<!-- TODO 
	. ajouter les publications récentes de cette personne
	. mettre en forme les différentes infos
	. fonction d'édition (nouvelle page similaire)
	. mettre des liens sur les amis vers leur profil (dans afficher_amis, util.php)
	
-->
</body>
</html>