
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Employer</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">
   <?php include '../components/admin_header.php'; ?>
   </head>
<body>
<br>
   <h1 class="heading">Chauffeur</h1>
<section class="employer">
    <div class="container">
        <div class="box">
        <table>
            <tr id="items">
                <th>Nom Complet</th>
                <th>Num tel</th>
                <th>Camion</th>
                <th>Matricule</th>
                <th>Date de livraison</th>
                <th>Nom client</th>
                <th>Operation</th>
                
            </tr>
            <?php 
                
                include_once "connexion.php";
                $req = mysqli_query($con , "SELECT * FROM employer");
                if(mysqli_num_rows($req) == 0){
                    echo "Il n'y aucun chauffeur ajouter !" ;
                    
                }else {
                    while($row=mysqli_fetch_assoc($req)){
                        ?>
                        <tr>
                            <td><?=$row['nom']?></td>
                            <td><?=$row['numero']?></td>
                            <td><?=$row['camion']?></td>
                            <td><?=$row['matricule']?></td>
                            <td><?=$row['datelivraison']?></td>
                            <td><?=$row['client']?></td>
                        
                            <td><a href="modifierr.php?id=<?=$row['id']?>" class="Btn_add"> <img src=""> Mod</a>
                            <a href="supprimerr.php?id=<?=$row['id']?>" class="Btn_add"> <img src=""> Supp</a></td>
                        </tr>
                        <?php
                    }
                    
                }
            ?>
      
         
        </table>
        </div>
        <a href="ajouterr.php" class="Btn_add"> <img src=""> Ajouter</a>
   
   
   
   
    </div>
</section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script src="../js/admin_script.js"></script>



</head>
<body>
   