<?php
  $con = mysqli_connect("localhost","root","","apl_db");
  if(!$con){
     echo "Vous n'êtes pas connecté à la base de donnée";
  }
?>