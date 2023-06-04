<?php
session_start();

if (!isset($_SESSION["identifiant"]) || $_SESSION['type'] == 'acheteur') {
    header("Location: home.php");
    exit();
}

$database = "agora";
$db_handle = mysqli_connect('localhost:3306', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);

if ($db_found) {
    if (isset($_POST['item_id'])) {
        $itemId = $_POST['item_id'];

        // Mettre à zéro Offrant, Offre et nbOffre dans l'article
        $sql = "UPDATE item SET Offrant = 0, Offre = 0, nbOffre = 0 WHERE id = $itemId";
        $result = mysqli_query($db_handle, $sql);

        if ($result) {
            header("Location: notification.php");
        } else {
            echo "Erreur lors du déclin de l'offre.";
        }
    } else {
        echo "ID de l'article non spécifié.";
    }
} else {
    echo "Database not found";
}

// Fermer la connexion
mysqli_close($db_handle);
?>
