<?php
	require('util.php');
?>

<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title>EISTI - BOOK </title>
<!--          <link href="./base.css"
          rel="stylesheet" type="text/css">
          <link href="./fil.css"
          rel="stylesheet" type="text/css">
           <link href="./actualite.css"
          rel="stylesheet" type="text/css">
-->
	<script type="text/javascript" src="amis.js"></script>
</head>



<body>
<h1 class="titre"> Gerer mes amitiés </h1>

<div class="entete">
<img class="logo" src="EISTIB6.png">



<div class="section3">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <ul >
                   
                    <li class="menuli" >
                        <a class="nonlien" href="profil.php?perso=<?php echo $_SESSION['login']; ?>"> Mon profil </a>
                    </li>
                    <li class="menuli">
                        <a class="nonlien" href="publi.php"> Mon fil d'actualité </a>
                    </li>

		            <li class="menuli">
                        <a class="nonlien" href="amis.php"> Gérer mes amitiés</a>
                    </li>

		          
                    <li class="menuli">

                        <a class="nonlien" href="messagerie.php">Messagerie </a>
                    </li>
                    <li class="menuli">
                        <a class="nonlien" href="deco.php?action=logout">Me déconnecter</a>

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



<!-- boutton afficher ma liste d'amis -> en ajax   -->
<div> 
	<input type="button" value="Afficher ma liste d'amis" onclick="listeAmis(<?php echo $_SESSION['login']; ?>)">

</div>

<!-- barre de recherche et bouton valider (faire la requete en ajax) -->
<div>


</div>

<!--contient les résultats de la recherche ou de la liste d'amis -->
<div id='results'></div>

<!-- TODO
	. une partie affichage des amis actuels 
	. une partie rechercher un profil (par nom prenom ou login, avec dans l'idéal recherche par mot clefs partiels)
	. pour chaque personne un bouton pour l'ajouter à tes amis ou le supprimer de tes amis 
	. faire un fichier javascript avec les deux fonctions
 -->
</body>
</html>

