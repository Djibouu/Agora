<?php
// Démarrer une session
session_start();

// Informations de connexion à la base de données
$database = "agora";
$db_handle = mysqli_connect('localhost:3306', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);

// Vérifier si la connexion a réussi
if ($db_found) {
    // Récupérer les données soumises par le formulaire
    $identifiant = $_POST["identifiant"];
    $motDePasse = $_POST["mot_de_passe"];

    // Vérifier les informations de connexion dans la base de données
    $sql = "SELECT * FROM vendeur WHERE email = '$identifiant' AND Password = '$motDePasse'";
    $result = mysqli_query($db_handle, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Informations de connexion correctes, enregistrer l'identifiant de l'utilisateur dans une variable de session
        $_SESSION["identifiant"] = $identifiant;
        $sql= "SELECT id FROM vendeur WHERE email = '{$_SESSION["identifiant"]}'";
        $result = mysqli_query($db_handle, $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            $_SESSION["id"] = $row['id'];
            $_SESSION["type"] = 'vendeur';
        }

        // Rediriger l'utilisateur vers la page d'accueil
        header("Location: home.php");
        exit;
    } else {
        $sql = "SELECT * FROM acheteur WHERE email = '$identifiant' AND Password = '$motDePasse'";
        $result = mysqli_query($db_handle, $sql);
        
        if (mysqli_num_rows($result) == 1) {
            // Informations de connexion correctes, enregistrer l'identifiant de l'utilisateur dans une variable de session
            $_SESSION["identifiant"] = $identifiant;
            $sql= "SELECT id FROM acheteur WHERE email = '{$_SESSION["identifiant"]}'";
            $result = mysqli_query($db_handle, $sql);
            if ($row = mysqli_fetch_assoc($result)) {
                $_SESSION["id"] = $row['id'];
                $_SESSION["type"] = 'acheteur';
            }

            // Rediriger l'utilisateur vers la page d'accueil
            header("Location: home.php");
            exit;
        } else {
            $sql = "SELECT * FROM admin WHERE email = '$identifiant' AND Password = '$motDePasse'";
            $result = mysqli_query($db_handle, $sql);
            if (mysqli_num_rows($result) == 1){
                $_SESSION["identifiant"] = $identifiant;
                $sql= "SELECT id FROM admin WHERE email = '{$_SESSION["identifiant"]}'";
                $result = mysqli_query($db_handle, $sql);
                if ($row = mysqli_fetch_assoc($result)) {
                    $_SESSION["id"] = $row['id'];
                    $_SESSION["type"] = 'admin';
                }

            }else{
                echo '
                    <script>
                        if (confirm("Identifiant ou mot de passe incorrect.")) {
                            window.location.href = "home.php";
                        } 
                        else{
                            window.location.href = "home.php";
                        }
                    </script>';
            }
            
            
        }

        
        
    }
} else {
    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
}
echo '<script>window.location.href = "home.php";</script>';

// Fermer la connexion à la base de données
mysqli_close($db_handle);
?>
