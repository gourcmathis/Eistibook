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
           <link href="./editprof.css"
          rel="stylesheet" type="text/css">
</head>



<body>

<div class="entete">
<img class="logo" src="EISTIB6.png">



<div class="section3">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <ul >
                   
                    <li class="menuli" >
                        <a class="nonlien" href="edit_profil.php?perso=<?php echo $_SESSION['login']; ?>"> Retour sur editer mon profil </a>
                    </li>
                    <li class="menuli">
                        <a class="nonlien" href="publi.php"> Mon fil d'actualité </a>
                    </li>

                <li class="menuli">
                        <a class="nonlien" href="amis.php"> Gérer mes amitiés </a>
                    </li>

                <li class="menuli">
                        <a class="nonlien" href="messagerie.php"> Messagerie </a>
                    </li>

                    <li class="menuli">
                        <a class="nonlien" href="deco.php"> Me déconnecter </a>
                    </li>

                    <li  class="menuli">
                        <a class="nonlien" href="http://www.eisti.fr"> EISTI </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>

</div>

<div class="deb"></div>

<h2 class="soustitre"> Changement de mot de passe </h2>
<?php
	// cas de l'admin ? 
	
	
	// on vérifie que c'est la bonne personne qui est connectée 
	if ($perso==$_SESSION['login']) {
		?>
		<div>
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
