<!-- atention, si on ouvre on page de profil, il faut toujours en get la personne dont on regarde le profil -->
<?php
require("util.php");
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
           <link href="./profil.css"
          rel="stylesheet" type="text/css">
</head>


<?php 

if (empty($_GET) || !existe($_GET["perso"]) ) { 
	echo "<div class='error'>Cette page n'existe pas. </div>";
	$acces='no';
} else {
	// page profil de qui : récup les identifiants dans la session
	$pageDe=$_GET["perso"];

	// on vérifie que la personne a le droit de modifier ce profil
	if ($pageDe==$_SESSION['login']) {
		//possibilité de tout modifier. 
		$acces="ok";
		
	} elseif ($_SESSION['type']=='admin') {
		//l'administrateur a accès à toutes les données personnelles et peut les modifier
		$acces='admin';

	} else {
		$acces='no';
	}
}
?>

<body>
<h1 class="titre"> Modifier mon profil  </h1>
<img class="logo" src="EISTIB6.png">



<div class="section3">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <ul >
                   
                    <li class="menuli" >
                        <a class="nonlien" href="profil.php?perso=<?php echo $_SESSION['login']; ?>"> Retour sur mon profil </a>
                    </li>
                    <li class="menuli">
                        <a class="nonlien" href="publi.php"> Mon fil d'actualité </a>
                    </li>

		            <li class="menuli">
                        <a class="nonlien" href="amis.php"> Gérer mes amitiés amis </a>
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








<?php

// on charge toutes les infos 
// if terminé tout en bas de la page
if ($acces<>"no") {
	$tableau=chargerInfos($pageDe);
	$infos=$tableau[0];	
	$options=chargerOptions();
	$_SESSION['page_modifiee']=$pageDe;


?>

<!-- Mot de passe  -->
<div class='droit'>
	<a class="nonlien" href="mdp.php?perso=<?php echo $_SESSION['login']; ?>"> Modifier le mot de passe </a>
</div>




<!-- toutes les informations du profil -->
<div class='milieu'>
  <form class='form-horizontal' role='form' action='valider_modif.php' method='POST' enctype="multipart/form-data" >
	<!-- informations générales, non modifiables -->
	<div>
		<?php
		// nom, prenom, login et la date de naissance ne sont pas modifiables
		echo "
			<h3> ".$infos['NOM']." </h3>
    			<h4> ".$infos['PRENOM']."</h4>
    			<p>Né le ".$infos['NAISSANCE']."</p>";
    		if (!empty($infos["SEXE"])) {
    			echo "<p> Genre : ".$infos["SEXE"]."<p>";
    		} else {
    			echo "<p> Votre genre n'est pas défini. </p>";
    		?>	
    			<label><input type='radio' class='form-control' id='Homme' name='genre' />Homme</label>
    			<label><input type='radio' class='form-control' id='Femme' name='genre' />Femme</label>
    			<label><input type='radio' class='form-control' id='Autre' name='genre' />Autre</label> 
    		<?php } ?>  	
    	</div>
    	
    	
    	
    	
    	<!-- promotion -->
    	<div>
    		<h3>Votre promotion</h3>

			<p>Vous avez redoublé ? Vous pouvez ici changer votre promotion. Séléctionnez votre nouvelle promotion : </p>
                            <input type="number" class="form-control" id="promo" name="promo" value="<?php echo $infos['PROMOTION']; ?>"  >

		</div> 		
		
		
	<!-- photo de profil -->
	<div> 
		<h3>Votre photo de profil</h3>
		
	
<div>
	
		<label for="photo">Icône du fichier (JPG, PNG ou GIF | max. 1Mo) :</label><br />
     	<input type="file" name="photo" id="photo"  /><br />
     	<!-- <input type="submit" name="submit" id="env" value="Envoyer" /> -->
	



</div>

	</div>

	<!-- citation -->
	<div>
		<h3>Votre citation</h3>
			<?php
			if (!empty($infos['CITATION'])) {
				echo "<p>Vous voulez modifier votre citation ? Entrez-la dans le champ suivant : </p> ";
				$cit=$infos['CITATION'];
			} else {
				echo "<p>Vous n'avez pas de citation. Vous voulez la définir ? Inscrivez-la dans le champ suivant :</p>";
				$cit="";
			} 
			?>
			<textarea id="citation" name="citation" ><?php echo $cit; ?></textarea>

	</div>


	<!-- introduction -->
	<div>
		<h3>Votre introduction</h3>
			<?php
			if (!empty($infos['INTRO'])) {
				echo "<p>Vous voulez modifier votre introduction ? Entrez-la dans le champ suivant : </p> ";
				$intro=$infos['INTRO'];
			} else {
				echo "<p>Vous n'avez pas d'introduction. Vous voulez en définir une ? Inscrivez-la dans le champ suivant :</p>";
				$intro="";
			} 
			?>
			<textarea id="intro" name="intro" ><?php echo $intro; ?></textarea>
	</div>


	<!-- diplome -->
	<div>
		<h3>Votre dimplome</h3>
			<?php
			if (!empty($infos['DIPLOME'])) {
				echo "<p>Vous avez optenu un nouveau diplome ? Mettez votre profil à jour : </p> ";
				$diplo=$infos['DIPLOME'];
			} else {
				echo "<p>Indiquez ici le plus haut diplome que vous avez optenu : </p>";
				$diplo="";
			} 
			?>
			<input type="text" class="form-control" id="diplome" name="diplome" value="<?php echo $diplo; ?>">
	</div>





	<!-- profession -->
	<div>
		<h3>Votre profession</h3>
			<?php
			if (!empty($infos['PROFESSION'])) {
				echo "<p>Vous avez récemment changé de profession ? Mettez votre profil à jour : </p> ";
				$prof=$infos['PROFESSION'];
			} else {
				echo "<p>Vous n'avez pas indiqué votre profession actuelle ! Allez-y :</p>";
				$prof="";
			} 
			?>
			<input type="text" class="form-control" id="profession" name="profession" value="<?php echo $prof; ?>">
	</div>


	<!-- emploi -->
	<div>
		<h3>Votre emploi</h3>
			<?php
			if (!empty($infos['EMPLOI'])) {
				echo "<p>Vous avez récemment changé d'emploi ? Mettez votre profil à jour : </p> ";
				$emploi=$infos['EMPLOI'];
			} else {
				echo "<p>Vous n'avez pas indiqué d'emploi actuel ! Ne vous inquiétez pas, il est encore temps :</p>";
				$emploi="";
			} 
			?>
			<input type="text" class="form-control" id="emploi" name="emploi" value="<?php echo $emploi; ?>">
	</div>

	
	<!-- ville -->
	<div>
		<h3>Votre Ville</h3>
			<?php
			if (!empty($infos['VILLE'])) {
				echo "<p>Vous venez de déménager ? Dites-le nous : </p> ";
				$ville=$infos['VILLE'];
			} else {
				echo "<p>Votre profil ne contient pas d'adresse, indiquez-la pour renconter les professionnels présents près de chez vous :</p>";
				$ville="";
			} 
			?>
			<input type="text" class="form-control" id="ville" name="ville" value="<?php echo $ville; ?>" >
	</div>
	
	
	<!-- loisirs -->
	<div>
		<h3>Vos loisirs</h3>
			<?php
			if (!empty($infos['LOISIR'])) {
				echo "<p>Un nouveau loisir ? Partagez-le :</p> ";
				$loisir=$infos['LOISIR'];
			} else {
				echo "<p>Parlez-nous de vos loisirs pour que vos amis vous connaissent mieux :</p>";
				$loisir="";
			} 
			?>
			<input type="text" class="form-control" id="loisir" name="loisir" value="<?php echo $loisir; ?>" >
	</div>
	
	
	<!-- caractère -->
	<div>
		<h3>Votre caractère</h3>
			<?php
			$caract=$tableau[1];
			$optCaract=$options[0];
			if (!empty($caract)) {
				echo "<p>Vous voulez développer votre caractère ? </p> ";
				

			} else {
				echo "<p>Vous n'avez rien indiqué sur votre caractère :( </p>";
			}
			foreach ($optCaract as $opt) {
				$valeur=$opt[0];
				$id=$opt[1];
				echo "<label><input type='checkbox' class='form-control' value='".$id."' name='caractere[]'"; // caractere[] sera un tableau contenant toute sles cases cochées
				if (in_array($valeur,$caract)) {
					echo "checked";
				}
				echo "/>$valeur</label>";
			}
			?>
	</div>
	
	<!-- compétences -->
	<div>
		<h3>Vos compétences </h3>
			<?php
			$comp=$tableau[2];
			$optComp=$options[1];
			if (!empty($comp)) {
				echo "<p>Vous voulez ajouter de nouvelles compétences ? </p> ";
			} else {
				echo "<p>Vous n'avez pas indiqué de compétences sur votre profil :( </p>";
			}
			foreach ($optComp as $opt) {
				$valeur=$opt[0];
				$id=$opt[1];
				echo "<label><input type='checkbox' class='form-control' value='".$id."' name='competences[]'";
				if (in_array($valeur,$comp)) {
					echo "checked";
				}
				echo "/>$valeur</label>";
			}
			?>
	</div>
	
	<!-- langues -->
	<div>
		<h3>Les langues que vous parlez</h3>
			<?php
			$langues=$tableau[3];
			$optlangues=$options[2];
			if (!empty($langues)) {
				echo "<p>Vous avez appris une nouvelle langue ? </p> ";
			} else {
				echo "<p>Vous ne parlez aucune langue ? Indiquez au moins votre langue maternelle. </p>";
			}
			foreach ($optlangues as $opt) {
				$valeur=$opt[0];
				$id=$opt[1];
				echo "<label><input type='checkbox' class='form-control' value='".$id."' name='langues[]'";
				if (in_array($valeur,$langues)) {
					echo "checked";
				}
				echo "/>$valeur</label>";
			}
			?>
	</div>
	
	
	<!-- outils -->
	<div>
		<h3>Les outils que vous maitrisez</h3>
			<?php
			$outils=$tableau[4];
			$optOutils=$options[3];
			if (!empty($outils)) {
				echo "<p>Vous avez appris une nouvelle langue ? </p> ";
			} else {
				echo "<p>Vous ne parlez aucune langue ? Indiquez au moins votre langue maternelle. </p>";
			}
			foreach ($optOutils as $opt) {
				$valeur=$opt[0];
				$id=$opt[1];
				echo "<label><input type='checkbox' class='form-control' value='".$id."' name='outils[]'";
				if (in_array($valeur,$outils)) {
					echo "checked";
				}
				echo "/>$valeur</label>";
			}
			?>
	</div>




	
<?php 	

//fin du if initial
} 
?>
	<button type="submit" class="bouton">Valider mes modifications</button>
  </form>
</div>


</body>
</html>