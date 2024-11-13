<?php

include_once "connexion.php";
  $id= $_GET['id'];
  $req = mysqli_query($con , "DELETE FROM employer WHERE id = $id");
  header("Location:indexx.php")
?>