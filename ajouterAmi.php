<?php 


require('util.php');

$ami =$_POST['ami'];
$moi =$_SESSION['login'];

$db = connecterBDD();

$query="INSERT INTO AMIS VALUES ( (SELECT ID_UTILISATEURS FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='$moi'), (SELECT ID_UTILISATEURS FROM EISTI_BOOK_UTILISATEUR WHERE LOGIN='$ami'),0 )";

$res = mysqli_query($db, $query) or die('Request error : '.$query);

echo $res;



deconnecterBDD($db);




?>
