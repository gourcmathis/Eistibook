<?php 
session_start();
?>

<!DOCTYPE html >
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title>EISTI - BOOK </title>
	<link href="./base.css"
          rel="stylesheet" type="text/css">
          <link href="./fil.css"
          rel="stylesheet" type="text/css">
           <link href="./profil.css"
          rel="stylesheet" type="text/css">
</head>
<script>
// ajax
function getXhr() {
	var xhr = null;
	if (window.XMLHttpRequest) {
		xhr = new XMLHttpRequest();
	} else if (window.ActiveXObject) { 
		try {
			xhr = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}
	} else { 
		alert("Votre navigateur ne supporte pas AJAX");
		xhr = false;
	}
	return xhr;
}


// récupère la liste d'amis du profil connecté 
function listeAmis() {
	var xhr = getXhr();
  	xhr.open("POST","listeAmis.php",true) ;
  	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=utf-8');
  	xhr.send(); 
  	xhr.onreadystatechange = function() {
     		// On ne fait quelque chose que si on a tout reçu
    		// et que le serveur est ok
     		if (xhr.readyState == 4 && xhr.status == 200){
     			document.getElementById("results").innerHTML= xhr.responseText;
     		}
  	}
  	
}

// effectue la recherche dans la base de données (les différents mots clefs sont considérés entre les espaces)
function recherche() {
	var xhr = getXhr();
  	xhr.open("POST","rechercher.php",true) ;
  	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=utf-8');
  	xhr.send( "motsClefs="+document.getElementById("motsClefs").value ); 
  	xhr.onreadystatechange = function() {
     		// On ne fait quelque chose que si on a tout reçu
    		// et que le serveur est ok
     		if (xhr.readyState == 4 && xhr.status == 200){
     			document.getElementById("results").innerHTML= xhr.responseText;
     		}
  	}	
}

// ajoute une amitié entre la personne connectée et la personne de login "nom"
function ajouterAmi(nom) {
	var xhr = getXhr();
  	xhr.open("POST","ajouterAmi.php",true) ;
  	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=utf-8');
  	xhr.send( "ami="+nom.id); 
  	xhr.onreadystatechange = function() {
     		// On ne fait quelque chose que si on a tout reçu
    		// et que le serveur est ok
     		if (xhr.readyState == 4 && xhr.status == 200){
     			if (  xhr.responseText == 1) {  alert("Vous avez un nouvel ami(e) :) !!!!"); }
          else {

          alert("Ceci n'a pas fonctionné");
          }
         
     		}
  	}
  	
}


// supprime une amitié
function supprimerAmi(login) {
	var xhr = getXhr();
  	xhr.open("POST","supprimerAmi.php",true) ;
  	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=utf-8');
  	xhr.send( "ami="+login.id); 
  	xhr.onreadystatechange = function() {
     		// On ne fait quelque chose que si on a tout reçu
    		// et que le serveur est ok
     		if (xhr.readyState == 4 && xhr.status == 200){
          if (  xhr.responseText == 1) {  alert("Vous avez perdu un ami(e) :'(  !!!!"); }
          else {

          alert("Ceci n'a pas fonctionné");
          }
     		}
  	}
}



</script>


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
                    <?php
                    
                      echo "<li  class='menuli'> <a class='nonlien' href='edit_profil.php?perso=".$_SESSION['login']."'> Editer mon profil </a> </li>";
                    
                    ?>

                </ul>
            </div>
        </div>
    </div>
</div>
</div>

<div class="deb"></div>

<!-- boutton afficher ma liste d'amis -->
<div> 
	<input class="buton" type="button" value="Afficher ma liste d'amis" onclick="listeAmis()">
</div>

<!-- barre de recherche et bouton valider -->
<div>
	<input type="text" value="" id="motsClefs" /><input class="buton" type="button" value="Rechercher" onclick="recherche()">

</div>

<!--contient les résultats de la recherche ou de la liste d'amis -->
<div id='results'></div>


</body>
</html>