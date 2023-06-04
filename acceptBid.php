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
    if (isset($_POST['item_id'])) {
        $itemId = $_POST['item_id'];
        
        // Récupérer les informations de l'article
        $sql = "SELECT * FROM item WHERE id = $itemId";
        $result = mysqli_query($db_handle, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $item = mysqli_fetch_assoc($result);
            
            // Récupérer l'offrant
            $offrantId = $item['Offrant'];

            // Récupérer le solde de l'offrant
            $sql = "SELECT * FROM acheteur WHERE id = $offrantId";
            $result = mysqli_query($db_handle, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $offrant = mysqli_fetch_assoc($result);

                // Déduire le prix du solde de l'offrant
                $prix = $item['Prix'];
                $nouveauSoldeCadeau = $offrant['SoldeCadeau'] - $prix;
                            if($nouveauSoldeCadeau < 0){
                                $newSolde = $offrant['Solde'] + $nouveauSoldeCadeau;
                                $nouveauSoldeCadeau = 0;
                            }
                            else{
                                $newSolde = $offrant['Solde'];
                            }
                // Mettre à jour le solde de l'offrant dans la base de données
                $sql = "UPDATE acheteur SET Solde = $newSolde WHERE id = $offrantId";
                $result = mysqli_query($db_handle, $sql);

                $sql = "UPDATE acheteur SET SoldeCadeau = $nouveauSoldeCadeau WHERE id = $offrantId";
                $result2 = mysqli_query($db_handle, $sql);

                if ($result && $result2) {
                    $to = $offrant['email'];
                    $subject = "Confirmation de commande";
                    $message = "Votre commande a été acceptée par le vendeur.\n Vous êtes maintenant l'heureux propriétaire d'un  {$item['Name']} , il sera livré dans 24 à 48h, du lundi au samedi (hors jours fériés).";
                    $headers = "From: Agora France";
                    mail($to, $subject, $message, $headers);

                    // Féliciter le vendeur
                    header('Location: notification.php');
                    
                    //supprimer l'article de la vente
                    $sql_delete = "DELETE FROM item WHERE id = {$item['id']}";
                    $result_delete = mysqli_query($db_handle, $sql_delete);
                    if($result_delete){
                        echo "L'article a été supprimé de la vente.";
                    }
                    
                } else {
                    // Erreur lors de la mise à jour du solde
                    echo "Erreur lors de la mise à jour du solde de l'offrant.";
                }
            } else {
                // Offrant introuvable dans la base de données
                echo "Offrant introuvable.";
            }
        } else {
            // Article introuvable dans la base de données
            echo "Article introuvable.";
        }
    } else {
        // ID de l'article non spécifié
        echo "ID de l'article non spécifié.";
    }
} else {
    // Erreur de connexion à la base de données
    echo "Database not found";
}

// Fermer la connexion
mysqli_close($db_handle);
?>
