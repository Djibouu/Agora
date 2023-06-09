

<?php
// Récupérer les valeurs du formulaire
$userType = $_POST['userType'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$password = $_POST['password'];
$pseudo = $_POST['pseudo'];
$image = $_FILES['image']['tmp_name']; // Chemin temporaire de l'image téléchargée
$adresse = $_POST['adresse'];
$ville = $_POST['ville'];
$codePostal = $_POST['codePostal'];
$pays = $_POST['pays'];
$typePaiement = $_POST['typePaiement'];
$numeroCarte = $_POST['numeroCarte'];
$nomCarte = $_POST['nomCarte'];
$dateExpiration = $_POST['dateExpiration'];
$codeCarte = $_POST['codeCarte'];

// Connexion à la base de données
$database = "agora";
$db_handle = mysqli_connect('localhost:3306', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);

if ($db_found) {
    // Vérifier le type d'utilisateur
    if ($userType === "acheteur") {
        // Insérer les données dans la table "acheteur"
        $sql = "INSERT INTO acheteur (Nom, Prenom, email, Password, Pseudo, Adresse, Ville, Code_Postal, Pays, Type_de_Payement, Numero_Carte, Nom_Carte, Date_Expritation, Code_Carte, Image) 
                VALUES ('$nom', '$prenom', '$email', '$password', '$pseudo', '$adresse', '$ville', '$codePostal', '$pays', '$typePaiement', '$numeroCarte', '$nomCarte', '$dateExpiration', '$codeCarte', ?)";
        $stmt = mysqli_prepare($db_handle, $sql);

        // Lire le contenu de l'image
        $imageData = file_get_contents($image);

        // Lier le contenu de l'image au paramètre de la requête
        mysqli_stmt_bind_param($stmt, "s", $imageData);

        // Exécuter la requête
        mysqli_stmt_execute($stmt);
        
    } elseif ($userType === "vendeur") {
        // Insérer les données dans la table "vendeur"
        $sql = "INSERT INTO vendeur (Pseudo, Password, email, Nom, Prenom, Image) 
                VALUES ('$pseudo', '$password', '$email', '$nom', '$prenom', ?)";
        $stmt = mysqli_prepare($db_handle, $sql);

        // Lire le contenu de l'image
        $imageData = file_get_contents($image);

        // Lier le contenu de l'image au paramètre de la requête
        mysqli_stmt_bind_param($stmt, "s", $imageData);

        // Exécuter la requête
        mysqli_stmt_execute($stmt);
        
    } else {
        // Type d'utilisateur invalide
        die("Type d'utilisateur invalide");
    }
    header('Location:home.php');
} else {
    //si le BDD n'existe pas
    echo "Database not found";
}

// Fermer la connexion
mysqli_close($db_handle);
?>