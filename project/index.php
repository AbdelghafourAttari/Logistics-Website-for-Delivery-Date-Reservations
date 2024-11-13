<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   setcookie('user_id', create_unique_id(), time() + 60*60*24*30, '/');
   header('location:index.php');
}

if(isset($_POST['check'])){

   $check_in = $_POST['check_in'];
   $check_in = filter_var($check_in, FILTER_SANITIZE_STRING);

   $total_rooms = 0;

   $check_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE check_in = ?");
   $check_bookings->execute([$check_in]);

   while($fetch_bookings = $check_bookings->fetch(PDO::FETCH_ASSOC)){
      $total_rooms += $fetch_bookings['rooms'];
   }

    
   if($total_rooms >= 30){
      $warning_msg[] = 'Aucun transport disponible pour cette date';
   }else{
      $success_msg[] = 'Transport disponible';
   }

}

if(isset($_POST['book'])){

   $booking_id = create_unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $rooms = $_POST['rooms'];
   $rooms = filter_var($rooms, FILTER_SANITIZE_STRING);
   $check_in = $_POST['check_in'];
   $check_in = filter_var($check_in, FILTER_SANITIZE_STRING);
   $check_out = $_POST['check_out'];
   $check_out = filter_var($check_out, FILTER_SANITIZE_STRING);
   $adults = $_POST['adults'];
   $adults = filter_var($adults, FILTER_SANITIZE_STRING);
   $childs = $_POST['childs'];
   $childs = filter_var($childs, FILTER_SANITIZE_STRING);

   $total_rooms = 0;

   $check_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE check_in = ?");
   $check_bookings->execute([$check_in]);

   while($fetch_bookings = $check_bookings->fetch(PDO::FETCH_ASSOC)){
      $total_rooms += $fetch_bookings['rooms'];
   }

   if($total_rooms >= 30){
      $warning_msg[] = 'Transport indisponible pour cette date';
   }else{

      $verify_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE user_id = ? AND name = ? AND email = ? AND number = ? AND rooms = ? AND check_in = ? AND check_out = ? AND adults = ? AND childs = ?");
      $verify_bookings->execute([$user_id, $name, $email, $number, $rooms, $check_in, $check_out, $adults, $childs]);

      if($verify_bookings->rowCount() > 0){
         $warning_msg[] = 'Date deja prise';
      }else{
         $book_room = $conn->prepare("INSERT INTO `bookings`(booking_id, user_id, name, email, number, rooms, check_in, check_out, adults, childs) VALUES(?,?,?,?,?,?,?,?,?,?)");
         $book_room->execute([$booking_id, $user_id, $name, $email, $number, $rooms, $check_in, $check_out, $adults, $childs]);
         $success_msg[] = 'Date reserver le support vas vous contacter dan pas longtemps';
      }

   }

}

if(isset($_POST['send'])){

   $id = create_unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $message = $_POST['message'];
   $message = filter_var($message, FILTER_SANITIZE_STRING);

   $verify_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $verify_message->execute([$name, $email, $number, $message]);

   if($verify_message->rowCount() > 0){
      $warning_msg[] = 'Message envoyer';
   }else{
      $insert_message = $conn->prepare("INSERT INTO `messages`(id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$id, $name, $email, $number, $message]);
      $success_msg[] = 'Message bien envoyer';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Accueil</title>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="home" id="home">

   <div class="swiper home-slider">

      <div class="swiper-wrapper">

         <div class="box swiper-slide">
            <img src="images/conduire-camion.jpeg" alt="">
            <div class="flex">
            
            </div>
         </div>

         <div class="box swiper-slide">
            <img src="images/location-utilitaire-demenagement.jpg" alt="">
            <div class="flex">
               <h3>Livraisons juste à temps</h3>
               <a href="#reservation" class="btn">Reserver pour une livraison</a>
            </div>
         </div>

         <div class="box swiper-slide">
            <img src="images/home-img-3.jpg" alt="">
            <div class="flex">
               <h3>Service fiable</h3>
               <a href="#contact" class="btn">contactez-nous</a>
            </div>
         </div>

      </div>

      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>

   </div>

</section>
<section class="availability" id="availability">

   <form action="" method="post">
      <div class="flex">
         <div class="box">
            <p>Ville de depart<span>:</span></p>
            <select name="check_in" class="input" required>
            <option value="Casablanca">Casablanca</option>
            <option value="Salé">Salé</option>
            <option value="Tanger">Tanger</option>
            <option value="Fès">Fès</option>
            <option value="Marrakech">Marrakech</option>
            <option value="Safi">Safi</option>
            <option value="Meknès">Meknès</option>
            <option value="Oujda">Oujda</option>
            <option value="Rabat">Rabat</option>
            <option value="Témara">Témara</option>
            <option value="Agadir">Agadir</option>
            <option value="Kénitra">Kénitra</option>
            <option value="tétouan">tétouan</option>
            <option value="Laayoune">Laayoune</option>
            <option value="Mohammédia">Mohammédia</option>
            <option value="El Jadida">El Jadida</option>
            <option value="Khouribga">Khouribga</option>
            <option value="Béni Mellal">Béni Mellal</option>
            <option value="Khémisset">Khémisset</option>
            <option value="Nador">Nador</option>
            <option value="Taza">Taza</option>
            <option value="Berkane">Berkane</option>  
            </select>
         </div>
         <div class="box">
            <p>Ville d'arriver'<span>:</span></p>
            <select name="check_out" class="input" required>
            <option value="Casablanca">Casablanca</option>
            <option value="Salé">Salé</option>
            <option value="Tanger">Tanger</option>
            <option value="Fès">Fès</option>
            <option value="Marrakech">Marrakech</option>
            <option value="Safi">Safi</option>
            <option value="Meknès">Meknès</option>
            <option value="Oujda">Oujda</option>
            <option value="Rabat">Rabat</option>
            <option value="Témara">Témara</option>
            <option value="Agadir">Agadir</option>
            <option value="Kénitra">Kénitra</option>
            <option value="tétouan">tétouan</option>
            <option value="Laayoune">Laayoune</option>
            <option value="Mohammédia">Mohammédia</option>
            <option value="El Jadida">El Jadida</option>
            <option value="Khouribga">Khouribga</option>
            <option value="Béni Mellal">Béni Mellal</option>
            <option value="Khémisset">Khémisset</option>
            <option value="Nador">Nador</option>
            <option value="Taza">Taza</option>
            <option value="Berkane">Berkane</option>
            </select>
         </div>
         <div class="box">
            <p>Date de livraison<span>:</span></p>  
            <input type="date" name="adults" class="input" required>
            </select>
         </div>
         <div class="box">
            <p>Poids a livré <span>:</span></p>
            <select name="childs" class="input" required>
               <option value="0-1000 kg">0-1000 kg</option>
               <option value="1000-2000 kg">1000-2000 kg</option>
               <option value="2000-3000 kg">2000-3000 kg</option>
               <option value="3000-4000 kg">3000-4000 kg</option>
               <option value="4000-5000 kg">4000-5000 kg</option>
               <option value="5000-6000 kg">5000-6000 kg</option>
               <option value="6000-7000 kg">6000-7000 kg</option>
               <option value="7000-8000 kg">7000-8000 kg</option>
               <option value="8000-9000 kg">8000-9000 kg</option>
               <option value="9000-10000 kg">9000-10000 kg</option>
               <option value="+ 10000 kg">+ 10000 kg</option>
            </select>
         </div>
         <div class="box">
            <p>Camion<span>:</span></p>
            <select name="rooms" class="input" required>
               <option value="1 Camion">1 Camion</option>
               <option value="2 Camion">2 Camion</option>
               <option value="3 Camion">3 Camion</option>
               <option value="4 Camion">4 Camion</option>
               <option value="5 Camion">5 Camion</option>
            </select>
         </div>
      </div>
      <input type="submit" value="Voir disponibilité" name="check" class="btn">
   </form>

</section>
<section class="about" id="about">

<div class="row">
      <div class="image">
         <img src="images/about-img-1.jpg" alt="">
      </div>
      <div class="content">
         <h3>Chauffeur capable</h3>
         <p>Nos chauffeurs professionnel et capable ayant une large expérience dans la conduite des camions surchargés, le fait qui assure la livraison de vos produits en plein securiter et dans les délais demandés</p>
         <a href="#reservation" class="btn">Resererver des maintenant</a>
      </div>
   </div>

   <div class="row revers">
      <div class="image">
         <img src="images/about-img-2.jpg" alt="">
      </div>
      <div class="content">
         <h3>Nouveaux vehicule</h3>
         <p>Des nouveaux camions pour assurer la sécurité de votre livraison de n'importe quel danger confronter dans la route</p>
         <a href="#contact" class="btn">contactez-nous</a>
      </div>
   </div>
</section>
<section class="services">

   <div class="box-container">

      <div class="box">
         <img src="images/icon-1.png" alt="">
         <h3>Nouveaux Camions</h3>
         <p>Nouveaux camions pour assurer une livraison saine</p>
      </div>

      <div class="box">
         <img src="images/icon-2.png" alt="">
         <h3>Contre la montre</h3>
         <p>Nos conducteur font leur mieux pour respecter le delais de la livraison</p>
      </div>

      <div class="box">
         <img src="images/icon-3.png" alt="">
         <h3>Emballage</h3>
         <p>Votre livraison est bien emballer pour garantir sa securiter</p>
      </div>

      <div class="box">
         <img src="images/icon-4.png" alt="">
         <h3>Chauffeur compétent</h3>
         <p>Nos chauffeur sont expérimenter et bien choisies </p>
      </div>

      <div class="box">
         <img src="images/icon-5.png" alt="">
         <h3>Accompagnement</h3>
         <p>Accompagnement durant le trajets</p>
      </div>

      <div class="box">
         <img src="images/icon-6.png" alt="">
         <h3>Support 24/24</h3>
         <p>Notre support est à votre disposition 24/24</p>
      </div>

   </div>

</section>


<section class="reservation" id="reservation">

   <form action="" method="post">
      <h3>Reserver maintenant</h3>
      <div class="flex">
         <div class="box">
            <p>Nom complet<span>:</span></p>
            <input type="text" name="name" maxlength="50" required placeholder="Enter votre nom complet" class="input">
         </div>
         <div class="box">
            <p>Email<span>:</span></p>
            <input type="email" name="email" maxlength="50" required placeholder="Entrer votre email" class="input">
         </div>
         <div class="box">
            <p>Numero de telephone<span>:</span></p>
            <input type="number" name="number" maxlength="10" min="0" max="9999999999" required placeholder="Entrer votre numero de telephone" class="input">
         </div>
         <div class="box">
            <p>Nombre de camion<span>:</span></p>
            <select name="rooms" class="input" required>
               <option value="1" selected>1 camion</option>
               <option value="2">2 camions</option>
               <option value="3">3 camions</option>
               <option value="4">4 camions</option>
               <option value="5">5 camions</option>
            </select>
         </div>
         <div class="box">
            <p>Ville de depart<span>:</span></p>
            <select name="check_in" class="input" required>
            <option value="-">Casablanca</option>
            <option value="1">Salé</option>
            <option value="2">Tanger</option>
            <option value="3">Fès</option>
            <option value="4">Marrakech</option>
            <option value="5">Safi</option>
            <option value="6">Meknès</option>
            <option value="7">Oujda</option>
            <option value="8">Rabat</option>
            <option value="9">Témara</option>
            <option value="10">Agadir</option>
            <option value="11">Kénitra</option>
            <option value="12">tétouan</option>
            <option value="13">Laayoune</option>
            <option value="14">Mohammédia</option>
            <option value="15">El Jadida</option>
            <option value="16">Khouribga</option>
            <option value="17">Béni Mellal</option>
            <option value="18">Khémisset</option>
            <option value="19">Nador</option>
            <option value="20">Taza</option>
            <option value="21">Berkane</option>  
            </select>
         </div>
         <div class="box">
            <p>Ville d'arriver<span>:</span></p>
            <select name="check_out" class="input" required>
            <option value="-">Casablanca</option>
            <option value="1">Salé</option>
            <option value="2">Tanger</option>
            <option value="3">Fès</option>
            <option value="4">Marrakech</option>
            <option value="5">Safi</option>
            <option value="6">Meknès</option>
            <option value="7">Oujda</option>
            <option value="8">Rabat</option>
            <option value="9">Témara</option>
            <option value="10">Agadir</option>
            <option value="11">Kénitra</option>
            <option value="12">tétouan</option>
            <option value="13">Laayoune</option>
            <option value="14">Mohammédia</option>
            <option value="15">El Jadida</option>
            <option value="16">Khouribga</option>
            <option value="17">Béni Mellal</option>
            <option value="18">Khémisset</option>
            <option value="19">Nador</option>
            <option value="20">Taza</option>
            <option value="21">Berkane</option>  
            </select>
         </div>
         <div class="box">
         <p>Date de livraison<span>:</span></p>  
            <input type="date" name="adults" class="input" required>
         </div>
         <div class="box">
         <p>Poids a livré <span>:</span></p>
            <select name="childs" class="input" required>
               <option value="-">0-1000 kg</option>
               <option value="1">1000-2000 kg</option>
               <option value="2">2000-3000 kg</option>
               <option value="3">3000-4000 kg</option>
               <option value="4">4000-5000 kg</option>
               <option value="5">5000-6000 kg</option>
               <option value="6">6000-7000 kg</option>
               <option value="7">7000-8000 kg</option>
               <option value="8">8000-9000 kg</option>
               <option value="9">9000-10000 kg</option>
               <option value="10">+ 10000 kg</option>
            </select>
         </div>
      </div>
      <input type="submit" value="Reserver" name="book" class="btn">
   </form>

</section>
<section class="gallery" id="gallery">

   <div class="swiper gallery-slider">
      <div class="swiper-wrapper">
         <img src="images/chauffeur-immigrant-lo-res-crédit-Volvo-Trucks.jpg" class="swiper-slide" alt="">
         <img src="images/Conducteur-professionel-Maroc-1024x684.jpeg" class="swiper-slide" alt="">
         <img src="images/transport-national-routier-maroc-boumara-trans.jpg" class="swiper-slide" alt="">
         <img src="images/permis-classe-1-Montreal.jpg" class="swiper-slide" alt="">
      </div>
      <div class="swiper-pagination"></div>
   </div>

</section>
<section class="contact" id="contact">

   <div class="row">

      <form action="" method="post">
         <h3>Envoyez-nous un message</h3>
         <input type="text" name="name" required maxlength="50" placeholder="Entrer votre nom complet" class="box">
         <input type="email" name="email" required maxlength="50" placeholder="Entrer votre Email" class="box">
         <input type="number" name="number" required maxlength="10" min="0" max="9999999999" placeholder="Entrer votre numero de telephone" class="box">
         <textarea name="message" class="box" required maxlength="1000" placeholder="Entrer votre message" cols="30" rows="10"></textarea>
         <input type="submit" value="Envoyer le message" name="send" class="btn">
      </form>

      <div class="faq">
         <h3 class="title">Question fréquente</h3>
         <div class="box active">
            <h3>Comment annuler ma reservation ?</h3>
            <p>Vous trouvez à l'entête de la page à droite le côté mes réservations dans lequel tu peux annuler votre réservation en cliquant sur le bouton annulé.</p>
         </div>
         <div class="box">
            <h3>Y a t'il des risque pour les produits fragile?</h3>
            <p>Notre équipe s'occupe de votre produit tous au long du procès de livraison pour vous garantir un service sécuriser.</p>
         </div>
         <div class="box">
            <h3>Quoi faire après la reservation?</h3>
            <p>Notre support vous contacte par appel téléphonique pour confirmer votre réservation.</p>
         </div>
         <div class="box">
            <h3>Paiment?</h3>
            <p>Le support vous comunique les details.</p>
         </div>
      </div>

   </div>

</section>
<section class="reviews" id="reviews">

   <div class="swiper reviews-slider">

      <div class="swiper-wrapper">
         <div class="swiper-slide box">
            <img src="images/1651010981389.jpg" alt="">
            <h3>Doers</h3>
            <p>Meilleur entreprise de transport de marchandise au Maroc. Service top je recommande.</p>
         </div>
         <div class="swiper-slide box">
            <img src="images/téléchargement.png" alt="">
            <h3>Marrakech Realty</h3>
            <p>Chauffeur professionel, et support actif bon travail.</p>
         </div>
         <div class="swiper-slide box">
            <img src="images/téléchargement (1).png" alt="">
            <h3>Immo Monte-Carlo</h3>
            <p>Chauffeur professionel, et support actif bon travail.</p>
         </div>
         <div class="swiper-slide box">
            <img src="images/imaggges.png" alt="">
            <h3>Bouygues Immobilier</h3>
            <p>Meilleur entreprise de transport de marchandise au Maroc. Service top je recommande.</p>
         </div>
      </div>

      <div class="swiper-pagination"></div>
   </div>

</section>

<?php include 'components/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/script.js"></script>
<?php include 'components/message.php'; ?>

</body>
</html>