<?php
include 'include/connexion.php';

// Récupération des critères de recherche
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Construction de la requête SQL avec des critères
$sql = "
    SELECT p.*, a.nomComplet, c.nom_c AS categorie_nom
    FROM produit p
    LEFT JOIN auteur a ON p.id_a = a.id_a
    LEFT JOIN prod_categ pc ON p.id_prod = pc.id_prod
    LEFT JOIN categorie c ON pc.id_c = c.id_c
    WHERE 1=1
";

$params = [];

if ($query !== '') {
    $sql .= " AND (p.titre LIKE :query OR a.nomComplet LIKE :query OR c.nom_c LIKE :query)";
    $params[':query'] = $query . '%';
}

// Préparation et exécution de la requête
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Erreur lors de l\'exécution de la requête : ' . $e->getMessage());
}
?>

<div class="tm-hero d-flex justify-content-center align-items-center" data-parallax="scroll" style="margin-top: 4%;">
    <form class="d-flex tm-search-form" method="GET" action="">
        <input class="form-control tm-search-input" type="search" name="query" placeholder="Chercher un livre, un auteur ou une categorie" aria-label="Search" value="<?= htmlspecialchars($query) ?>">
        <button class="btn btn-outline-success tm-search-btn" type="submit">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>

<div class="container-fluid tm-container-content mt-4">
    <div class="container mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <div class="row">
            <?php if (!empty($items)): ?>
                <?php foreach ($items as $item): ?>
                    <div class="col-md-3 mb-3">
                        <div class="card border-success">
                            <div class="card-body text-success">
                                <a href="#" class="view-more" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                   data-id="<?= htmlspecialchars($item['id_prod']) ?>"
                                   data-title="<?= htmlspecialchars($item['titre']) ?>"
                                   data-auteur="<?= htmlspecialchars($item['nomComplet']) ?>"
                                   data-img="uploads/<?= htmlspecialchars($item['img']) ?>"
                                   data-prix="<?= htmlspecialchars($item['prix']) ?>"
                                   data-nbpage="<?= htmlspecialchars($item['nbpage']) ?>"
                                   data-langue="<?= htmlspecialchars($item['langue']) ?>"
                                   data-editionn="<?= htmlspecialchars($item['editionn']) ?>"
                                   data-datepublication="<?= htmlspecialchars($item['datepublication']) ?>"
                                   data-descriptionn="<?= htmlspecialchars($item['descriptionn']) ?>"
                                   data-qteS="<?= htmlspecialchars($item['qteS']) ?>">
                                    <img src="uploads/<?= htmlspecialchars($item['img']) ?>" style="height: 380px;" class="card-img-top" alt="...">
                                    <h4 class="card-title text-center text-success" style="margin-top: 5px; margin-bottom: -5px;"><?= htmlspecialchars($item['titre']) ?></h4>
                                </a>
                            </div>
                            <div class="card-footer bg-transparent border-success">
                                Prix: <?= htmlspecialchars($item['prix']) ?> DH
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Aucun produit trouvé.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-2" id="exampleModalLabel">Détails :</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row tm-mb-30">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                            <img src="" alt="Image" class="img-fluid" id="modal-img">
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                            <div class="tm-bg-gray tm-video-details">
                                <div class="d-flex justify-content-between mb-4" style="font-size: 16px;">
                                    <div>
                                        <div class="mb-2">
                                            <span class="tm-text-gray-dark">Titre : </span>
                                            <span class="tm-text-primary" id="titre-modal"></span>
                                        </div>
                                        <div class="mb-2">
                                            <span class="tm-text-gray-dark">Auteur : </span>
                                            <span class="tm-text-white" id="auteurL"></span>
                                        </div>
                                        <div class="mb-2">
                                            <span class="tm-text-gray-dark">Categorie : </span>
                                            <span class="tm-text-white" id="categorie-modal"></span>
                                        </div>
                                    </div>
                                    <p class="mb-4" id="pageLang"></p>
                                </div>
                                <div class="mb-4">
                                    <h4 class="tm-text-gray-dark">Description :</h4>
                                    <p id="descriptionn" style="font-size: 12px;"></p>
                                </div>
                                <div class="mb-4 d-flex flex-wrap" style="font-size: 22px;">
                                    <div class="mr-4 mb-2">
                                        <span class="tm-text-gray-dark">Prix : </span>
                                        <span class="badge bg-info" id="prix"></span>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <form id="add-to-cart-form" method="POST" action="panier/add_to_cart.php">
                                        <input type="hidden" name="id_prod" id="product-id">
                                        <input type="hidden" name="qte" value="1">
                                        <button type="submit" class="btn btn-primary tm-btn-big">
                                            <i class="fa-solid fa-cart-plus" style="color: #EDE8E6;"></i>
                                            <span> Ajouter au panier </span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.view-more').forEach(function(element) {
        element.addEventListener('click', function() {
            var title = this.getAttribute('data-title');
            var img = this.getAttribute('data-img');
            var prix = this.getAttribute('data-prix');
            var auteur = this.getAttribute('data-auteur');
            var nbpage = this.getAttribute('data-nbpage');
            var langue = this.getAttribute('data-langue');
            var editionn = this.getAttribute('data-editionn');
            var datepublication = this.getAttribute('data-datepublication');
            var descriptionn = this.getAttribute('data-descriptionn');
            var idProd = this.getAttribute('data-id');

            document.getElementById('titre-modal').innerText = title;
            document.getElementById('modal-img').src = img;
            document.getElementById('prix').innerText = prix + ' DH';
            document.getElementById('auteurL').innerText = auteur;
            document.getElementById('pageLang').innerText = 'Nombres des pages : ' + nbpage + ' , Langue : ' + langue;
            document.getElementById('descriptionn').innerText = descriptionn;
            document.getElementById('categorie-modal').innerText = editionn;
            document.getElementById('product-id').value = idProd;
        });
    });
</script>
