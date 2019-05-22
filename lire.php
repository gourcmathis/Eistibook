<?php
require('util.php');
// on vérifie toujours qu'il s'agit d'un membre qui est connecté
if (!isset($_SESSION['login'])) {
	// si ce n'est pas le cas, on le redirige vers l'accueil
	header ('Location: login.php');
	exit();
}
?>

<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title>EISTI - BOOK </title>

    <link href="./base.css"
          rel="stylesheet" type="text/css">
           <link href="./login.css"
          rel="stylesheet" type="text/css">
</head>

<body>
<a href="profil.php">Home</a></br></br>
<a href="messagerie.php">Retour</a><br /><br />
<?php
// on teste si notre paramètre existe bien et qu'il n'est pas vide
if (!isset($_GET['id_message']) || empty($_GET['id_message'])) {
	echo 'Aucun message reconnu.';
}
else {
	$db = connecterBDD();

	// on prépare une requete SQL selectionnant la date, le titre et l'expediteur du message que l'on souhaite lire, tout en prenant soin de vérifier que le message appartient bien au membre connecté
	$sql = 'SELECT titre, date, message, concat(EISTI_BOOK_UTILISATEUR.NOM," ",EISTI_BOOK_UTILISATEUR.PRENOM) as expediteur FROM messages, EISTI_BOOK_UTILISATEUR WHERE id_destinataire="'.$_SESSION['id'].'" AND id_expediteur=EISTI_BOOK_UTILISATEUR.ID_UTILISATEURS AND messages.id="'.$_GET['id_message'].'"';
	// on lance cette requete SQL à MySQL
	$req = mysqli_query($db, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error());
	$nb = mysqli_num_rows($req);

	if ($nb == 0) {
	echo 'Aucun message reconnu.';
	}
	else {
	// si le message a été trouvé, on l'affiche
	$data = mysqli_fetch_array($req);
	echo $data['date'] , ' - ' , stripslashes(htmlentities(trim($data['titre']))) , '</a> [ Message de ' , stripslashes(htmlentities(trim($data['expediteur']))) , ' ]<br /><br />';
	echo nl2br(stripslashes(htmlentities(trim($data['message']))));

	// on affiche également un lien permettant de supprimer ce message de la boite de réception
	echo '<br /><br /><a href="supprimer.php?id_message=' , $_GET['id_message'] , '">Supprimer ce message</a>';
	}
	mysqli_free_result($req);
	mysqli_close($db);
}
?>
<br /><br /><a href="deco.php">Déconnexion</a>
</body>
</html>