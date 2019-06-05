<?php
require('util.php');

$db = connecterBDD();

	// si tout a été bien rempli, on insère le message dans notre table SQL
	$sql = 'UPDATE AMIS SET BLOQUE =1 WHERE ID_AMIS='.$_GET['iDexpediteur'].'';
	mysqli_query($db,$sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error());
	mysqli_close($db);
	

header('Location: messagerie.php');
exit();
?>