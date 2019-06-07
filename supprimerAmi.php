<?php 


require('util.php');

$ami =$_POST['ami'];
$moi =$_SESSION['login'];
$sens=$_POST['sens'];

$db = connecterBDD();

//sens = 0 si on veut supprimer quelqu'un de nos amis,
// sens = 1 si on veut refuser une amitié
if ($sens==0) {
	$query="DELETE FROM AMIS WHERE AMIS.ID_UTILISATEURS= (SELECT ID_UTILISATEURS FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='$moi') AND AMIS.ID_AMIS = (SELECT ID_UTILISATEURS FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='$ami')";
} else {
	$query="DELETE FROM AMIS WHERE AMIS.ID_UTILISATEURS= (SELECT ID_UTILISATEURS FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='$ami') AND AMIS.ID_AMIS = (SELECT ID_UTILISATEURS FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='$moi')";
}

$res = mysqli_query($db, $query) or die('Request error : '.$query);

echo $res;


deconnecterBDD($db);




?>
