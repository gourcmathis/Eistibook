<?php 


require('util.php');

$ami =$_POST['ami'];
$moi =$_SESSION['login'];

$db = connecterBDD();

$query="DELETE FROM AMIS WHERE AMIS.ID_UTILISATEURS= (SELECT ID_UTILISATEURS FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='$moi') AND AMIS.ID_AMIS = (SELECT ID_UTILISATEURS FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='$ami')";

$res = mysqli_query($db, $query) or die('Request error : '.$query);

if ($res) {
	echo "Cette personne a bien été suprimmée de vos amis.";
} else {
	echo "Ca n'a pas marché. ";
} 



deconnecterBDD($db);




?>
