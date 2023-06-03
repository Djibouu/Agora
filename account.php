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
if ($result->num_rows == 0) {
    $user_type = 'admin';
    $sql = "SELECT * FROM $user_type WHERE email = '$user_id'";
    $result = $conn->query($sql);
}

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">


    <style>
        
        header{
            margin-bottom: 4%;
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
<header>
    <nav class="navbar navbar-expand-xl bg-body-tertiary fixed-top py-lg-3">
          <div class="container-fluid">
            <a id="agoraButton" class="navbar-brand " href="home.php">Agora France</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto sm-2 sm-lg-0">
                <li class="nav-item">
                  <a href="shop.php"class="nav-link active" aria-current="page">Boutique</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page">Notifications</a>
                </li>
                </li>
                <li class="nav-item">
                  <?php
                      
                      $database = "agora";
                      $db_handle = mysqli_connect('localhost:3306', 'root', '');
                      $db_found = mysqli_select_db($db_handle, $database);
                      if (isset($_POST['delete_item'])) {
                        $itemIdToDelete = $_POST['item_id'];
                        $sqlDelete = "DELETE FROM panier WHERE idUser = {$_SESSION['id']} AND idItem = $itemIdToDelete";
                        mysqli_query($db_handle, $sqlDelete);                                                     
                      }
                
                      if (isset($_SESSION["identifiant"])) {
                        if ($_SESSION['type'] == 'acheteur') {
                          echo '<a href="panier.php" class="nav-link active" aria-current="page">Panier</a>';
                        }
                      } else {
                      }
                  ?>
                </li>
                <li class="nav-item">
                  <?php
                  if (isset($_SESSION["identifiant"])) {
                    echo '<a href="account.php" class="nav-link active" id="accountLink" aria-current="page">' . $_SESSION['identifiant'] . '</a>';
                  } else {
                    echo '<a href="#" class="nav-link active popup-link connexion" aria-current="page">Vous n\'êtes pas connecté</a>';
                  }
                  ?>
                </li>
              </ul>
            </div>
          </div>
        </nav>
    </header>
<body>
<br>
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
                if ($user_type == 'acheteur'){
                    echo '<div><strong>Adresse:</strong> ' . $row["Adresse"]. ', '. $row["Ville"]. ', ' . $row["Code_Postal"]."</div>";
                    echo '<div><strong>Solde:</strong> ' . $row["Solde"]. ' € </div>';
                    echo '<div><strong>Solde Cadeau:</strong> ' . $row["SoldeCadeau"]. ' € </div>';
                }
                if($user_type == 'admin'){
                    echo'<button onclick="location.href=\'deleteUser.php\'">gérer les utilisateurs</button>';
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
