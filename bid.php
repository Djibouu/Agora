<?php
session_start();

// Connexion à la base de données
$database = "agora";
$db_handle = mysqli_connect('localhost:3306', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);

if ($db_found) {

        // Placer une enchère
        // Récupérer les données POST
        $userId = $_SESSION['id'] ;
        $itemId = isset($_POST['item_id']) ? $_POST['item_id'] : null;
        $bidAmount = isset($_POST['offer_price']) ? $_POST['offer_price'] : null;

        $sql = "SELECT * FROM acheteur WHERE id = $userId";
        $resultAcheteur = mysqli_query($db_handle, $sql);
        $Acheteur = mysqli_fetch_assoc($resultAcheteur);
        // Vérifier si les données nécessaires sont présentes
        if ($userId && $itemId && $bidAmount) {
            // Récupérer l'enchère actuelle pour l'item
            $sql = "SELECT * FROM item WHERE id = $itemId";
            $result = mysqli_query($db_handle, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                // L'article existe, vérifier si l'enchère est plus haute
                $row = mysqli_fetch_assoc($result);
                $currentBid = $row['Prix'];

                if ($bidAmount > $currentBid) {
                    if($bidAmount <= ($Acheteur['Solde'] + $Acheteur['SoldeCadeau'])){
                        // L'enchère est plus haute, la mettre à jour
                        $updateSql = "UPDATE item SET Prix = $bidAmount, Offrant = $userId WHERE id = $itemId";
                        $updateResult = mysqli_query($db_handle, $updateSql);
                        if ($updateResult) {
                            $_SESSION['bid_message'] = "Enchère placée avec succès!";
                        
                        } 
                    }
                    else{
                        $_SESSION['bid_message'] = "Votre solde doit être supérieur au dernier prix pour pouvoir enchérir.";
                    }
                    
                } else {
                    $_SESSION['bid_message'] = "Votre offre doit être supérieur au dernier prix pour pouvoir enchérir.";
                }
                // Rediriger vers resultBid.php
                header('Location: resultBid.php');
                exit;
            } else {
                echo "L'article n'existe pas.";
            }
        } else {
            echo "Veuillez vous connecter pour placer une enchère.";
            exit;
        }
    

} else {
    // Si la BDD n'existe pas
    echo "Database not found";
}

// Fermer la connexion
mysqli_close($db_handle);
?>
