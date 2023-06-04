<?php
session_start();

if (!isset($_SESSION["identifiant"]) || ($_SESSION['type'] !== 'vendeur' && $_SESSION['type'] !== 'admin')) {
    header("Location: accessDenied.php");
    exit();
}

$database = "agora";
$db_handle = mysqli_connect('localhost:3306', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);

if ($db_found) {
    if (isset($_POST["item_id"])) {
        $item_id = $_POST["item_id"];

        // Supprimer l'article de la table item
        $sql_delete = "DELETE FROM item WHERE id = $item_id";
        $result_delete = mysqli_query($db_handle, $sql_delete);

        if ($result_delete) {
            $message = "L'article a été supprimé avec succès.";
        } else {
            $message = "Une erreur s'est produite lors de la suppression de l'article.";
        }
    } else {
        $message = "L'article n'a pas été spécifié.";
    }
} else {
    // Erreur de connexion à la base de données
    $message = "Erreur de connexion à la base de données.";
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
    <style>
        .user-image {
            width: 100%;
            max-width: 150px;
        }
        
        .item-card {
            margin-bottom: 20px;
        }
    </style>
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
        <h1>Résultat de la suppression</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <p class="card-text"><?php echo $message; ?></p>
                    <a href="deleteItem.php" class="btn btn-primary">Retour à la gestion des articles</a>
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
