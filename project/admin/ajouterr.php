<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Ajouter</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   
   <link rel="stylesheet" href="../css/admin_style.css">
   <?php include '../components/admin_header.php'; ?>
   </head>
<body>
<section class="ajouterr">
    <div class="container">
        <div class="box">

<?php
       
       if(isset($_POST['button'])){
           
           extract($_POST);
           
           if(isset($nom)&& isset($numero)&& isset($camion)&& isset($matricule)&& isset($datelivraison)&& isset($client)){
                
                include_once "connexion.php";
                
                $req = mysqli_query($con , "INSERT INTO employer VALUES(NULL, '$nom','$numero','$camion','$matricule','$datelivraison','$client')");
                if($req){
                    header("location: indexx.php");
                }else {
                    $message = "Chauffeur non ajouté";
                }

           }else {
              
               $message = "Veuillez remplir tous les champs !";
           }
       }
    
    ?>
    
    <div class="form">
        <a href="indexx.php" class="back_btn"><img src=""> Retour</a>
        <h2>Ajouter un Chauffeur</h2>
        <p class="erreur_message">
            <?php 
           
            if(isset($message)){
                echo $message;
            }
            ?>

        </p>
        <form action="" method="POST">
            <label>Nom Complet</label>
            <input type="text" name="nom">
            <label>Num tel</label>
            <input type="text" name="numero">
            <label>Camion</label>
            <input type="text" name="camion">
            <label>Matricule</label>
            <input type="text" name="matricule">
            <label>Date de livraison</label>
            <input type="date" name="datelivraison">
            <label>Client</label>
            <input type="text" name="client">
            
            <input type="submit" value="Ajouter" name="button">
        </form>
    </div>
        </div>
    
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/admin_script.js"></script>
        </section>
<body>
    </html>
   