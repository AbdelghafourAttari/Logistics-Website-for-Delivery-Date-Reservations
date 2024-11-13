<?php 
  $con=mysqli_connect("localhost","root","","invoice_db");
  if(!$con){
    echo "Vous n'êtes pas connecté à la base de donnée";
 }
?>