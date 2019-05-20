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
Bienvenue <?php echo stripslashes(htmlentities(trim($_SESSION['login']))); ?> !<br /><br />
<?php
$db = connecterBDD();

// on prépare une requete SQL cherchant tous les titres, les dates ainsi que l'auteur des messages pour le membre connecté
$sql = 'SELECT titre, date, EISTI_BOOK_UTILISATEUR.login as expediteur, messages.id as id_message FROM messages, EISTI_BOOK_UTILISATEUR WHERE id_destinataire="'.$_SESSION['id'].'" AND id_expediteur=EISTI_BOOK_UTILISATEUR.ID_UTILISATEURS ORDER BY date DESC';
// lancement de la requete SQL
$req = mysqli_query($db, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error());
$nb = mysqli_num_rows($req);

if ($nb == 0) {
	echo 'Vous n\'avez aucun message.';
}
else {
	// si on a des messages, on affiche la date, un lien vers la page lire.php ainsi que le titre et l'auteur du message
	while ($data = mysqli_fetch_array($req)) {
	echo $data['date'] , ' - <a href="lire.php?id_message=' , $data['id_message'] , '">' , stripslashes(htmlentities(trim($data['titre']))) , '</a> [ Message de ' , stripslashes(htmlentities(trim($data['expediteur']))) , ' ]<br />';
	}
}
mysqli_free_result($req);
mysqli_close($db);
?>
<br /><a href="envoyer.php">Envoyer un message</a>
<br /><br /><a href="deco.php">Déconnexion</a>
</body>
</html>