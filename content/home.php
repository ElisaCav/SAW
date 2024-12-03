<?php
session_start();
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <?php 
    include "common/common_head.php";
  ?>
  <title>Home</title>
</head>
<body>
  
<?php
    require_once '../php/auth.php';
    include 'common/navbar.php';
?>

<!-- Header -->
<header class="jumbotron text-center text-white" style="padding:128px 16px;">
  <div class="d-inline-block" style="background-color: rgba(0, 0, 0, 0.5); border-radius: 15px; padding: 20px;">
    <h1 class="display-4">INIZIA ORA!</h1>
    <p class="lead">Scopri le location disponibili</p>
    <a class="btn btn-dark btn-lg" href="show_locations.php" role="button">Vai alle location</a>
  </div>
</header>

<!-- First Grid -->
<div class="container py-5">
  <div class="row">
    <div class="col-lg-8">
      <h1>La location ideale per la tua festa</h1>
      <p>Stai cercando lo spazio perfetto per una festa di compleanno per adulti o bambini o per una festa di laurea? </p>
      <p>Il nostro sito ti aiuta a trovare e prenotare il luogo ideale per ogni occasione.
      </p>
    </div>
    <div class="col-lg-4 d-flex justify-content-center">
      <i class="fa fa-birthday-cake fa-5x my-auto aqua"></i>
    </div>
  </div>
</div>

<!-- Second Grid -->
<div class="container-fluid py-5 bg-light">
  <div class="container">
    <div class="row flex-column-reverse flex-lg-row">
      <div class="col-lg-4 d-flex justify-content-center">
        <i class="fa fa-briefcase fa-5x my-auto aqua"></i>
      </div>
      <div class="col-lg-8">
        <h1>Conferenze e Riunioni di Lavoro</h1>
        <p>Vi aiutiamo a selezionare l'ambiente più adatto alle vostre esigenze.</p>
        <p>Offriamo la possibilità di trovare rapidamente sale attrezzate per eventi aziendali, 
          dotate di sistemi di proiezione, microfoni e impianto audio, connessione wifi, aria condizionata, servizio catering...
        </p>
      </div>
    </div>
  </div>
</div>

<!-- Third Grid -->
<div class="container-fluid py-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <h1>Concerti e Feste di Ballo</h1>
        <p>Per associazioni alla ricerca del luogo perfetto per un concerto o una festa di ballo con musica registrata o live,
          facilitiamo la ricerca di spazi unici per eventi indimenticabili.
        </p>
        </div>
        <div class="col-lg-4 d-flex justify-content-center">
        <i class="fa fa-music fa-5x my-auto aqua"></i>
      </div>
    </div>
  </div>
</div>

<?php
  include 'common/footer.php';
?>

</body>
</html>
