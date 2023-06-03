<?php
session_start();

// Connexion à la base de données
$database = "agora";
$db_handle = mysqli_connect('localhost:3306', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);

if ($db_found) {
    $action = isset($_POST['action']) ? $_POST['action'] : null;
    if ($action === 'buy_now') {
        // Acheter maintenant
        echo "Prout";
    } elseif ($action === 'add_to_cart') {
        // Ajouter au panier
        // Récupérer les données POST
        $userId = isset($_POST['user_id']) ? $_POST['user_id'] : null;
        $itemId = isset($_POST['item_id']) ? $_POST['item_id'] : null;
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;

        // Vérifier si les données nécessaires sont présentes
        if ($userId && $itemId && $quantity) {
            // Vérifier si l'article est déjà dans le panier de l'utilisateur
            $sql = "SELECT * FROM panier WHERE idUser = $userId AND idItem = $itemId";
            $result = mysqli_query($db_handle, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                // L'article est déjà dans le panier, ajouter les quantités
                $row = mysqli_fetch_assoc($result);
                $existingQuantity = $row['Quantite'];
                $newQuantity = $existingQuantity + $quantity;

                $updateSql = "UPDATE panier SET Quantite = $newQuantity WHERE idUser = $userId AND idItem = $itemId";
                $updateResult = mysqli_query($db_handle, $updateSql);

                if ($updateResult) {
                    
                } else {
                    echo "Erreur lors de la mise à jour de la quantité de l'article dans le panier.";
                }
            } else {
                // L'article n'est pas encore dans le panier, l'ajouter
                $insertSql = "INSERT INTO panier (idUser, idItem, Quantite) VALUES ($userId, $itemId, $quantity)";
                $insertResult = mysqli_query($db_handle, $insertSql);

                
            }
        } else {
            echo "Veuillez vous connecter pour ajouter l'article au panier.";
            exit;
        }
    }
} else {
    // Si la BDD n'existe pas
    echo "Database not found";
}

// Fermer la connexion
mysqli_close($db_handle);
?>
