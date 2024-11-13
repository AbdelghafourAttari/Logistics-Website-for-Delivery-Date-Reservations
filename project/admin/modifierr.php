<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Modifier</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   
<link rel="stylesheet" href="../css/admin_style.css">
  
   <?php include '../components/message.php'; ?>
</head>
<body>
<section class="modifierr">
    <div class="container">
        <div class="box">
   
<?php

         
         include_once "connexion.php";
         
          $id = $_GET['id'];
          
          $req = mysqli_query($con , "SELECT * FROM employer WHERE id = $id");
          $row = mysqli_fetch_assoc($req);


       
       if(isset($_POST['button'])){
           extract($_POST);
           if(isset($nom) && isset($numero) && isset($camion) && isset($matricule) && isset($datelivraison) && isset($client)){
               $req = mysqli_query($con, "UPDATE employer SET nom = '$nom' , numero = '$numero' , camion = '$camion' , matricule = '$matricule' , datelivraison = '$datelivraison' , client = '$client' WHERE id = $id");
                if($req){
                    header("location: indexx.php");
                }else {
                    $message = "Chauffeur non modifié";
                }

           }else {
               
               $message = "Veuillez remplir tous les champs !";
           }
       }
    
    ?>
    <div class="row">

    <div class="form">
        <a href="index.php" class="back_btn"><img src=""> Retour</a>
        <h2>Modifier le chauffeur : <?=$row['nom']?> </h2>
        <p class="erreur_message">
           <?php 
              if(isset($message)){
                  echo $message ;
              }
           ?>
        </p>
        <form action="" method="POST">
            <label>Nom Complet</label>
            <input type="text" name="nom" value="<?=$row['nom']?>">
            <label>Numero</label>
            <input type="number" name="numero" value="<?=$row['numero']?>">
            <label>Camion</label>
            <input type="text" name="camion" value="<?=$row['camion']?>">
            <label>Matricule</label>
            <input type="text" name="matricule" value="<?=$row['matricule']?>">
            <label>Date de livraison</label>
            <input type="date" name="datelivraison" value="<?=$row['datelivraison']?>">
            <label>Client</label>
            <input type="text" name="client" value="<?=$row['client']?>">
            <input type="submit" value="Modifier" name="button">
        </form>
    </div>
    </div>
        </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/admin_script.js"></script>

            </section>
   

</body>
</html>