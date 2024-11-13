<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Accueil</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>
<section class="dashboard">

   <h1 class="heading">Accueil</h1>

   <div class="box-container">

   <div class="box">
      <?php
         $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ? LIMIT 1");
         $select_profile->execute([$admin_id]);
         $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
      ?>
      <h3>Bienvenue</h3>
      <p><?= $fetch_profile['name']; ?></p>
      <a href="update.php" class="btn">Modifier mon compte</a>
   </div>

   <div class="box">
      <?php
         $select_bookings = $conn->prepare("SELECT * FROM `bookings`");
         $select_bookings->execute();
         $count_bookings = $select_bookings->rowCount();
      ?>
      <h3><?= $count_bookings; ?></h3>
      <p>Reservations reçues</p>
      <a href="bookings.php" class="btn">Voir les reservations</a>
   </div>

   <div class="box">
      <?php
         $select_messages = $conn->prepare("SELECT * FROM `messages`");
         $select_messages->execute();
         $count_messages = $select_messages->rowCount();
      ?>
      <h3><?= $count_messages; ?></h3>
      <p>Messages reçues</p>
      <a href="messages.php" class="btn">Voir les messages</a>
   </div>

</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script src="../js/admin_script.js"></script>

<?php include '../components/message.php'; ?>

</body>
</html>