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
        <h1>Ajouter un Produit</h1>
    </div>

    <div class="row justify-content-center">
        <?php
        if ((isset($_SESSION["identifiant"]) && $_SESSION['type'] == 'vendeur') || isset($_SESSION["identifiant"]) && $_SESSION['type'] == 'admin') {
            echo '<div class="col-lg-8">';
            echo    '<div class="card">';
            echo        '<div class="card-body">';
            echo            '<form method="POST" action="processAddItem.php" enctype="multipart/form-data">';
            echo                '<div class="mb-3">';
            echo                    '<label for="itemName" class="form-label">Nom du Produit:</label>';
            echo                    '<input type="text" class="form-control" id="itemName" name="item_name" required>';
            echo                '</div>';
            echo                '<div class="mb-3">';
            echo                    '<label for="itemCategory" class="form-label">Catégorie:</label>';
            echo                    '<select class="form-control" id="itemCategory" name="item_category" required>';
            echo                        '<option value="direct">Direct</option>';
            echo                        '<option value="enchere">Enchère</option>';
            echo                        '<option value="negocier">Négociation</option>';
            echo                    '</select>';
            echo                '</div>';
            echo                '<div class="mb-3">';
            echo                    '<label for="itemPrice" class="form-label">Prix:</label>';
            echo                    '<input type="number" class="form-control" id="itemPrice" name="item_price" step="0.01" required>';
            echo                '</div>';
            echo                '<div class="mb-3">';
            echo                    '<label for="itemStock" class="form-label">Stock:</label>';
            echo                    '<input type="number" class="form-control" id="itemStock" name="item_stock" required>';
            echo                '</div>';
            echo                '<div class="mb-3">';
            echo                    '<label for="itemDescription" class="form-label">Description:</label>';
            echo                    '<textarea class="form-control" id="itemDescription" name="item_description" rows="3" required></textarea>';
            echo                '</div>';
            echo                '<div class="mb-3">';
            echo                    '<label for="itemImage" class="form-label">Image:</label>';
            echo                    '<input type="file" class="form-control" id="itemImage" name="item_image" required>';
            echo                '</div>';
            echo                '<input type="hidden" name="item_seller_id" value="' . $_SESSION['id'] . '">';
            echo                '<button type="submit" class="btn btn-primary">Ajouter</button>';
            echo            '</form>';
            echo        '</div>';
            echo    '</div>';
            echo '</div>';
        } else {
            echo '<div class="text-center mt-4">';
            echo    '<h3>Vous n\'avez pas les autorisations nécessaires pour accéder à cette page.</h3>';
            echo '</div>';
        }
        ?>
    </div>
</div>
</body><br><br>
<footer>
      &copy;2023 "Agora France", Tous droits réservés. | Conditions générales de vente | Politique de confidentialité | Mentions légales | <a style = "color:white"href="info.php">Contact</a>
    </footer>
</html>
