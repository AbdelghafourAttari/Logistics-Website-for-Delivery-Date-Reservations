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
<section class="ajouter">
    <div class="container">
        <div class="box">

<?php
       
       if(isset($_POST['button'])){
           
           extract($_POST);
           
           if(isset($nom) && isset($organisme)&& isset($numero)&& isset($email)&& isset($poids)&& isset($depart)&& isset($arriver)&& isset($datelivraison)&& isset($prix)&& isset($camion)&& isset($matricule)){
                
                include_once "connexion.php";
                
                $req = mysqli_query($con , "INSERT INTO client VALUES(NULL, '$nom','$organisme','$numero','$email','$poids','$depart','$arriver','$datelivraison','$prix','$camion','$matricule')");
                if($req){
                    header("location: index.php");
                }else {
                    $message = "Client non ajouté";
                }

           }else {
              
               $message = "Veuillez remplir tous les champs !";
           }
       }
    
    ?>
    
    <div class="form">
        <a href="index.php" class="back_btn"><img src=""> Retour</a>
        <h2>Ajouter un Client</h2>
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
            <label>Organisme</label>
            <input type="text" name="organisme">
            <label>Num tel</label>
            <input type="text" name="numero">
            <label>Email</label>
            <input type="email" name="email">
            <label>Poids</label>
            <input type="text" name="poids">
            <label>Ville de depart</label>
            <input type="text" name="depart">
            <label>Ville d'arriver</label>
            <input type="text" name="arriver">
            <label>Date de livraison</label>
            <input type="date" name="datelivraison">
            <label>Prix</label>
            <input type="text" name="prix">
            <label>Nombre Camion</label>
            <input type="texte" name="camion">
            <label>Matricule</label>
            <input type="text" name="matricule">
            
            <input type="submit" value="Ajouter" name="button">
        </form>
    </div>
        </div>
       
    
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


<script src="../js/admin_script.js"></script>
   
        </section>
   


<body>
    </html>
   


