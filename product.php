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

    <style>
        .product-image {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
    </style>
    <!-- product.php -->
    <script>
        $(document).ready(function() {
            $('#add-to-cart-btn').click(function(e) {
                e.preventDefault();

                // Récupérer les valeurs des attributs de données
                var userId = $(this).closest('form').find('[name="user_id"]').val();
                var itemId = $(this).closest('form').find('[name="item_id"]').val();
                var quantity = $(this).closest('form').find('[name="quantity"]').val();

                // Faire la requête AJAX
                $.ajax({
                    url: 'add_to_cart.php',
                    type: 'post',
                    data: {
                        'action': 'add_to_cart',
                        'user_id': userId,
                        'item_id': itemId,
                        'quantity': quantity
                    },

                    success: function(result) {
                        // Changer le texte du bouton et ajouter l'icône
                        $('#add-to-cart-btn').html('Ajouté au panier <i class="fas fa-check"></i>');
                        $('#add-to-cart-btn').prop('disabled', true);
                        $('#cart-success-message').text(result);
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur lors de l\'ajout du produit au panier: ' + error);
                    }
                });
            });
            $('#add-to-selection-btn').click(function(e) {
                e.preventDefault();

                // Récupérer les valeurs des attributs de données
                var userId = $(this).closest('form').find('[name="user_id"]').val();
                var itemId = $(this).closest('form').find('[name="item_id"]').val();
                var quantity = $(this).closest('form').find('[name="quantity"]').val();

                // Faire la requête AJAX
                $.ajax({
                    url: 'add_to_cart.php',
                    type: 'post',
                    data: {
                        'action': 'add_to_cart',
                        'user_id': userId,
                        'item_id': itemId,
                        'quantity': quantity
                    },

                    success: function(result) {
                        // Changer le texte du bouton et ajouter l'icône
                        $('#add-to-selection-btn').html('Ajouté à la sélection <i class="fas fa-check"></i>');
                        $('#add-to-selection-btn').prop('disabled', true);
                        
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur lors de l\'ajout du produit au panier: ' + error);
                    }
                });
            });
        });
        function showBidForm() {
            document.getElementById("bid-form").style.display = "block";
        }

        function showNegotiateForm() {
        <?php
        session_start();
        $database = "agora";
        $db_handle = mysqli_connect('localhost:3306', 'root', '');
        $db_found = mysqli_select_db($db_handle, $database);

        if ($db_found) {
            // Récupérer le produit à partir de son ID
            $productId = isset($_GET['id']) ? $_GET['id'] : null;

            if ($productId) {
                $sql = "SELECT nbOffre FROM item WHERE id = $productId";
                $result = mysqli_query($db_handle, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    $item = mysqli_fetch_assoc($result);
                    $nbOffre = $item['nbOffre'];

                    if ($nbOffre < 5) {
                        echo 'document.getElementById("negotiate-form").style.display = "block";';
                        
                    } else {
                        echo 'alert("Le nombre maximal d\'offres a été atteint.");';
                        $sql = "UPDATE item SET Offrant = 0, Offre = 0 WHERE id = $productId";
                        $result2 = mysqli_query($db_handle, $sql);
                    }
                }
            }
        }
        ?>
    }
        
        
    

    </script>


    <title>Agora</title>
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
            <div class="col-lg-6">
                <?php
                // Connexion à la base de données
                $database = "agora";
                $db_handle = mysqli_connect('localhost:3306', 'root', '');
                $db_found = mysqli_select_db($db_handle, $database);

                if ($db_found) {
                    // Récupérer le produit à partir de son ID
                    $productId = isset($_GET['id']) ? $_GET['id'] : null;

                    if ($productId) {
                        $sql = "SELECT * FROM item WHERE id = $productId";
                        $result = mysqli_query($db_handle, $sql);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $product = mysqli_fetch_assoc($result);
                            $categorie = $product['Categorie'];
                            $prix = $product['Prix'];
                            $nom = $product['Nom'];
                            $imageData = $product['Image'];
                            $video = $product['Video'];
                            $description = $product['Description'];
                            $stock = $product['Stock'];

                            // Afficher les informations du produit
                            echo '<h1>' . $nom . '</h1>';
                            echo '<p>Prix: ' . $prix . '€</p>';
                            echo '<p>Stock: ' . $stock . '</p>';
                            echo '<p>Description: ' . $description . '</p>';

                            // ...

                            if ($categorie == "direct" && $_SESSION['type'] == 'acheteur') {
                                echo '<form>';
                                if (isset($_SESSION["id"])) {
                                    echo '<input type="hidden" name="user_id" value="' . $_SESSION['id'] . '">';
                                }
                                
                                echo '<input type="hidden" name="item_id" value="' . $productId . '">';
                                echo '<div class="input-group mb-3">';
                                echo '<input type="number" name="quantity" class="form-control" placeholder="Quantité" min="1" max="' . $stock . '">';
                                echo '<button id="add-to-cart-btn" class="btn btn-outline-secondary">Ajouter au panier</button>';
                                echo '</div>';
                                
                                echo '</form>';
                            }
                            if ($_SESSION['type'] == 'admin') {
                                echo '<form>';
                                if (isset($_SESSION["id"])) {
                                    echo '<input type="hidden" name="user_id" value="' . $_SESSION['id'] . '">';
                                }
                                echo '<a id="add-to-selection-btn" class="btn btn-primary" onclick="afficherMessage()">Ajouter à la sélection du jour</a>';
                                echo '</form>';
                            }
                            
                            echo '<script>
                                function afficherMessage() {</script>';
                                    $countQuery = "SELECT COUNT(*) AS count FROM selectionjour";
                                    $countResult = mysqli_query($db_handle, $countQuery);
                                    $countRow = mysqli_fetch_assoc($countResult);
                                    $currentCount = $countRow['count'];

                                    if ($currentCount < 4) {
                                        $addQuery = "INSERT INTO selectionjour (id) VALUES ($productId)";
                                        $addResult = mysqli_query($db_handle, $addQuery);
                                    }
                                    
                            '<script>}</script>';

                            // ...

                            if ($categorie == "negocier" && $_SESSION['type'] == 'acheteur') {
                                echo '<div id="negotiate-form" style="display: none;">';
                                echo '<h3>Négocier le prix</h3>';
                                echo '<form id="negotiate-price-form" action="negotiate.php" method="post">';
                                echo '<input type="hidden" name="item_id" value="' . $productId . '">';
                                echo '<label for="offer-price">Prix proposé :</label>';
                                echo '<input type="number" name="offer_price" id="offer-price" step="1" required>';
                                echo '<br>';
                                echo '<button type="submit" class="btn btn-primary">Envoyer</button>';
                                echo '</form>';
                                echo '</div>';
                            
                                echo '<button type="button" class="btn btn-outline-primary btn-lg" onclick="showNegotiateForm()">Négocier</button>';
                            }
                            if ($categorie == "enchere" && $_SESSION['type'] == 'acheteur') {
                                $userId = $_SESSION["id"];
                                // Récupérer le solde de l'utilisateur
                                $sql = "SELECT Solde FROM acheteur WHERE id = $userId";
                                $userResult = mysqli_query($db_handle, $sql);
                                $user = mysqli_fetch_assoc($userResult);
                                $userBalance = $user['Solde'];
                                if ($userBalance > $prix) {
                                    echo '<div id="bid-form" style="display: none;">';
                                    echo '<h3>Enchérir</h3>';
                                    echo '    <form id="bid-price-form" action="bid.php" method="post">';
                                    echo '        <input type="hidden" name="item_id" value="' . $productId . '">';
                                    echo '        <input type="hidden" name="user_id" value="' . $_SESSION['id'] . '">';
                                    echo '        <label for="offer-price">Prix proposé :</label>';
                                    echo '        <input type="number" name="offer_price" id="offer-price" step="1" required>';
                                    echo '        <br>';
                                    echo '     <button type="submit" class="btn btn-primary">Envoyer</button>';
                                    echo ' </form>';
                                    
                                    echo '</div>';
                                    echo '<button type="button" class="btn btn-outline-primary btn-lg" onclick="showBidForm()">Enchérir</button>';
                                } else {
                                    echo '<p>Votre solde est insuffisant pour enchérir sur cet article.</p>';
                                }
                            }
                            
                        } else {
                            // Aucun produit trouvé avec cet ID
                            echo "Produit introuvable";
                        }
                    } else {
                        // Aucun ID de produit fourni
                        echo "ID de produit non spécifié";
                    }
                } else {
                    // Si la BDD n'existe pas
                    echo "Database not found";
                }

                // Fermer la connexion
                mysqli_close($db_handle);
                ?>
            </div>
            <div class="col-lg-6">
                <?php
                // Afficher l'image du produit avec une classe CSS pour définir la taille
                echo '<img src="data:image/jpeg;base64,' . base64_encode($imageData) . '" alt="Image" class="border img-fluid product-image">';
                ?>
            </div>
        </div>
    </div>
    <div id="cart-success-message"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
</body><br><br>
<footer>
      &copy;2023 "Agora France", Tous droits réservés. | Conditions générales de vente | Politique de confidentialité | Mentions légales | <a style = "color:white"href="info.php">Contact</a>
    </footer>
</html>
