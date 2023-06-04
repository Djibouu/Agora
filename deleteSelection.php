<?php
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "agora";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Suppression des données de la table "selectionjour"
$sql = "TRUNCATE TABLE selectionjour";

if ($conn->query($sql) === TRUE) {
    echo "La sélection du jour a été supprimée avec succès.";
} else {
    echo "Erreur lors de la suppression de la sélection du jour : " . $conn->error;
}

// Fermeture de la connexion à la base de données
$conn->close();
?>
