<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   header('location:login.php');
}

if(isset($_POST['delete'])){

   $delete_id = $_POST['delete_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_delete = $conn->prepare("SELECT * FROM `bookings` WHERE booking_id = ?");
   $verify_delete->execute([$delete_id]);

   if($verify_delete->rowCount() > 0){
      $delete_bookings = $conn->prepare("DELETE FROM `bookings` WHERE booking_id = ?");
      $delete_bookings->execute([$delete_id]);
      $success_msg[] = 'Reservation supprimer';
   }else{
      $warning_msg[] = 'Reservation vien deja supprimer';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Reservation</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
   
<?php include '../components/admin_header.php'; ?>
<section class="grid">

   <h1 class="heading">Reservation</h1>

   <div class="box-container">

   <?php
      $select_bookings = $conn->prepare("SELECT * FROM `bookings`");
      $select_bookings->execute();
      if($select_bookings->rowCount() > 0){
         while($fetch_bookings = $select_bookings->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>Code de reservation : <span><?= $fetch_bookings['booking_id']; ?></span></p>
      <p>Nom Complet : <span><?= $fetch_bookings['name']; ?></span></p>
      <p>Email : <span><?= $fetch_bookings['email']; ?></span></p>
      <p>Numero de telephone : <span><?= $fetch_bookings['number']; ?></span></p>
      <p>Ville de depart : <span><?= $fetch_bookings['check_in']; ?></span></p>
      <p>ville d'arriver : <span><?= $fetch_bookings['check_out']; ?></span></p>
      <p>Nombre de camions : <span><?= $fetch_bookings['rooms']; ?></span></p>
      <p>Date de livraison : <span><?= $fetch_bookings['adults']; ?></span></p>
      <p>Poids a livré : <span><?= $fetch_bookings['childs']; ?></span></p>
      <form action="" method="POST">
         <input type="hidden" name="delete_id" value="<?= $fetch_bookings['booking_id']; ?>">
         <input type="submit" value="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer cette reservation?');" name="delete" class="btn">
      </form>
   </div>
   <?php
      }
   }else{
   ?>
   <div class="box" style="text-align: center;">
      <p>Aucune reservation trouver</p>
      <a href="dashboard.php" class="btn">Revenir à l'accueil</a>
   </div>
   <?php
      }
   ?>
   </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script src="../js/admin_script.js"></script>

<?php include '../components/message.php'; ?>

</body>
</html>