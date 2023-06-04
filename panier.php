<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
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
                      
                      $database = "agora";
                      $db_handle = mysqli_connect('localhost:3306', 'root', '');
                      $db_found = mysqli_select_db($db_handle, $database);
                      
                      if (isset($_POST['delete_item'])) {
                        $itemIdToDelete = $_POST['item_id'];
                        $sqlDelete = "DELETE FROM panier WHERE idUser = {$_SESSION['id']} AND idItem = $itemIdToDelete";
                        mysqli_query($db_handle, $sqlDelete);                                                     
                      }
                      
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
    <body>
    
    <div class="container">
        <div class="text-center mt-5">
            <h1>Votre Panier</h1>
        </div>

        <div class="row justify-content-center">
            <?php
                // Connexion à la base de données
                $database = "agora";
                $db_handle = mysqli_connect('localhost:3306', 'root', '');
                $db_found = mysqli_select_db($db_handle, $database);

                if ($db_found) {
                    if (isset($_SESSION['id'])) {
                        $userId = $_SESSION['id'];
                        $totalPrice = 0;
                        
                        // Your code to fetch items
                        $sql = "SELECT * FROM panier WHERE idUser = $userId";
                        $result = mysqli_query($db_handle, $sql);
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $itemId = $row['idItem'];
                                $quantite = $row['Quantite'];
                                // Your code to fetch item details
                                $sqlItem = "SELECT * FROM item WHERE id = $itemId";
                                $resultItem = mysqli_query($db_handle, $sqlItem);

                                if ($resultItem && mysqli_num_rows($resultItem) > 0) {
                                    $item = mysqli_fetch_assoc($resultItem);

                                    // Variables for item details
                                    $categorie = $item['Categorie'];
                                    $prix = $item['Prix'];
                                    $nom = $item['Nom'];
                                    $imageData = $item['Image'];
                                    $description = $item['Description'];
                                    
                                    // Calculate total price
                                    $totalPrice += ($prix * $quantite);

                                    // Displaying the item details
                                    echo '<div class="col-lg-8 mb-4">';
                                    echo    '<div class="card">';
                                    echo        '<div class="row g-0">';
                                    echo            '<div class="col-md-4">';
                                    echo                '<img src="data:image/jpeg;base64,' . base64_encode($imageData) . '" class="img-fluid rounded-start" alt="Image">';
                                    echo            '</div>';
                                    echo            '<div class="col-md-8">';
                                    echo            '<div class="card-body d-flex flex-column">';
                                    echo            '<h5 class="card-title">' . $nom . '</h5>';
                                    echo            '<p class="card-text">Description: ' . $description . '</p>';
                                    echo            '<ul class="list-group list-group-flush mb-auto">';
                                    echo                '<li class="list-group-item">Catégorie: ' . $categorie . '</li>';
                                    echo                '<li class="list-group-item">Prix: ' . $prix . '€</li>';
                                    echo                '<li class="list-group-item">Quantité: ' . $quantite . '</li>';
                                    echo            '</ul>';
                                    echo     '<div class="mt-auto text-end">';
                                    echo         '<form method="POST" action="panier.php">';
                                    echo             '<input type="hidden" name="item_id" value="' . $itemId . '">';
                                    echo             '<button type="submit" name="delete_item" class="btn btn-danger">Supprimer du panier</button>';
                                    echo         '</form>';
                                    echo     '</div>';
                                    echo '</div>';
                                
                                    echo            '</div>';
                                    echo        '</div>';
                                    echo    '</div>';
                                    echo '</div>';
                                } else {
                                    echo "Détails de l'article introuvables";
                                }
                            }
                        } else {
                            echo "Votre panier est vide.";
                        }
                        if($totalPrice > 0 ){
                          // Display total price
                          echo '<div class="text-center mt-4">';
                          echo     '<h3>Sous Total: ' . $totalPrice . '€</h3>';
                          echo     '<form method="POST" action="panier.php">';
                          echo         '<div class="mb-3">';
                          echo             '<label for="promoCode" class="form-label">Code Promo:</label>';
                          echo             '<div class="d-flex">';
                          echo                '<input type="text" class="form-control input-small" id="promoCode" name="promo_code">';
                          echo                '<button type="submit" class="btn btn-primary">Valider</button>';
                          echo             '</div>';
                          echo         '</div>';
                          echo     '</form>';
                          echo '</div>';

                          // Check promo code
                          if (isset($_POST['promo_code'])) {
                              $promoCode = $_POST['promo_code'];
                              // Check if promo code is valid
                              if ($promoCode === "CODE123") {
                                  // Apply promo code and update the user's cadeau balance
                                  $updateCadeauQuery = "UPDATE acheteur SET SoldeCadeau = SoldeCadeau + 100 WHERE id = $userId";
                                  mysqli_query($db_handle, $updateCadeauQuery);
                                  echo '<div class="text-center mt-3">';
                                  echo     '<div class="alert alert-success" role="alert">';
                                  echo         'Code promo appliqué avec succès. Vous avez reçu 100€ sur votre solde cadeau.';
                                  echo     '</div>';
                                  echo '</div>';
                              } else {
                                  echo '<div class="text-center mt-3">';
                                  echo     '<div class="alert alert-danger" role="alert">';
                                  echo         'Le code promo est invalide.';
                                  echo     '</div>';
                                  echo '</div>';
                              }
                          }
                          
                          // Button to validate and pay
                          echo '<div class="text-center mt-3">';
                          echo     '<form method="POST" action="checkout.php">';
                          echo         '<button type="submit" class="btn btn-primary">Valider et Payer</button>';
                          echo     '</form>';
                          echo '</div>';
                        }
                    } else {
                        echo "Vous devez être connecté pour voir votre panier.";
                    }
                } else {
                    // Si la BDD n'existe pas
                    echo "Database not found";
                }
                
                mysqli_close($db_handle);
            ?>
        </div>
    </div>
</body><br><br><br><br>
<footer>
      &copy;2023 "Agora France", Tous droits réservés. | Conditions générales de vente | Politique de confidentialité | Mentions légales | <a style = "color:white"href="info.php">Contact</a>
    </footer>
</html>
