<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title>EISTI - BOOK </title>
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css"
          rel="stylesheet" type="text/css">
    <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css"
          rel="stylesheet" type="text/css"> -->
           <link href="./inscription.css"
          rel="stylesheet" type="text/css">
</head>

<body>
<h1 class="titre"> EISTI - BOOK </h1>


<h2 class="soustitre"> Formulaire d'inscription </h2>
<div class="section2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" role="form" action="login.php" method="POST">
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="email" class="control-label">Nom</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Dupont">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="password" class="control-label">Prénom</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Jean">
                        </div>
                    </div>

                     <div class="form-group">
                        <div class="col-sm-2">
                            <label for="password" class="control-label">Âge</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password" placeholder="02/07/1998">
                        </div>
                    </div>

                     <div class="form-group">
                        <div class="col-sm-2">
                            <label for="password" class="control-label">Adresse email </label>
                        </div>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password" placeholder="bernedohug@eisti.eu">
                        </div>
                    </div>

                     <div class="form-group">
                        <div class="col-sm-2">
                            <label for="password" class="control-label">Année de promotion</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password" placeholder="2022">
                        </div>
                    </div>

                     <div class="form-group">
                        <div class="col-sm-2">
                            <label for="password" class="control-label">Mot de passe </label>
                        </div>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password" placeholder="coucoujesuislemotdepasse">
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
                    <li class="menuli">
                        <a class="nonlien" href="login.php">Me Connecter</a>
                    </li>

                    <li class="menuli">
                        <a class="nonlien" href="login.php?action=logout">Me déconnecter</a>
                    </li>

                    <li  class="menuli">
                        <a class="nonlien" href="http://www.eisti.fr">EISTI
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>


</body>
</html>
