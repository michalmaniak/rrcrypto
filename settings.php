<?php 
 $servername="";
 $username = "";

$password = "";

$dbname = "";

$conn = mysqli_connect($servername, $username, $password, $dbname);
      mysqli_set_charset($conn, "utf8");
	  
	  
	  
	  //Settings array
	  $settings = array(
    "token" => "",
	"owner" => "",  //Handle osoby odpowiedzialnej za wpłaty/wypłaty, podawać bez @ (np. michalmaniak)
	"admin" =>                           //ID administratora w celu dostępu do komend /withdraw itp

);
?>