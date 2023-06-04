<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Agora</title>
</head>

<body>
<header>
        <nav class="navbar navbar-expand-xl bg-body-tertiary fixed-top py-lg-3">
          <div class="container-fluid">
            <a id="agoraButton" class="navbar-brand " href="home.php">Agora France</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto sm-2 sm-lg-0">
                <li class="nav-item">
                  <a href="shop.php"class="nav-link active" aria-current="page">Boutique</a>
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
                      } else {
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

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-12">
                <h2>Résultat de l'enchère</h2>
                <?php
                    
                    // Utiliser le même message que dans bid.php
                    if(isset($_SESSION['bid_message'])){
                        echo '<p>' . $_SESSION['bid_message'] . '</p>';
                    }
                ?>
                <a href="shop.php" class="btn btn-primary">Retour à la boutique</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
</body><br><br>
<footer>
      &copy;2023 "Agora France", Tous droits réservés. | Conditions générales de vente | Politique de confidentialité | Mentions légales | <a style = "color:white"href="info.php">Contact</a>
    </footer>
</html>
