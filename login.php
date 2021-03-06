<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title>EISTI - BOOK </title>

   
           <!-- <link href="./login.css"
          rel="stylesheet" type="text/css"> -->
           <link href="./inscription.css"
          rel="stylesheet" type="text/css">
          <link rel="icon" href="EISTIB7.ico" />
</head>

<body>
<img class="logo" src="./EISTIB6.png">

<h2 class="soustitre"> Formulaire de connexion </h2>
<!-- <h1 class="titre"> EISTI - BOOK </h1> -->

<?php
require("util.php");

//on regarde si un formulaire a déjà été envoyé. si oui ne teste la connection avec les identifiants donnés
if (!empty($_POST)){
	tryLogin($_POST);
}
?>


<div class="section2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" role="form" action="login.php" method="POST">
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="email" class="control-label"> Identifiant</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" placeholder="nom@eisti.eu">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="password" class="control-label"> Mot de passe </label>
                        </div>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="bouton">Me Connecter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>





<div class="section3">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <ul >
                   
                    <li class="menuli" >
                        <a class="nonlien" href="inscription.php">Inscription</a>
                    </li>

                    <li  class="menuli">
                        <a class="nonlien" href="http://www.eisti.fr">EISTI </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>

<?php

//redirection vers la page correspondante si bien identifié
if (!empty($_SESSION)) {
	// si l'utilisateur a été identifié
	// on regarde quel type d'utilisateur c'est 
	if ($_SESSION['type']=='admin') {
		//ouvrir une des pages admin
		echo "<script>document.location.replace('admin.php');</script>";
	} else {
		// ouvrir la page profil
		$perso=$_SESSION['login'];
        $db=connecterBDD();

    $sql = 'SELECT ID_UTILISATEURS FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN="'.mysqli_escape_string($db,$_POST['email']).'" AND MDP="'.(md5(mysqli_escape_string($db,$_POST['password']))).'"';
    $req = mysqli_query($db, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error());
    $data = mysqli_fetch_array($req);
    
    $_SESSION['id'] = $data['ID_UTILISATEURS'];
		echo "<script>document.location.replace('profil.php?perso=".$perso."')</script>";
	}
}
?>

</body>
</html>
