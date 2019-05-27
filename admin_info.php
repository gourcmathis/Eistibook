<?php
include("admin_fonctions.php");

	$id_util=$_POST['id_util'];       //Récupère l'ID de l'utilisateur sélectionné

	$langues=str_annex($id_util,0);     //Chaine de caractères contenant les langues parlées par l'utilisateur
	$carac=str_annex($id_util,1);		//Chaine de caractères contenant les caractères de l'utilisateur
	$competences=str_annex($id_util,2);	//Chaine de caractères contenant les compétences de l'utilisateur
	$outils=str_annex($id_util,3);	//Chaine de caractères contenant les outils maitrisés par l'utilisateur
	$amis=str_annex($id_util,4);		//Chaine de caractères contenant les noms et prénoms des amis de l'utilisateur

	$tabInfos=getInfos(); 	//Récupère toutes les informations personnelles relatives à tous les utilisateurs présents dans la BDD sauf les 5 types d'informations cités au-dessus (langues, caractère, competences, etc...)
	$i=0;
	$condition=true;
	while (($condition) && ($i<count($tabInfos)-1)) {		//Cherche l'utilisateur correspondant à l'ID récupéré en début de fichier
		if ($id_util==$tabInfos[$i]['id_utilisateurs']) {
			$condition=false;
		} else {
			$i=$i+1;
		}
	}
	$tabLangue=array('langue' => $langues);					//Crée un tableau pour chaque type d'information manquant
	$tabCarac=array('caractere' => $carac);
	$tabComp=array('competence' => $competences);
	$tabOutils=array('outil' => $outils);
	$tabAmis=array('ami' => $amis);
	$tabAnnex=array_merge($tabLangue,$tabCarac,$tabComp,$tabOutils,$tabAmis);
	$tabInfos[$i]=array_merge($tabInfos[$i],$tabAnnex);			//Fusionne tous les tableaux ensemble afin d'avoir toutes les informations personnelles de l'utilisateur sans exception


	/*Affiche toutes les informations personnelles de cet utilisateur */
	
	echo "<img src='".$tabInfos[$i]['photo']."'><br>";
	echo "ID de l'utilisateur : ".$tabInfos[$i]['id_utilisateurs']."<br>";
	echo "Niveau d'accès : ".$tabInfos[$i]['type']."<br>";
	echo "Nom : ".$tabInfos[$i]['nom']."<br>";
	echo "Prénom : ".$tabInfos[$i]['prenom']."<br>";
	echo "Login : ".$tabInfos[$i]['login']."<br>";
	echo "Mot de passe : ".$tabInfos[$i]['mdp']."<br>";
	echo "Profession : ".$tabInfos[$i]['profession']."<br>";
	echo "Ville : ".$tabInfos[$i]['ville']."<br>";
	echo "Introduction : ".$tabInfos[$i]['intro']."<br>";
	echo "Citation : ".$tabInfos[$i]['citation']."<br>";
	echo "Loisirs : ".$tabInfos[$i]['loisir']."<br>";
	echo "Sexe : ".$tabInfos[$i]['sexe']."<br>";
	echo "Photo de profil (url) : ".$tabInfos[$i]['photo']."<br>";
	echo "Emplois : ".$tabInfos[$i]['emplois']."<br>";
	echo "Diplomes : ".$tabInfos[$i]['diplome']."<br>";
	echo "Signalement : ".$tabInfos[$i]['signalement']."<br>";
	echo "Blocage (0 correspond à non-bloqué) : ".$tabInfos[$i]['blocage']."<br>";
	echo "Mur : ".$tabInfos[$i]['mur']."<br>";
	echo "Date de naissance : ".$tabInfos[$i]['naissance']."<br>";
	echo "Année de promotion : ".$tabInfos[$i]['promotion']."<br>";
	echo "Langues parlées : ".$tabInfos[$i]['langue']."<br>";
	echo "Traits de caractère : ".$tabInfos[$i]['caractere']."<br>";
	echo "Compétences : ".$tabInfos[$i]['competence']."<br>";
	echo "Outils : ".$tabInfos[$i]['outil']."<br>";
	echo "Liste d'amis : ".$tabInfos[$i]['ami']."<br><br>";
?>