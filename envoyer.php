<?php
require('util.php');
// on vérifie toujours qu'il s'agit d'un membre qui est connecté
if (!isset($_SESSION['login'])) {
	// si ce n'est pas le cas, on le redirige vers l'accueil
	header ('Location: index.php');
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
	$sql = 'INSERT INTO messages VALUES("", "'.$_SESSION['id'].'", "'.$_POST['destinataire'].'", "'.date("Y-m-d H:i:s").'", "'.mysqli_escape_string($db,$_POST['titre']).'", "'.mysqli_escape_string($db,$_POST['message']).'")';
	mysqli_query($db,$sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error());

	mysqli_close($db);

	header('Location: messagerie.php');
	exit();
	}
}
?>

<html>
<head>
<title>EISTI - BOOK</title>
</head>

<body>
<a href="messagerie.php">Retour à l'accueil</a><br /><br />
Envoyer un message :<br /><br />

<?php
$db= connecterBDD();
// on prépare une requete SQL selectionnant tous les login des membres du site en prenant soin de ne pas selectionner notre propre login, le tout, servant à alimenter le menu déroulant spécifiant le destinataire du message
$sql = 'SELECT EISTI_BOOK_UTILISATEUR.login as nom_destinataire, EISTI_BOOK_UTILISATEUR.ID_UTILISATEURS as id_destinataire FROM EISTI_BOOK_UTILISATEUR WHERE ID_UTILISATEURS <> "'.$_SESSION['id'].'" ORDER BY login ASC';
// on lance notre requete SQL
$req = mysqli_query($db, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error());
$nb = mysqli_num_rows ($req);

if ($nb == 0) {
	// si aucun membre n'a été trouvé, on affiche tout simplement aucun formulaire
	echo 'Vous êtes le seul membre inscrit.';
}
else {
	// si au moins un membre qui n'est pas nous même a été trouvé, on affiche le formulaire d'envoie de message
	?>
	<form action="envoyer.php" method="post">
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
	<input type="submit" name="go" value="Envoyer">
	</form>
	<?php
}
mysqli_free_result($req);
mysqli_close($db);
?>
</select>

<br /><br /><a href="deco.php">Déconnexion</a>
<?php
// si une erreur est survenue lors de la soumission du formulaire, on l'affiche
if (isset($erreur)) echo '<br /><br />',$erreur;
?>
</body>
</html>