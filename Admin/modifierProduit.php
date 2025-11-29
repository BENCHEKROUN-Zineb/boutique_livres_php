<?php
include '../include/connexion.php';

// Récupération des données de l'auteur et des catégories
try {
    $auteursStmt = $pdo->query('SELECT id_a, nomComplet FROM auteur');
    $auteurs = $auteursStmt->fetchAll(PDO::FETCH_ASSOC);

    $categoriesStmt = $pdo->query('SELECT id_c, nom_c FROM categorie');
    $categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
    exit;
}

if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);

    try {
        $stmt = $pdo->prepare('SELECT p.*, a.nomComplet FROM produit p JOIN auteur a on a.id_a = p.id_a WHERE id_prod = ?');
        $stmt->execute([$id]);
        $produit = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$produit) {
            echo "Produit introuvable.";
            exit;
        }
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        exit;
    }
} else {
    echo "ID de produit non spécifié.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Produit</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Modifier Produit</h1>
        <form action="../traitement/traitementProduit.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_prod" value="<?= htmlspecialchars($produit['id_prod']) ?>">

            <div class="form-group">
                <label for="titre">Titre</label>
                <input type="text" class="form-control" id="titre" name="titre" value="<?= htmlspecialchars($produit['titre']) ?>" required>
            </div>

            <div class="form-group">
                <label for="id_a">Auteur</label>
                <select class="form-control" id="id_a" name="id_a" required>
                    <?php foreach ($auteurs as $auteur): ?>
                        <option value="<?= htmlspecialchars($auteur['id_a']) ?>" <?= $auteur['id_a'] == $produit['id_a'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($auteur['nomComplet']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="nbpage">Nombre de pages</label>
                <input type="number" class="form-control" id="nbpage" name="nbpage" value="<?= htmlspecialchars($produit['nbpage']) ?>" required>
            </div>

            <div class="form-group">
                <label for="langue">Langue</label>
                <input type="text" class="form-control" id="langue" name="langue" value="<?= htmlspecialchars($produit['langue']) ?>" required>
            </div>

            <div class="form-group">
                <label for="editionn">Édition</label>
                <input type="text" class="form-control" id="editionn" name="editionn" value="<?= htmlspecialchars($produit['editionn']) ?>" required>
            </div>

            <div class="form-group">
                <label for="datepublication">Date de publication</label>
                <input type="text" class="form-control" id="datepublication" name="datepublication" value="<?= htmlspecialchars($produit['datepublication']) ?>" required>
            </div>

            <div class="form-group">
                <label for="descriptionn">Description</label>
                <textarea class="form-control" id="descriptionn" name="descriptionn" rows="3" required><?= htmlspecialchars($produit['descriptionn']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="note">Note</label>
                <input type="number" class="form-control" id="note" name="note" value="<?= htmlspecialchars($produit['note']) ?>" required>
            </div>

            <div class="form-group">
                <label for="prix">Prix</label>
                <input type="number" class="form-control" id="prix" name="prix" value="<?= htmlspecialchars($produit['prix']) ?>" required>
            </div>

            <div class="form-group">
                <label for="remise">Remise</label>
                <input type="number" class="form-control" id="remise" name="remise" value="<?= htmlspecialchars($produit['remise']) ?>" required>
            </div>

            <div class="form-group">
                <label for="qteS">Quantité en stock</label>
                <input type="number" class="form-control" id="qteS" name="qteS" value="<?= htmlspecialchars($produit['qteS']) ?>" required>
            </div>

            <div class="form-group">
                <label for="img">Image</label>
                <input type="file" class="form-control-file" id="img" name="img">
                <img src="../uploads/<?= htmlspecialchars($produit['img']) ?>" alt="Image actuelle" class="img-thumbnail mt-2" style="max-width: 100px;">
            </div>

            <div class="form-group">
                <label>Catégories</label>
                <div class="form-check">
                    <?php foreach ($categories as $categorie): ?>
                        <input class="form-check-input" type="checkbox" id="categorie_<?= htmlspecialchars($categorie['id_c']) ?>" name="categories[]" value="<?= htmlspecialchars($categorie['id_c']) ?>">
                        <label class="form-check-label" for="categorie_<?= htmlspecialchars($categorie['id_c']) ?>">
                            <?= htmlspecialchars($categorie['nom_c']) ?>
                        </label><br>
                    <?php endforeach; ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block" name="modifier">Modifier</button>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
