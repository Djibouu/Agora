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
    // Récupérer les articles de l'utilisateur actuel
    if ($_SESSION['type'] == 'vendeur') {
        $idVendeur = $_SESSION['id'];
        $sql = "SELECT * FROM item WHERE idVendeur = $idVendeur";
        $result = mysqli_query($db_handle, $sql);
    } elseif ($_SESSION['type'] == 'admin') {
        $idAdmin = $_SESSION['id'];
        $sql = "SELECT * FROM item";
        $result = mysqli_query($db_handle, $sql);
    }
} else {
    // Erreur de connexion à la base de données
    header("Location: addItemError.php");
    exit();
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
        <h1>Gérer les Articles</h1>
    </div>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (!empty($row['idVendeur'])) {
                $sql = "SELECT * FROM vendeur WHERE id = {$row['idVendeur']}";
                $result2 = mysqli_query($db_handle, $sql);
                $row2 = mysqli_fetch_assoc($result2);
                
            }
            
            elseif (!empty($row['idAdmin'])) {
                $sql = "SELECT * FROM admin WHERE id = {$row['idAdmin']}";
                $result2 = mysqli_query($db_handle, $sql);
                $row2 = mysqli_fetch_assoc($result2);
                
            } else {
                echo '<p class="card-text">Vendeur : Non disponible</p>';
            }
            echo '<div class="row justify-content-center">';
            echo    '<div class="col-lg-8">';
            echo        '<div class="card item-card" >';
            echo            '<div class="card-body">';
            echo                '<div class="row">';
            echo                    '<div class="col-md-3">';
            echo                        '<img src="data:image/jpeg;base64,'.base64_encode( $row['Image'] ).'" class="user-image"/>';
            echo                    '</div>';
            echo                    '<div class="col-md-9">';
            echo                        '<h5 class="card-title">' . $row["Nom"] . '</h5>';
            echo                        '<p class="card-title">Type de vente : ' . $row["Categorie"] . '</p>';
            echo                        '<p class="card-text">' . $row["Description"] . '</p>';
            echo                        '<p class="card-text">Prix : ' . $row["Prix"] . '</p>';
            echo                        '<p class="card-text">Stock : ' . $row["Stock"] . '</p>';
            if($_SESSION['type'] == 'admin'){
                echo                        '<p class="card-text">Vendeur : ' . $row2["Pseudo"] . '</p>';
            }
            echo                        '<form method="POST" action="processDeleteItem.php">';
            echo                            '<input type="hidden" name="item_id" value="' . $row["id"] . '">';
            echo                            '<button type="submit" class="btn btn-danger">Supprimer ce produit</button>';
            echo                        '</form>';
            echo                    '</div>';
            echo                '</div>';
            echo            '</div>';
            echo        '</div>';
            echo    '</div>';
            echo '</div>';
        }
    } else {
        echo '<div class="row justify-content-center">';
        echo    '<div class="col-lg-8">';
        echo        '<div class="card">';
        echo            '<div class="card-body">';
        echo                '<p class="card-text">Aucun article à afficher.</p>';
        echo            '</div>';
        echo        '</div>';
        echo    '</div>';
        echo '</div>';
    }
    ?>

</div>
</body><br><br>
<footer>
      &copy;2023 "Agora France", Tous droits réservés. | Conditions générales de vente | Politique de confidentialité | Mentions légales | <a style = "color:white"href="info.php">Contact</a>
    </footer>
</html>
