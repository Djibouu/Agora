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
    <title>Shop</title>
    <style>
        .product-card {
            transition: transform 0.3s;
        }
        .product-card:hover {
            transform: scale(1.05);
        }
    </style>
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
    <br>



    <div class="container my-3">
        <div class="row">
            <div class="col-lg-12">
                <form method="POST" action="">
                    <div class="input-group">
                        <label class="input-group-text" for="category-filter">Filtrer par catégorie :</label>
                        <select class="form-select" id="category-filter" name="category">
                            <option value="all">Toutes les catégories</option>
                            <option value="direct">Direct</option>
                            <option value="negocier">Négocier</option>
                            <option value="enchere">Enchère</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Filtrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    


    <div class="container my-5 main-content">
        <div class="row">
            <?php
            // Connexion à la base de données
            $database = "agora";
            $db_handle = mysqli_connect('localhost:3306', 'root', '');
            $db_found = mysqli_select_db($db_handle, $database);

            // Récupérer la catégorie sélectionnée depuis le formulaire
            $categoryFilter = isset($_POST['category']) ? $_POST['category'] : 'all';
            





            if ($db_found) {
                // Récupérer la catégorie sélectionnée depuis le formulaire
                $categoryFilter = isset($_POST['category']) ? $_POST['category'] : 'all';
            
                // Construire la requête SQL en fonction de la catégorie sélectionnée
                $sql = "SELECT * FROM item";
                if ($categoryFilter !== 'all') {
                    $sql .= " WHERE Categorie = '$categoryFilter'";
                }
            
                // Exécuter la requête SQL
                $result = mysqli_query($db_handle, $sql);
            
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($product = mysqli_fetch_assoc($result)) {
                        $nom = $product['Nom'];
                        $prix = $product['Prix'];
                        $imageData = $product['Image'];
            
                        // Afficher chaque produit
                        echo '<div class="col-lg-4">';
                        echo '<div class="card product-card">';
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($imageData) . '" class="card-img-top" alt="Product Image">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $nom . ' - ' . $prix . ' €</h5>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    // Aucun produit trouvé dans la base de données
                    echo "Aucun produit trouvé.";
                }
            } else {
                // Erreur de connexion à la base de données
                echo "Erreur de connexion à la base de données.";
            }
            

            // Fermer la connexion à la base de données
            mysqli_close($db_handle);
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
