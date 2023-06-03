
<!DOCTYPE html>
<html>
<head>
  <title>Form</title>
  <link rel="stylesheet" type="text/css" href="SingUp.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
</head>
<body>
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
                    session_start();
                    if (isset($_SESSION["identifiant"])) {
                        echo '<a href="panier.php" class="nav-link active" aria-current="page">Panier</a>';
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
      <br>
  <form id="myForm" class="container mt-5" action="SingUp2.php" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <select id="userType" name="userType" class="form-control">
        <option value="">Choisissez votre statut</option>
        <option value="vendeur">Vendeur</option>
        <option value="acheteur">Acheteur</option>
        </select>
    </div>
      
  

    <label for="nom" class="hidden">Nom:</label>
    <input type="text" id="nom" name="nom" class="hidden" required>

    <label for="prenom" class="hidden">Prenom:</label>
    <input type="text" id="prenom" name="prenom" class="hidden" required>

    <label for="email" class="hidden">Email:</label>
    <input type="email" id="email" name="email" class="hidden" required>

    <label for="password" class="hidden">Password:</label>
    <input type="password" id="password" name="password" class="hidden" required>

    <label for="pseudo" class="hidden">Pseudo:</label>
    <input type="text" id="pseudo" name="pseudo" class="hidden" required>
    
    <label for="adresse" class="hidden">Adresse:</label>
    <input type="text" id="adresse" name="adresse" class="hidden">
    
    <label for="ville" class="hidden">Ville:</label>
    <input type="text" id="ville" name="ville" class="hidden">

    <label for="codePostal" class="hidden">Code Postal:</label>
    <input type="text" id="codePostal" name="codePostal" class="hidden">

    <label for="pays" class="hidden">Pays:</label>
    <input type="text" id="pays" name="pays" class="hidden">

    <label for="typePaiement" class="hidden">Type de Paiement:</label>
    <input type="text" id="typePaiement" name="typePaiement" class="hidden">

    <label for="numeroCarte" class="hidden">Numero de Carte:</label>
    <input type="text" id="numeroCarte" name="numeroCarte" class="hidden">

    <label for="nomCarte" class="hidden">Nom de Carte:</label>
    <input type="text" id="nomCarte" name="nomCarte" class="hidden">

    <label for="dateExpiration" class="hidden">Date d'Expiration:</label>
    <input type="date" id="dateExpiration" name="dateExpiration" class="hidden">
    <br>
    <label for="codeCarte" class="hidden">Code de Carte:</label>
    <input type="text" id="codeCarte" name="codeCarte" class="hidden">

    <br><br>
    <label for="image" class="hidden">Image:</label>
    <input type="file" id="image" name="image" class="hidden" required>
    
    <br><br>
    <button type="submit" id="submitBtn" class="hidden">Submit</button>
  </form>
  <script src="SingUp.js"></script>
  <br>
  <br>
  <br>
</body>
</html>