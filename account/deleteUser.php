<?php
session_start();

$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "agora";

$conn = new mysqli($servername, $username, $password, $dbname);

// Requête pour récupérer tous les utilisateurs vendeur
$queryVendeurs = "SELECT * FROM vendeur";
$resultVendeurs = $conn->query($queryVendeurs);

// Requête pour récupérer tous les utilisateurs acheteur
$queryAcheteurs = "SELECT * FROM acheteur";
$resultAcheteurs = $conn->query($queryAcheteurs);

// Traitement du formulaire de suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['supprimer'])) {
        if (isset($_POST['utilisateurs']) && !empty($_POST['utilisateurs'])) {
            $utilisateursASupprimer = $_POST['utilisateurs'];

            // Supprimer les utilisateurs sélectionnés de la base de données
            foreach ($utilisateursASupprimer as $utilisateurId) {
                $utilisateurId = intval($utilisateurId);

                $querySupprimerVendeur = "DELETE FROM vendeur WHERE id = '$utilisateurId'";
                $resultSupprimerVendeur = $conn->query($querySupprimerVendeur);

                // Supprimer l'utilisateur acheteur
                $querySupprimerAcheteur = "DELETE FROM acheteur WHERE id = '$utilisateurId'";
                $resultSupprimerAcheteur = $conn->query($querySupprimerAcheteur);
            }
        }
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .supprimer {
            background-color: #ff0000;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .supprimer:hover {
            background-color: #cc0000;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Liste des utilisateurs</h1>

        <form method="POST" action="">
            <table>
                <tr>
                    <th></th>
                    <th>Pseudo</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Type de compte</th>
                </tr>
                <?php
                // Afficher les utilisateurs vendeur
                while ($rowVendeur = $resultVendeurs->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td><input type="checkbox" name="utilisateurs[]" value="' . $rowVendeur['id'] . '"></td>';
                    echo '<td>' . $rowVendeur['Nom'] . ' ' . $rowVendeur['Prenom'] . '</td>';
                    echo '<td>' . $rowVendeur['Pseudo'] . '</td>';
                    echo '<td>' . $rowVendeur['email'] . '</td>';
                    echo '<td>Vendeur</td>';
                    echo '</tr>';
                }

                // Afficher les utilisateurs acheteur
                while ($rowAcheteur = $resultAcheteurs->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td><input type="checkbox" name="utilisateurs[]" value="' . $rowAcheteur['id'] . '"></td>';
                    echo '<td>' . $rowAcheteur['Nom'] . ' ' . $rowAcheteur['Prenom'] . '</td>';
                    echo '<td>' . $rowAcheteur['Pseudo'] . '</td>';
                    echo '<td>' . $rowAcheteur['email'] . '</td>';
                    echo '<td>Acheteur</td>';
                    echo '</tr>';
                }
                ?>
            </table>

            <div class="button-container">
                <button class="supprimer" type="submit" name="supprimer">Supprimer les utilisateurs sélectionnés</button>
            </div>
        </form>
    </div>
</body>
</html>


