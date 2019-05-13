<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title>Site</title>
    
</head>
<body>

<?php
require("util.php");

//Lors de la soumission des données du formulaire, insérer le nouvel abonné
if (isset($_POST['nom']) && isset($_POST['prenom'])) {
$tab=array('nom' => $_POST['nom'],'prenom'  => $_POST['tel'],'email' => $_POST['email'],'password' => $_POST['password']);
    insertEleve($tab);
}


?>

<div class="section">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills">
                    <li class="active">
                        <a href="inscription.php">Inscription</a>
                    </li>
                    <li>
                        <a href="login.php">Me Connecter</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Inscription</h1>
            </div>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" role="form" action="inscription.php" method="POST">
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="nom" class="control-label">Nom</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="prenom" class="control-label">Prénom</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="email" class="control-label">Email</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="password" class="control-label">Mot de passe</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Créer mon compte</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
