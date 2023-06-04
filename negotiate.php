<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["identifiant"])) {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: login.php");
    exit();
}

// Récupérer les données du formulaire
$itemId = $_POST['item_id'];
$offerPrice = $_POST['offer_price'];

// Valider et traiter les données ici...
// Mettre à jour la base de données avec l'offre proposée pour l'article correspondant à $itemId

// Connexion à la base de données
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "agora";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mettre à jour l'offre et l'offrant dans la table "item"
$sql = "UPDATE item SET Offre = $offerPrice, Offrant = {$_SESSION['id']}, nbOffre = nbOffre + 1 WHERE id = $itemId";
if ($conn->query($sql) === TRUE) {
    // Succès de la mise à jour
    // Rediriger l'utilisateur vers la page du produit après la soumission du formulaire
    header("Location: product.php?id=" . $itemId);
    exit();
} else {
    // Erreur lors de la mise à jour
    echo "Erreur lors de la mise à jour de l'offre : " . $conn->error;
}

// Fermer la connexion
$conn->close();
?>
