<?php
session_start();

if (!isset($_SESSION["user"])) {
  header("location:index.php");
  return;
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>LaMantia - Home</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <!-- TODO: Trova una nuova favicon -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Restaurantly - v3.3.0
  * Template URL: https://bootstrapmade.com/restaurantly-restaurant-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Top Bar ======= -->
  <div id="topbar" class="d-flex align-items-center sticky-top">
    <div class="container d-flex justify-content-center justify-content-md-between">

      <div class="contact-info d-flex align-items-center">
        <!--
        <i class="bi bi-phone d-flex align-items-center"><span>+1 5589 55488 55</span></i>
      -->
        <i class="bi bi-clock d-flex align-items-center ms-4"><span> Mar-Dom: 12.00 - 22.00</span></i>
      </div>

      <!--
      <div class="languages d-none d-md-flex align-items-center">
        <ul>
          <li>En</li>
          <li><a href="#">De</a></li>
        </ul>
      </div>
    -->
    </div>
  </div>

  <!-- ======= Header ======= -->
  <header id="header" class="sticky-top d-flex align-items-cente">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-lg-between">

      <h1 class="logo me-auto me-lg-0"><a href="index.php">LaMantia</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.php" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <?php
      if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
      ?>
        <a href="logout.php" class="book-a-table-btn">Logout</a>
      <?php
      }
      ?>
      <!--<a href = "#book-a-table" class="book-a-table-btn scrollto d-none d-lg-flex">Book a table</a> -->

    </div>
  </header><!-- End Header -->

  <section id="payment-section" class="d-flex justify-content-center">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 d-flex justify-content-start">
          <h2 class="mb-3">Conferma la tua prenotazione</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-8">
          <div class="row">
            <div class="col-3">
              <h3 class="confirm-payment">Giorno e ora:</h3>
            </div>
            <div class="col-3">
              <p id="data"></p>
            </div>
            <div class="col-4">
            </div>

          </div>

          <div class="row">
            <div class="col-3">
              <h3 class="confirm-payment">Telefono:</h3>
            </div>
            <div class="col-3">
              <p id="telefono"></p>
            </div>
            <div class="col-4">
            </div>
          </div>

          <div class="row">
            <div class="col-3">
              <h3 class="confirm-payment">Servizio:</h3>
            </div>
            <div class="col-3">
              <p id="servizio"></p>
            </div>
            <div class="col-4"></div>

          </div>

          <div class="row">
            <div class="col-3">
              <h3 class="confirm-payment">N. di persone:</h3>
            </div>
            <div class="col-3">
              <p id="persone"></p>
            </div>
            <div class="col-4"></div>
          </div>

          <div class="row">
            <div class="col-3">
              <h3 class="confirm-payment">Note:</h3>
            </div>
            <div class="col-3">
              <p id="note"></p>
            </div>
            <div class="col-4"></div>

          </div>

          <div class="row">
            <div class="col-3">
              <h3 class="confirm-payment">Luogo:</h3>
            </div>
            <div class="col-3">
              <p id="indirizzo"></p>
            </div>
            <div class="col-4"></div>
          </div>
        </div>
        <div class="col p-3">
          <div id="paypal-button-container"></div>
        </div>
      </div>
      <div class="mb-3">
        <div class="sent-payment">La tua prenotazione è stata effettuata! Chiama per ulteriori informazioni o ritorna alla home.</div>
        <a href="index.php" class="home-btn justify-content-center">Home</a>
      </div>
    </div>
  </section>
  <!-- Script Paypal API -->
  <script src="https://www.paypal.com/sdk/js?client-id=AY7aAfew0L4yha9Uihrw0tqORdnPRpLaSokGVo-nYozreGlfQS-tUNXC67AkV3tkV8fq7Ll0CAK_ayo3&currency=EUR"></script>

  <script>
    document.querySelector('.sent-payment').classList.remove('d-block');
    document.querySelector('.home-btn').classList.remove('d-block');

    document.querySelector("#data").innerHTML = localStorage.getItem("data");
    document.querySelector("#telefono").innerHTML = localStorage.getItem("telefono");
    document.querySelector("#servizio").innerHTML = localStorage.getItem("servizio") + " (€" + localStorage.getItem("prezzo") + ")";
    document.querySelector("#persone").innerHTML = localStorage.getItem("persone");
    document.querySelector("#note").innerHTML = localStorage.getItem("note");
    document.querySelector("#indirizzo").innerHTML = localStorage.getItem("indirizzo");

    paypal.Buttons({
      createOrder: function(data, actions) {
        // This function sets up the details of the transaction, including the amount and line item details.
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: localStorage.getItem("prezzo")
            }
          }]
        });
      },
      onApprove: function(data, actions) {
        // This function captures the funds from the transaction.
        return actions.order.capture().then(function(details) {
          document.querySelector("#paypal-button-container").style.display = 'none';
          document.querySelector('.sent-payment').classList.add('d-block');
          document.querySelector(".home-btn").classList.add("d-block");
          localStorage.clear();
        });
      },
      onCancel: function(data) {
        fetch("elimina_prenotazione.php", {
          method: 'POST',
          body: "data=" + localStorage.getItem("data"),
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          }
        }).then(response => {

          if (response.ok) {
            alert('Cancellato!');
            return response.text();
          }
        }).then(data => {
          if (data.trim() == "OK") {
            window.location.replace("index.php");
          } else {
            throw new Error(data);
          }
        }).catch(error => {
          console.log(error)
        });
      },

      onError: function(err) {
        alert(err);

        fetch("elimina_prenotazione.php", {
          method: 'POST',
          body: "data=" + localStorage.getItem("data"),
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          }
        }).then(response => {
          if (response.ok) {
            window.location.replace("index.php");
          }
        });
      }
    }).render('#paypal-button-container');
    //This function displays Smart Payment Buttons on your web page.
  </script>
</body>



</html>