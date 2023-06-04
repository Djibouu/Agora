

<!DOCTYPE html>
<html lang="en">
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
    
      <section id="hero" class="animate__animated animate__fadeInnahi">
        <h1>Bienvenue sur Agora France !</h1>
        <p>Le site n°1 des matériels de sécurité en France.</p>
        <div>
          <a href='shop.php'><button type="button" class="btn btn-outline-primary .btn-lg" >BOUTIQUE</button></a>
          <?php
                  if (isset($_SESSION["identifiant"])) {
                  } else {
                      echo '<a href=""></a><button type="button" class="btn btn-outline-secondary">CONNEXION</button></a>';
                  }
                  ?>
          
        </div>


      <!-- Pour la Pop up -->
      <div id="popup" class="popup">
        <span class="close">&times;</span>
        <h2>Connexion</h2>
        <form action="connexion.php" method="post">
          <input type="text" placeholder="Identifiant" name="identifiant">
          <input type="password" placeholder="Mot de passe" name="mot_de_passe">
          <button id="ConnexionButton" name="LogIn" type="submit" formaction="connexion.php">Connexion</button>
        </form>
        <button href="SingUp.php" id="createAccountButton" name="SingUp">Créer un compte</button>
      </div>
      <!-- Pour la Pop up -->

      </section>
      
      <section id="features">
      <div class="container text-center">
        <h2><u>Pour vous :</u></h2>
        <div class="row gx-5">
          <div class="col-md">
            <div class="pricing">
              <h3>Prix compétitifs ⭐</h3>
              <p>Nous proposons des gammes d'articles de qualité au meilleur prix.</p>
            </div>
          </div>
          <div class="col-md ">
            <div class="pricing">
              <h3>Assistance 24/24 🔊</h3>
              <p>Une question sur un article ? Un problème sur votre compte ?</p>
            </div>
          </div>
          <div class="col-md">
            <div class="pricing">
              <h3>Livraison sous 48h 📤</h3>
              <p>Votre commande arrivera toujours dans les meilleurs délais.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  

    <section id="pricings">
    <div class="container text-center">
      <?php
        // Informations de connexion à la base de données
        $database = "agora";
        $db_handle = mysqli_connect('localhost:3306', 'root', '');
        $db_found = mysqli_select_db($db_handle, $database);

        // Vérifier si la connexion a réussi
        if ($db_found) {
            $sql = "SELECT id FROM selectionjour";
            $result = mysqli_query($db_handle, $sql);
            $selected_items = array();

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $itemId = $row['id'];
                    $sql = "SELECT * FROM item WHERE id = '$itemId'";
                    $itemResult = mysqli_query($db_handle, $sql);
                    
                    if ($itemResult && mysqli_num_rows($itemResult) > 0) {
                        $item = mysqli_fetch_assoc($itemResult);
                        $selected_items[] = $item; // Ajouter le tableau associatif complet à $selected_items
                    }
                }
            }
        }
        ?>

      <h2><u>Séléction du jour</u></h2>
      <br>
      <div class="row gx-5">
      <?php foreach ($selected_items as $item): 
          $imageData = $item['Image']?>
          <div class="col-md">
            <a style = "color :black"href="product.php?id=<?php echo $item['id']; ?>"> <!-- Ici, nous avons ajouté le lien vers la page du produit -->
              <div class="pricing">
                <h3><?php echo $item['Nom']; ?></h3>
                <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($imageData) . '" class="img-fluid rounded-start" alt="Image">';?>
                <p>Prix: <?php echo $item['Prix']; ?></p>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
</section>


    <section id="meetuss">
      <div class="container">
        <h2><u>Notre histoire</u></h2>
        <div class="row">
          <div class="col">
              <p>Bienvenue sur Agora France, votre destination en ligne pour tout le <u>divers objets de toutes catégories</u>.</p>
              <p>Nous sommes fiers de vous offrir une sélection soigneusement choisie <u>d'articles spécialisés</u> pour répondre aux besoins uniques de chauque client.</p>
              <p>Chez Agora France, nous comprenons l'importance de fournir des produits de qualité et de se faire livrer en toute confiance.</p>
              <p>Notre équipe passionnée est composée d'experts de l'industrie qui sélectionnent <u>rigoureusement</u> chaque produit afin de garantir une <u>qualité supérieure et une expérience optimale</u>.</p>
          </div>
        </div>
    </section>
  
    <br><br>
    <footer>
      &copy;2023 "Agora France", Tous droits réservés. | Conditions générales de vente | Politique de confidentialité | Mentions légales | <a style = "color:white"href="info.php">Contact</a>
    </footer>
  <button id="back-to-top" class="back-to-top"> <b>↑</b></button>
  <script src="home.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>