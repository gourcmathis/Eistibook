<?php
require('util.php');
// on teste si le formulaire a été validé
if (isset($_POST['go']) && $_POST['go']=='Poster la publi') {
	// on se connecte à notre base
	$db=connecterBDD();

	// on teste la déclaration de nos variables
	if ( !isset($_POST['publi'])) {
	$erreur = 'Les variables nécessaires au script ne sont pas définies.';
	}
	else {
	if ( empty($_POST['publi'])) {
		$erreur = 'Au moins un des champs est vide.';
	}
	// si tout est bon, on peut commencer l'insertion dans la base
	else {
		// lancement de la requête d'insertion
		$sql = 'INSERT INTO publi VALUES("", "'.$_SESSION['login'].'", "'.date("Y-m-d H:i:s").'", "'.mysqli_escape_string($db,$_POST['publi']).'")';

		// on lance la requête (mysqli_query) et on impose un message d'erreur si la requête ne se passe pas bien (or die)
		mysqli_query($db,$sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error());

		// on ferme la connexion à la base de données
		mysqli_close();

		// on redirige vers la page d'accueil du site (attention, cette redirection ne fonctionne qui si vous avez placé cette page dans un répertoire à partir de la racine du site). Si ce n'est pas le cas, veuillez entrer ici le bon chemin d'accès afin de retomber sur la page d'accueil du site.
		header('Location: ./publi.php');
		// on termine le script courant
		exit();
	}
	}
}
?>
<html>
<head>
<title>Insertion d'une nouvelle publi</title>
</head>

<body>

<!-- on fait pointer le formulaire vers la page traitant les données -->
<form action="insert_publi.php" method="post">
<table>
<tr><td>
<textarea name="publi" cols="50" rows="10"><?php if (isset($_POST['publi'])) echo htmlentities(trim($_POST['publi'])); ?></textarea>
</td></tr><tr><td><td align="right">
<input type="submit" name="go" value="Poster la publi">
</td></tr></table>
</form>
<?php
// on affiche les erreurs éventuelles
if (isset($erreur)) echo '<br /><br />',$erreur;
?>
</body>
</html>