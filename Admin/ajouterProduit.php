<?php
    // Inclure le fichier de connexion à la base de données
    include '../include/connexion.php';

    // Récupérer les catégories depuis la base de données
    try {
        $stmt = $pdo->query('SELECT id_c, nom_c FROM categorie');
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        $categories = [];
    }

    // Récupérer les auteurs
    try {
        $stmt = $pdo->query('SELECT id_a, nomComplet FROM auteur');
        $auteurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        $auteurs = [];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nom boutique</title>
    <link rel="icon" type="image/png" href="../img/logo.png">
    <!-- Link Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <!-- Optional: Add your own styles for further customization -->
    <style>
        /* Add custom styles here if needed */
        body {
            padding: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2 class="text-center mb-4">Formulaire d'ajout de produit</h2>
        <div class="d-flex justify-content-center">
            <form action="../traitement/traitementProduit.php" method="post" enctype="multipart/form-data" style="width: 100%; max-width: 600px;">

                <div class="form-group">
                    <label for="titre" class="form-label">Titre :</label>
                    <input type="text" class="form-control" id="titre" name="titre" required>
                </div>

                <div class="form-group">
                    <label for="auteur" class="form-label">Auteur :</label>
                    <select class="form-control" id="auteur" name="auteur">
                        <?php foreach ($auteurs as $auteur): ?>
                            <option value="<?= htmlspecialchars($auteur['id_a']) ?>"><?= htmlspecialchars($auteur['nomComplet']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nbpage" class="form-label">Nombre de pages :</label>
                    <input type="text" class="form-control" id="nbpage" name="nbpage">
                </div>

                <div class="form-group">
                    <label for="langue" class="form-label">Langue :</label>
                    <input type="text" class="form-control" id="langue" name="langue">
                </div>

                <div class="form-group">
                    <label for="note" class="form-label">Note :</label>
                    <input type="text" class="form-control" id="note" name="note">
                </div>

                <div class="form-group">
                    <label for="prix" class="form-label">Prix :</label>
                    <input type="text" class="form-control" id="prix" name="prix">
                </div>

                <div class="form-group">
                    <label for="remise" class="form-label">Remise :</label>
                    <input type="text" class="form-control" id="remise" name="remise">
                </div>

                <div class="form-group">
                    <label for="qteS" class="form-label">Quantité en stock :</label>
                    <input type="text" class="form-control" id="qteS" name="qteS">
                </div>

                <div class="form-group">
                    <label for="editionn" class="form-label">Édition :</label>
                    <input type="text" class="form-control" id="editionn" name="editionn">
                </div>

                <div class="form-group">
                    <label for="datepublication" class="form-label">Date de publication :</label>
                    <input type="date" class="form-control" id="datepublication" name="datepublication">
                </div>

                <div class="form-group">
                    <label for="descriptionn" class="form-label">Description :</label>
                    <textarea class="form-control" id="descriptionn" name="descriptionn" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="inputImage" class="form-label">Image :</label>
                    <input type="file" class="form-control" id="inputImage" name="inputImage">
                </div>

                <div class="form-group">
                    <label for="categories" class="form-label">Catégories :</label><br>
                    <?php foreach ($categories as $categorie): ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="categorie<?= $categorie['id_c'] ?>" name="categories[]" value="<?= $categorie['id_c'] ?>">
                            <label class="form-check-label" for="categorie<?= $categorie['id_c'] ?>"><?= htmlspecialchars($categorie['nom_c']) ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button type="submit" class="btn btn-primary w-100" name="ajouter">Ajouter</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
