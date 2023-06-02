<?php
session_start();

$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "agora";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['identifiant'];
$user_type = 'acheteur';
$sql = "SELECT * FROM acheteur WHERE email = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    $user_type = 'vendeur';
    $sql = "SELECT * FROM vendeur WHERE email = '$user_id'";
    $result = $conn->query($sql);
}

?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .user-details {
            margin: 0 auto;
            max-width: 600px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f8f8f8;
            display: flex;
            justify-content: space-between;
        }
        .user-info {
            margin-right: 20px;
        }
        .user-info div {
            margin-bottom: 10px;
        }
        .user-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
        .logout {
            margin-top: 20px;
            text-align: center;
        }
        .logout button {
            padding: 10px 20px;
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="user-details">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="user-info">';
                echo '<div><strong>Welcome, ' . $row["Pseudo"]. "</strong></div>";
                echo '<div><strong>Type de Compte:</strong> ' . $user_type. "</div>";
                echo '<div><strong>Nom:</strong> ' . $row["Nom"]. "</div>";
                echo '<div><strong>Prenom:</strong> ' . $row["Prenom"]. "</div>";
                echo '<div><strong>Email:</strong> ' . $row["email"]. "</div>";
                if (array_key_exists("Adresse", $row)){
                    echo '<div><strong>Adresse:</strong> ' . $row["Adresse"]. ', '. $row["Ville"]. ', ' . $row["Code_Postal"]."</div>";
                }
                echo '</div>';
                echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['Image'] ).'" class="user-image"/>';
                break;
            }
        } else {
            echo "No results";
        }
        ?>
        <div class="logout">
            <button onclick="location.href='logout.php'">Déconnexion</button>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>
