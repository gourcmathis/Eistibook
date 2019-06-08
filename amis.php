<?php 
require('util.php');
if (!isset($_SESSION['login'])) {
    echo "<script>if (confirm('Vous ne pouvez pas accéder à cette page. Voulez-vous retourner à la page de connexion ? ')) { 
                document.location.replace('login.php'); }</script>";    
}
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
           <link href="./amis.css"
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
     			if (  xhr.responseText == 1) {  alert("Vous avez un(e) nouvel(le) ami(e) :) !!!!"); }
          else {

          alert("Vous ne pouvez pas demander cet utilisateur en ami \n (peut-être l'avez vous déjà fait ? Regardez dans vos demandes en cours à droite de l'écran)");
          }
         
     		}
  	}
  	
}


// supprime une amitié
function supprimerAmi(login,n) {
	var xhr = getXhr();
  	xhr.open("POST","supprimerAmi.php",true) ;
  	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=utf-8');
  	xhr.send( "ami="+login.id+"&sens="+n); 
  	xhr.onreadystatechange = function() {
     		// On ne fait quelque chose que si on a tout reçu
    		// et que le serveur est ok
     		if (xhr.readyState == 4 && xhr.status == 200){
          if (  xhr.responseText == 1) {  alert("Vous avez perdu un(e) ami(e) :'(  !!!!"); }
          else {
          alert("Ceci n'a pas fonctionné"+xhr.responseText);
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
                        <a class="nonlien" href="messagerie.php"> Messagerie </a>
                    </li>                                      
                    
                    
                  
                    <li  class='menuli'> <a class='nonlien' href='edit_profil.php?perso=<?php echo $_SESSION['login'];?>'> Editer mon profil </a> </li>
                    
                    <li  class="menuli">
                        <a class="nonlien" href="http://www.eisti.fr"> EISTI </a>
                    </li>

                    <li class="menuli">
                        <a class="nonlien" href="deco.php"> Me déconnecter </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>
</div>

<div class="deb"></div>

<!-- boutton afficher ma liste d'amis -->
<div class="recherche">
<h2 class="soustitre">Page de gestion des amitiés</h2>
<div> 
	<input class="menuli2" type="button" value="Afficher ma liste d'amis" onclick="listeAmis()">
</div>

<!-- barre de recherche et bouton valider -->
<div>
	<span>Effectuer une recherche d'amis    </span>	<input type="text" placeholder="Effectuer une recherche"  value="" id="motsClefs" class="rech" /><input class="menuli" type="button" value="Rechercher" onclick="recherche()">

</div>
</div>

<!--contient les résultats de la recherche ou de la liste d'amis -->
<div id='results' class='milieu'></div>

<!-- demandes d'amis en cours -->



<div class='gauche2'> 
	
	<?php 
	$db = connecterBDD();
	// selectionne tous les gens avec qui on est amis 
	$query1="SELECT LOGIN,PHOTO,NOM,PRENOM FROM EISTI_BOOK_UTILISATEUR WHERE ID_UTILISATEURS IN (SELECT ID_AMIS FROM AMIS WHERE ID_UTILISATEURS=(SELECT ID_UTILISATEURS FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='".$_SESSION['login']."'))";
	$res1 = mysqli_query($db, $query1) or die('Request error : '.$query1);
	if (mysqli_num_rows($res1)>0) {
		$i=0;
		while ($row = mysqli_fetch_assoc($res1)) {
			$envoyes[$i]=$row;
			$i++;
		}
	} else {
		$envoyes=array();
	}
	
	//selectionne tous les gens qui sont amis avec nous 
	$query2="SELECT LOGIN,PHOTO,NOM,PRENOM FROM EISTI_BOOK_UTILISATEUR WHERE ID_UTILISATEURS IN (SELECT ID_UTILISATEURS FROM AMIS WHERE ID_AMIS=(SELECT ID_UTILISATEURS FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='".$_SESSION['login']."'))";
	$res2 = mysqli_query($db, $query2) or die('Request error : '.$query2);
	
	if (mysqli_num_rows($res2)>0) {
		$i=0;
		while ($row = mysqli_fetch_assoc($res2)) {
			$recus[$i]=$row;
			$i++;
		}
	} else {
		$recus=array();
	}

	
	
	
	
	
	
	$n=count($envoyes);
	if ($n!=0) {
		for ($i=0;$i<$n;$i++) {
			$el=$envoyes[$i];
			if (in_array($envoyes[$i],$recus)) {
				unset($envoyes[$i]);
				$j=array_search($el,$recus);
				unset($recus[$j]);
			}
		}
	} 
	deconnecterBDD($db);


	
	?>
	<h2>Mes demandes d'amis envoyées en attente </h2>
	<?php 
		if (!empty($envoyes)) {
			foreach ($envoyes as $resultat) {
				echo "<div class='prof'>";
				echo "<a href='profil.php?perso=".$resultat['LOGIN']."'>";
				if (!empty($resultat['PHOTO'])) {
					$src=$resultat['PHOTO'];
					echo "<p><img class='photoprofil' src='".$src."'></img></p>";
				} else {
					echo "<p><img class='photoprofil' src='poulet.jpg'></img></p>";
				}
				echo "<h4> ".$resultat['NOM']." ".$resultat['PRENOM']." ".$resultat['LOGIN']." </h4></a>";
				echo "<input class='buton' type='button' value='annuler la demande' id='".$resultat['LOGIN']."' onclick='supprimerAmi(this,0)' /> </div>";
			}
		}  else {
			echo "aucune";
		}
	?>
	
	<h2>Mes demandes d'amis reçues</h2>
	<?php 
		if (!empty($recus)) {
			foreach ($recus as $resultat) {
				echo "<div class='prof'>";
				echo "<a href='profil.php?perso=".$resultat['LOGIN']."'>";
				if (!empty($resultat['PHOTO'])) {
					$src=$resultat['PHOTO'];
					echo "<p><img class='photoprofil' src='".$src."'></img></p>";
				} else {
					echo "<p><img class='photoprofil' src='poulet.jpg'></img></p>";
				}
				echo "<h4> ".$resultat['NOM']." ".$resultat['PRENOM']." ".$resultat['LOGIN']." </h4></a>";
				echo "<input class='buton' type='button' value='refuser' id='".$resultat['LOGIN']."' onclick='supprimerAmi(this,1)' />";
				echo "<input class='buton' type='button' value='accepter'  id='".$resultat['LOGIN']."' onclick='ajouterAmi(this)' /></div>";
			}
		} else {
			echo "aucune";
		}
	?>
	
</div>
</body>
</html>