<?php
require('util.php');
// on vérifie toujours qu'il s'agit d'un membre qui est connecté

if (!isset($_SESSION['login'])) {
	// si ce n'est pas le cas, on le redirige vers l'accueil
	header ('Location: index.php');
	exit();
}

// on teste si l'id du message a bien été fourni en argument au script envoyer.php
if (!isset($_GET['id_message']) || empty($_GET['id_message'])) {
	header ('Location: messagerie.php');
	exit();
}
else {
	$db= connecterBDD();

	// on prépare une requête SQL permettant de supprimer le message tout en vérifiant qu'il appartient bien au membre qui essaye de le supprimer
	$sql = 'DELETE FROM messages WHERE id_destinataire="'.$_SESSION['id'].'" AND id="'.$_GET['id_message'].'"';
	// on lance cette requête SQL
	$req = mysqli_query($db, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error());

	mysqli_close($db);

	header ('Location: messagerie.php');
	exit();
}
?>