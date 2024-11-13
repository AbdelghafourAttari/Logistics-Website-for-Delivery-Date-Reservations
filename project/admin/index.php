
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Client</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">
   <?php include '../components/admin_header.php'; ?>
   </head>
<body>
    <br>
   <h1 class="heading">Client</h1>
   <br>
    <div class="container">
        
        <table>
            <tr id="items">
                <th>Nom Complet</th>
                <th>Organisme</th>
                <th>Num tel</th>
                <th>Email</th>
                <th>Poids</th>
                <th>Adresse de depart</th>
                <th>Adresse d'arriver</th>
                <th>Date de livraison</th>
                <th>Prix</th>
                <th>Camion</th>
                <th>Matricule</th>
                <th>Operation</th>
                
            </tr>
            <?php 
                
                include_once "connexion.php";
                $req = mysqli_query($con , "SELECT * FROM client");
                if(mysqli_num_rows($req) == 0){
                    echo "Il n'y a pas encore de client ajouter !" ;
                    
                }else {
                    while($row=mysqli_fetch_assoc($req)){
                        ?>
                        <tr>
                            <td><?=$row['nom']?></td>
                            <td><?=$row['organisme']?></td>
                            <td><?=$row['numero']?></td>
                            <td><?=$row['email']?></td>
                            <td><?=$row['poids']?></td>
                            <td><?=$row['depart']?></td>
                            <td><?=$row['arriver']?></td>
                            <td><?=$row['datelivraison']?></td>
                            <td><?=$row['prix']?></td>
                            <td><?=$row['camion']?></td>
                            <td><?=$row['matricule']?></td>
                        
                            <td><a href="modifier.php?id=<?=$row['id']?>" class="Btn_add"> <img src=""> Mod</a>
                            <a href="supprimer.php?id=<?=$row['id']?>" class="Btn_add"> <img src=""> Supp</a></td>
                        </tr>
                        <?php
                    }
                    
                }
            ?>
      
         
        </table>
        
        <a href="ajouter.php" class="Btn_add"> <img src=""> Ajouter</a>
   
   
   
   
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script src="../js/admin_script.js"></script>

            

</head>
<body>
   


