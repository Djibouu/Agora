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
                        if ($_SESSION['type'] == 'acheteur') {
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
            <h1>Ticket de commande</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
              <div class="card">
                <div class="card-body">
                  <?php
                    $database = "agora";
                    $db_handle = mysqli_connect('localhost:3306', 'root', '');
                    $db_found = mysqli_select_db($db_handle, $database);

                    if ($db_found) {
                      if (isset($_SESSION['id'])) {
                        $userId = $_SESSION['id'];
                        $totalPrice = 0;

                        // Fetch items from the cart
                        $sql = "SELECT * FROM panier WHERE idUser = $userId";
                        $result = mysqli_query($db_handle, $sql);

                        if ($result && mysqli_num_rows($result) > 0) {
                          while ($row = mysqli_fetch_assoc($result)) {
                            $itemId = $row['idItem'];
                            $quantite = $row['Quantite'];

                            // Fetch item details
                            $sqlItem = "SELECT * FROM item WHERE id = $itemId";
                            $resultItem = mysqli_query($db_handle, $sqlItem);

                            if ($resultItem && mysqli_num_rows($resultItem) > 0) {
                              $item = mysqli_fetch_assoc($resultItem);

                              // Item details
                              $categorie = $item['Categorie'];
                              $prix = $item['Prix'];
                              $nom = $item['Nom'];
                              $imageData = $item['Image'];
                              $description = $item['Description'];

                              // Calculate total price
                              $totalPrice += ($prix * $quantite);

                              // Display item details
                              echo '<div class="mb-4">';
                              echo   '<div class="row">';
                              echo     '<div class="col-md-4">';
                              echo       '<img src="data:image/jpeg;base64,' . base64_encode($imageData) . '" class="img-fluid rounded-start" alt="Image">';
                              echo     '</div>';
                              echo     '<div class="col-md-8">';
                              echo       '<div class="card-body">';
                              echo         '<h5 class="card-title">' . $nom . '</h5>';
                              echo         '<p class="card-text">Description: ' . $description . '</p>';
                              echo         '<ul class="list-group list-group-flush">';
                              echo           '<li class="list-group-item">Catégorie: ' . $categorie . '</li>';
                              echo           '<li class="list-group-item">Prix: ' . $prix . '€</li>';
                              echo           '<li class="list-group-item">Quantité: ' . $quantite . '</li>';
                              echo         '</ul>';
                              echo       '</div>';
                              echo     '</div>';
                              echo   '</div>';
                              echo '</div>';
                            } else {
                              echo "Détails de l'article introuvables";
                            }
                          }
                        } else {
                          echo "Votre panier est vide.";
                        }

                        // Check if the user has enough balance to pay
                        $sqlUser = "SELECT * FROM acheteur WHERE id = $userId";
                        $resultUser = mysqli_query($db_handle, $sqlUser);

                        if ($resultUser && mysqli_num_rows($resultUser) > 0) {
                          $user = mysqli_fetch_assoc($resultUser);
                          $solde = $user['Solde'] + $user['SoldeCadeau'];

                          if ($solde >= $totalPrice) {
                            // Payment successful
                            echo '<div class="text-center">';
                            echo   '<h3>Paiement réussi!</h3>';
                            echo   '<h4>Montant payé: ' . $totalPrice . '€</h4>';
                            echo '</div>';

                            // Deduct the payment amount from the user's balance
                            $newSoldeCadeau = $user['SoldeCadeau'] - $totalPrice;
                            if($newSoldeCadeau < 0){
                                $newSolde = $user['Solde'] + $newSoldeCadeau;
                                $newSoldeCadeau = 0;
                            }
                            else{
                                $newSolde = $user['Solde'];
                            }
                            
                            $sqlUpdateSolde = "UPDATE acheteur SET Solde = $newSolde WHERE id = $userId";
                            mysqli_query($db_handle, $sqlUpdateSolde);
                            $sqlUpdateSolde = "UPDATE acheteur SET SoldeCadeau = $newSoldeCadeau WHERE id = $userId";
                            mysqli_query($db_handle, $sqlUpdateSolde);
                            if($item['Stock'] > 1){
                              $sqlUpdateSolde = "UPDATE item SET Stock = Stock-1 WHERE id = {$item['id']}";
                              mysqli_query($db_handle, $sqlUpdateSolde);
                            }
                            else{ 
                              $sqlClearCart = "DELETE FROM item WHERE id = {$item['id']}";
                              mysqli_query($db_handle, $sqlClearCart);
                            }
                            // Clear the user's cart
                            $sqlClearCart = "DELETE FROM panier WHERE idUser = $userId";
                            mysqli_query($db_handle, $sqlClearCart);
                          } else {
                            // Insufficient balance
                            echo '<div class="text-center">';
                            echo   '<h3>Solde insuffisant!</h3>';
                            echo   '<p>Veuillez recharger votre compte pour effectuer le paiement.</p>';
                            echo '</div>';
                          }
                        } else {
                          echo "Utilisateur introuvable";
                        }
                      } else {
                        echo "Vous devez être connecté pour effectuer le paiement.";
                      }
                    } else {
                      echo "Database not found";
                    }

                    mysqli_close($db_handle);
                  ?>
                </div>
              </div>
            </div>
        </div>
    </div>
</body><br><br>
<footer>
      &copy;2023 "Agora France", Tous droits réservés. | Conditions générales de vente | Politique de confidentialité | Mentions légales | <a style = "color:white"href="info.php">Contact</a>
    </footer>
</html>
