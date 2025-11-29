<style>
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        cursor: pointer;
    }

    .card a {
        text-decoration: none;
        color: inherit;
    }
</style>

<?php
    include 'include/connexion.php';

    // Initialisation des variables avec vérification empty
    $query = isset($_GET['query']) && !empty($_GET['query']) ? $_GET['query'] : '';
    $minp = isset($_GET['minp']) && !empty($_GET['minp']) ? intval($_GET['minp']) : 0;
    $maxp = isset($_GET['maxp']) && !empty($_GET['maxp']) ? intval($_GET['maxp']) : PHP_INT_MAX;
    $annee = isset($_GET['annee']) && !empty($_GET['annee']) ? intval($_GET['annee']) : 0;
    $nbpage = isset($_GET['nbpage']) && !empty($_GET['nbpage']) ? intval($_GET['nbpage']) : 0;
    $langue = isset($_GET['langue']) && !empty($_GET['langue']) ? $_GET['langue'] : '';
    $remise = isset($_GET['remise']) && !empty($_GET['remise']) ? intval($_GET['remise']) : 0;

    // Déterminer l'action : recherche ou filtrage
    $isFilter = isset($_GET['filtre']);

    // Requête pour obtenir les langues distinctes
    $sqlLangues = "SELECT DISTINCT langue FROM produit WHERE langue IS NOT NULL AND langue <> ''";
    $stmtLangues = $pdo->query($sqlLangues);
    $langues = $stmtLangues->fetchAll(PDO::FETCH_ASSOC);

    // Construction de la requête SQL pour la recherche
    $sqlSearch = "
        SELECT p.*, a.nomComplet, c.nom_c AS categorie_nom
        FROM produit p
        LEFT JOIN auteur a ON p.id_a = a.id_a
        LEFT JOIN prod_categ pc ON p.id_prod = pc.id_prod
        LEFT JOIN categorie c ON pc.id_c = c.id_c
        WHERE 1=1
    ";

    $params = [];

    if ($query !== '') {
        $sqlSearch .= " AND (p.titre LIKE :query OR a.nomComplet LIKE :query OR c.nom_c LIKE :query OR p.prix LIKE :query)";
        $params[':query'] = $query . '%';
    }

    // Construction de la requête SQL pour le filtrage
    $sqlFilter = "
    SELECT p.*, a.nomComplet, c.nom_c AS categorie_nom
    FROM produit p
    LEFT JOIN auteur a ON p.id_a = a.id_a
    LEFT JOIN prod_categ pc ON p.id_prod = pc.id_prod
    LEFT JOIN categorie c ON pc.id_c = c.id_c
    WHERE 1=1 ";
    $para = [];

    if ($minp > 0) {
        $sqlFilter .= " AND p.prix >= :minp";
        $para[':minp'] = $minp;
    }
    if ($maxp < PHP_INT_MAX) {
        $sqlFilter .= " AND p.prix <= :maxp";
        $para[':maxp'] = $maxp;
    }
    if ($annee > 0) {
        $sqlFilter .= " AND YEAR(p.datepublication) = :annee";
        $para[':annee'] = $annee;
    }
    if ($nbpage > 0) {
        $sqlFilter .= " AND p.nbpage = :nbpage";
        $para[':nbpage'] = $nbpage;
    }
    if (!empty($langue)) {
        $sqlFilter .= " AND p.langue = :langue";
        $para[':langue'] = $langue;
    }
    if ($remise > 0) {
        $sqlFilter .= " AND p.remise >= :remise";
        $para[':remise'] = $remise;
    }

    // Exécution de la requête en fonction de l'action
    try {
        if ($isFilter) {
            $stmt = $pdo->prepare($sqlFilter);
            $stmt->execute($para);
        } else {
            $stmt = $pdo->prepare($sqlSearch);
            $stmt->execute($params);
        }
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('Erreur lors de l\'exécution de la requête : ' . $e->getMessage());
    }
?>

<div class="tm-hero d-flex justify-content-center align-items-center" data-parallax="scroll" style="margin-top: 60px;">
    <div class="d-flex align-items-center">
        <!-- Formulaire de recherche -->
        <form class="d-flex tm-search-form me-3" method="GET" action="index.php">
            <input type="hidden" name="page" value="dashboardClient">
            <input class="form-control tm-search-input" type="search" name="query" placeholder="Chercher un livre, un auteur ou une categorie" aria-label="Search" value="<?= htmlspecialchars($query) ?>">
            <button class="btn btn-outline-success tm-search-btn" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <!-- Formulaire de filtrage -->
        <nav>
            <ul class="navbar-nav" style="flex-direction: row; align-items: center;">
                <li class="nav-item nav-cart m-0" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Filtrer" style="list-style: none;">
                    <div class="dropdown">
                        <a href="#" class="btn btn-outline-primary tm-search-btn dropdown-toggle d-flex align-items-center justify-content-center" data-bs-toggle="dropdown" aria-expanded="false" style="width: 70px; text-decoration: none; color: #fff; background-color: #0AB4B4;">
                            <i class="fa-solid fa-filter fa-lg"></i>
                        </a>
                        <form class="dropdown-menu p-3" style="width: 200px;" method="GET" action="index.php">
                            <input type="hidden" name="page" value="dashboardClient">
                            <div class="mb-3">
                                <label for="minp" class="form-label">Min Prix :</label>
                                <input type="number" class="form-control form-control-sm" id="minp" name="minp" style="padding: 0 10px">
                            </div>
                            <div class="mb-3">
                                <label for="maxp" class="form-label">Max Prix :</label>
                                <input type="number" class="form-control form-control-sm" id="maxp" name="maxp" style="padding: 0 10px">
                            </div>
                            <div class="mb-3">
                                <label for="annee" class="form-label">Annee de publication :</label>
                                <input type="number" class="form-control form-control-sm" id="annee" name="annee" style="padding: 0 10px">
                            </div>
                            <div class="mb-3">
                                <label for="nbpage" class="form-label">Nombre de Page :</label>
                                <input type="number" class="form-control form-control-sm" id="nbpage" name="nbpage" style="padding: 0 10px">
                            </div>
                            <div class="mb-3">
                                <label for="langue" class="form-label">Langue :</label>
                                <select class="form-select form-select-sm" aria-label="Small select example" id="langue" name="langue" style="padding: 0 10px">
                                    <option value="" selected>----</option>                                
                                    <!-- Boucle pour les langues -->
                                    <?php foreach ($langues as $lang): ?>
                                        <option value="<?= htmlspecialchars($lang['langue']) ?>" <?= $lang['langue'] == $langue ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($lang['langue']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <!-- <label for="remise" class="form-label">Remises :</label>
                                <select class="form-select form-select-sm" aria-label="Small select example" id="remise" name="remise" style="padding: 0 10px">
                                    <option value="" selected>----</option>                                
                                    <option value="0" >0%</option>                                
                                    <option value="25">25%</option>
                                    <option value="50">50%</option>
                                    <option value="75">75%</option>
                                </select> -->
                            </div>
                            <button type="submit" name="filtre" class="btn btn-primary">Valider</button>
                        </form>
                    </div>
                </li>

                <li class="nav-item nav-cart" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Annuler" style="list-style: none;">
                    <a href="index.php?page=dashboardClient" class="tm-search-btn btn btn-danger d-flex align-items-center justify-content-center" style="width: 70px; background-color: #dc3545;">
                        <i class="fa-solid fa-delete-left fa-lg"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>



<div class="container-fluid tm-container-content mt-4">
    <div class="container mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <div class="row">
            <?php if (!empty($items)): ?>
                <?php foreach ($items as $item): ?>
                    <div class="col-md-2 mb-3 ms-3">
                        <div class="card border-success" style="width: 215px;">
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
                                    <img src="uploads/<?= htmlspecialchars($item['img']) ?>" style="width: 180px; height: 245px;" class="card-img-top" alt="...">
                                    <div class="d-flex justify-content-between align-items-center" style="margin-top: 5px; margin-bottom: -5px;">
                                        <p class="card-title text-left text-success m-0"><?= htmlspecialchars($item['titre']) ?></p>
                                        <a href=""><p class="card-title text-right text-primary m-0"><?= htmlspecialchars($item['nomComplet']) ?></p></a>
                                    </a>
                                </div>
                            </div>
                            <div class="card-footer text-center bg-transparent border-success">
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
            document.getElementById('pageLang').innerText = 'Nombres des pages : ' + nbpage + ' \n Langue : ' + langue + ' \n Edition : ' + editionn;
            document.getElementById('descriptionn').innerText = descriptionn;
            document.getElementById('categorie-modal').innerText = 'cat';
            document.getElementById('product-id').value = idProd;
        });
    });
</script>
