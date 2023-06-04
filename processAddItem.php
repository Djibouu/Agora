<?php
session_start();

if ((!isset($_SESSION["identifiant"]) && $_SESSION['type'] !== 'vendeur') || (!isset($_SESSION["identifiant"]) && $_SESSION['type'] !== 'admin')) {
    header("Location: deleteItem.php");
    exit();
}

$message = ""; // Message de succès ou d'erreur

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $database = "agora";
    $db_handle = mysqli_connect('localhost:3306', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);

    if ($db_found) {
        // Récupérer les valeurs du formulaire
        $nom = $_POST["item_name"];
        $categorie = $_POST["item_category"];
        $prix = $_POST["item_price"];
        $description = $_POST["item_description"];
        $imagePath = $_FILES["item_image"]["tmp_name"];
        $imageData = file_get_contents($imagePath);

        $stock = $_POST["item_stock"];; // Vous pouvez spécifier une valeur par défaut pour le stock
        if($_SESSION['type'] == 'vendeur'){
            $idVendeur = $_POST["item_seller_id"];

            // Préparer la requête d'insertion
            $sql = "INSERT INTO item (Categorie, Prix, Nom, Image, Description, Stock, idVendeur) VALUES ('$categorie', $prix, '$nom', ?, '$description', $stock, $idVendeur)";
            $stmt = mysqli_prepare($db_handle, $sql);
        }
        if($_SESSION['type'] == 'admin'){
            $idVendeur = $_POST["item_seller_id"];

            // Préparer la requête d'insertion
            $sql = "INSERT INTO item (Categorie, Prix, Nom, Image, Description, Stock, idAdmin) VALUES ('$categorie', $prix, '$nom', ?, '$description', $stock, $idVendeur)";
            $stmt = mysqli_prepare($db_handle, $sql);
        }

        if ($stmt) {
            // Lier les paramètres et insérer l'image
            mysqli_stmt_bind_param($stmt, "s", $imageData);
            mysqli_stmt_send_long_data($stmt, 0, $imageData);

            // Exécuter la requête
            mysqli_stmt_execute($stmt);

            // Vérifier si l'insertion a réussi
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $message = "L'item a été ajouté avec succès.";
            } else {
                $message = "Une erreur s'est produite lors de l'ajout de l'item.";
            }
        } else {
            $message = "Une erreur s'est produite lors de la préparation de la requête.";
        }
    } else {
        $message = "Une erreur s'est produite lors de la connexion à la base de données.";
    }

    mysqli_close($db_handle);
}
?>

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
                        <?php
                            
                            
                            if (isset($_SESSION["identifiant"])) {
                                
                                echo '<a href="notification.php" class="nav-link active" aria-current="page">Notifications</a>';
                                
                            } 
                        ?>
                    </li>
                    <li class="nav-item">
                        <?php
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
        <h1>Félicitations !</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mt-3">
                        <?php
                        if (!empty($message)) {
                            echo '<h3>' . $message . '</h3>';
                            if ($message == "L'item a été ajouté avec succès.") {
                                echo '<p>Merci d\'avoir ajouté un nouvel item à la boutique.</p>';
                            }
                        }
                        ?>
                    </div>
                    <div class="text-center mt-3">
                        <a href="addItem.php" class="btn btn-primary">Ajouter un autre item</a>
                    </div>
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
