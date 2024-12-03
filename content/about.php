<?php
session_start();
require_once '../php/auth.php';
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <?php 
    include "common/common_head.php";
  ?>
<title>About</title>
</head>

<body>
<?php
    include 'common/navbar.php';
?>
<!-- Header -->
<header class="jumbotron text-center text-white" style="padding:128px 16px;">
    <h1 class="display-2">UN POSTO PER REALIZZARE LE TUE IDEE!</h1>
    <p class="lead"> Ci impegnamo per garantire la migliore esperienza di prenotazione
      di location per eventi. <br>
      Offriamo un portale pratico e veloce per chi offre uno spazio e per chi lo cerca e per gestire comodamente le prenotazioni. 
  </p>
</header>

<!-- First Grid -->
<div class="container py-5">
  <div class="row">
    <div class="col-lg-8">
      <h1>Mission</h1>
      <p>Ci impegnamo per offrire un servizio efficiente per sfruttare al meglio gli spazi disponibili
        e per offrire tutte le informazioni necessarie a chi desidera prenotarli.
      </p>
    </div>
    <div class="col-lg-4 d-flex justify-content-center">
      <i class="fa fa-bullseye fa-5x my-auto aqua"></i>
    </div>
  </div>
</div>

<!-- Second Grid -->
<div class="container-fluid py-5 bg-light">
  <div class="container">
    <div class="row flex-column-reverse flex-lg-row">
      <div class="col-lg-4 d-flex justify-content-center">
        <i class="fa fa-history fa-5x my-auto aqua"></i>
      </div>
      <div class="col-lg-8">
        <h1>Storia</h1>
        <p>Il progetto nasce da una ricerca di sale per eventi di ballo a Genova.
            Banchè molti locali, enti e circoli offrano spazi in affitto per organizzazione di eventi
            privati o aperti al pubblico, è complicato trovare gli spazi che abbiano tutte le caratteristiche necessarie
            per un determinato tipo di eventi e verificarne la disponibilità in un certo periodo o fascia oraria.
        </p>
      </div>
    </div>
  </div>
</div>

<?php 
    include 'common/footer.php'
?>
</body>
</html>