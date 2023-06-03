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
        });
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
                            <a class="nav-link active" aria-current="page">Notifications</a>
                        </li>
                        <li class="nav-item">
                            <?php
                                session_start();
                                
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
                                echo '<button class="btn btn-outline-primary btn-lg">Acheter maintenant</button>';
                                echo '</form>';
                            }

                            // ...

                            if ($categorie == "negocier" && $_SESSION['type'] == 'acheteur') {
                                echo '<button type="button" class="btn btn-outline-primary btn-lg">Negocier</button>';
                            }
                            if ($categorie == "enchere" && $_SESSION['type'] == 'acheteur') {
                                echo '<button type="button" class="btn btn-outline-primary btn-lg">Faire une offre</button>';
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
</body>

</html>
