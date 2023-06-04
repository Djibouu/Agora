<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    
    <title>Agora</title>

    <style>
    

      #map {
        width: 100%;
        height: 400px;
        margin-top: 20px;
      }
    </style>
  </head>

  <body>
    <header>
      <nav class="navbar navbar-expand-xl bg-body-tertiary fixed-top py-lg-3">
        <div class="container-fluid">
          <a id="agoraButton" class="navbar-brand" href="home.php">Agora France</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto sm-2 sm-lg-0">
              <li class="nav-item">
                <a href="shop.php" class="nav-link active" aria-current="page">Boutique</a>
              </li>
              <li class="nav-item">
                <?php
                  session_start();

                  if (isset($_SESSION["identifiant"])) {
                    echo '<a href="notification.php" class="nav-link active" aria-current="page">Notifications</a>';
                  } 
                ?>
              </li>
              <li class="nav-item">
                <?php
                  if (isset($_SESSION["identifiant"])) {
                    if($_SESSION['type'] == 'acheteur'){
                      echo '<a href="panier.php" class="nav-link active" aria-current="page">Panier</a>';
                    }
                  }
                ?>
              </li>
              <li class="nav-item">
                <?php
                  if (isset($_SESSION["identifiant"])) {
                    echo '<a href="account.php" class="nav-link active" id="accountLink" aria-current="page">' . $_SESSION['identifiant'] . '</a>';
                  } else {
                    echo '<a href="#" class="nav-link active popup-link connexion" aria-current="page">Vous n\'êtes pas connecté</a>';
                  }
                ?>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <div style="max-width: 600px; margin-left: auto; margin-right: auto; display: block;">
    <h1>Contactez-nous</h1>

    <h2>Informations de contact :</h2>
    <p>Entreprise : <strong>AgoraFrance</strong></p>
    <p>Adresse : <strong>10 Rue Sextius Michel, 75015 Paris</strong></p>
    <p>Téléphone : <strong>02 01 01 01 01</strong></p>
    <p>Email : <strong>AgoraFranceOfficiel@gmail.com</strong></p>

    <h2>Localisation :</h2>
    <div id="map" class="mx-auto" style="max-width: 600px;"></div> <!-- Limiting the map's width and centering it -->
  </div>

    <script>
      // Intégration de la carte Google Maps
      function initMap() {
        // Coordonnées de l'entreprise
        var companyLocation = {lat: 48.8510273, lng: 2.2885712}; // Remplacez avec les coordonnées de votre entreprise

        // Options de la carte
        var mapOptions = {
          zoom: 15, // Niveau de zoom (de 1 à 20)
          center: companyLocation // Centre de la carte
        };

        // Création de la carte
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);

        // Marqueur de l'entreprise
        var marker = new google.maps.Marker({
          position: companyLocation,
          map: map,
          title: 'Votre entreprise' // Remplacez avec le nom de votre entreprise
        });
      }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=qsdgqsdgqsdfg&callback=initMap" async defer></script>
    <!-- Remplacez VOTRE_CLE_API par votre propre clé d'API Google Maps -->
  </body><br><br>
  <footer>
      &copy;2023 "Agora France", Tous droits réservés. | Conditions générales de vente | Politique de confidentialité | Mentions légales | <a style = "color:white"href="info.php">Contact</a>
    </footer>
</html>
