<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Agora</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-xl bg-body-tertiary fixed-top py-lg-3">
            <div class="container-fluid">
                <a id="agoraButton" class="navbar-brand" href="\GitVisio\Agora-1\home.php">Agora France</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto sm-2 sm-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Boutique</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Notifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Panier</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Votre Compte</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container my-5">
    <div class="row">
        <div class="col-lg-6">
            <?php
            // Connexion à la base de données
            $database = "agora";
            $db_handle = mysqli_connect('localhost:3306', 'root', '');
            $db_found = mysqli_select_db($db_handle, $database);

            if ($db_found) {
                // Récupérer le produit à partir de son ID
                // $productId = $_GET['id']; // Récupérer l'ID du produit depuis l'URL ou une autre source
                $productId = 1;
                $sql = "SELECT * FROM item WHERE ID = $productId";
                $result = mysqli_query($db_handle, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    $product = mysqli_fetch_assoc($result);
                    $categorie = $product['Categorie'];
                    $prix = $product['Prix'];
                    $nom = $product['Nom'];
                    $imageData = $product['Image'];
                    $video = $product['Video'];
                    $description = $product['Description'];
                    $stock = $product['Stock'];

                    // Afficher les informations du produit
                    echo '<h1>' . $nom . '</h1>';
                    // echo '<p>Catégorie: ' . $categorie . '</p>';
                    echo '<p>Prix: ' . $prix . '€</p>';
                    echo '<p>Stock: ' . $stock . '</p>';
                    echo '<p>Description: ' . $description . '</p>';
                    if($categorie=="direct"){
                        echo '<button type="button" class="btn btn-outline-primary .btn-lg"" >Acheter maintenant</button>';
                        echo '<button type="button" class="btn btn-outline-secondary" >Ajouter au panier</button>';
                    }
                    if($categorie=="negocier"){
                        echo '<button type="button" class="btn btn-outline-primary .btn-lg"" >Negocier</button>';
                    }
                    if($categorie=="enchere"){
                        echo '<button type="button" class="btn btn-outline-primary .btn-lg"" >Faire une offre</button>';
                    }
                } else {
                    // Aucun produit trouvé avec cet ID
                    echo "Produit introuvable";
                }
            } else {
                //si la BDD n'existe pas
                echo "Database not found";
            }

            // Fermer la connexion
            mysqli_close($db_handle);
            ?>
        </div>
        <div class="col-lg-6">
            <?php
            // Afficher l'image du produit
            echo '<img src="data:image/jpeg;base64,' . base64_encode($imageData) . '" alt="Image" class="border img-fluid">';
            ?>
        </div>
    </div>
</div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
