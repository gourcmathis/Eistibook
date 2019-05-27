<?php
	session_start();
	$perso=$_GET['perso'];
?>
<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title>EISTI - BOOK </title>
          <link href="./base.css"
          rel="stylesheet" type="text/css">
          <link href="./fil.css"
          rel="stylesheet" type="text/css">
           <link href="./actualite.css"
          rel="stylesheet" type="text/css">
</head>



<body>
<?php
	// cas de l'admin ? 
	
	
	// on vérifie que c'est la bonne personne qui est connectée 
	if ($perso==$_SESSION['login']) {
		?>
		<div><h1>Vous pouvez modifier votre mot de passe.</h1><br/>
                        <form class="form-horizontal" role="form" action="modif_mdp.php?perso=<?php echo $perso; ?>" method="POST">
                        <div class="col-sm-2">
                            <label for="password" class="control-label">Veuillez d'abord confirmer votre mot de passe actuel. </label>
                        </div>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="actuel" name="actuel" placeholder="ancien mot de passe" required="required" >
                        </div>
                        <div class="col-sm-2">
                            <label for="password" class="control-label">Puis entrez votre nouveau mot de passe. </label>
                        </div>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="nouveau" name="nouveau" placeholder="nouveau mot de passe" required="required" >
                        </div>
                        
                        <button type="submit" class="bouton">Valider ce mot de passe</button>
                </div>

	<?php	
	} 

?>



</body>
</html>
