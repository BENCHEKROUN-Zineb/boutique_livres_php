<?php
    include 'include/connexion.php';

    // Fetch products in the category
    try {
        $stmt = $pdo->prepare("SELECT p.*, a.nomComplet AS auteur FROM produit p JOIN auteur a ON p.id_a = a.id_a WHERE a.id_a = ?");
        $stmt->execute([intval($_GET['id'])]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        $items = [];
    }

    // Fetch the author name
    try {
        $stmt_c = $pdo->prepare("SELECT nomComplet FROM auteur WHERE id_a = ?");
        $stmt_c->execute([intval($_GET['id'])]);
        $nomA = $stmt_c->fetch(PDO::FETCH_ASSOC); // Utilisation de fetch() pour une seule ligne
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        $nomA = [];
    }
?>

<div class="tm-hero d-flex justify-content-center align-items-center" data-parallax="scroll" style="margin-top: 4%;">
    <form class="d-flex tm-search-form">
        <p class="form-control tm-search-input" style="border-radius: 15px;">Parcourir les livres de l'auteur : <?php echo '<b>' . htmlspecialchars($nomA['nomComplet']) . '</b>' ?></p>
    </form>
</div>

<div class="container-fluid tm-container-content mt-4">
    <div class="container mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <div class="row">
            <?php foreach ($items as $item): ?>
                <div class="col-md-2 mb-3">
                    <div class="card border-success" style="width: 215px;">
                        <div class="card-body text-success">
                            <a href="#" class="view-more" data-bs-toggle="modal" data-bs-target="#exampleModal"
                               data-id="<?= htmlspecialchars($item['id_prod']) ?>"
                               data-title="<?= htmlspecialchars($item['titre']) ?>"
                               data-img="uploads/<?= htmlspecialchars($item['img']) ?>"
                               data-prix="<?= htmlspecialchars($item['prix']) ?>"
                               data-auteur="<?= htmlspecialchars($item['auteur']) ?>"
                               data-nbpage="<?= htmlspecialchars($item['nbpage']) ?>"
                               data-langue="<?= htmlspecialchars($item['langue']) ?>"
                               data-editionn="<?= htmlspecialchars($item['editionn']) ?>"
                               data-datepublication="<?= htmlspecialchars($item['datepublication']) ?>"
                               data-descriptionn="<?= htmlspecialchars($item['descriptionn']) ?>"
                               data-qteS="<?= htmlspecialchars($item['qteS']) ?>">
                                <img src="uploads/<?= htmlspecialchars($item['img']) ?>" style="width: 180px; height: 245px;"  class="card-img-top" alt="...">
                                <h6 class="card-title text-center text-success" style="margin-top: 5px; margin-bottom: -5px;"><?= htmlspecialchars($item['titre']) ?></h6>
                            </a>
                        </div>
                        <div class="card-footer text-center bg-transparent border-success">
                            Prix: <?= htmlspecialchars($item['prix']) ?> DH
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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
                        <!-- Image -->
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                            <img src="" alt="Image" class="img-fluid" id="modal-img">
                        </div>

                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                            <div class="tm-bg-gray tm-video-details">
                                <!-- Flexbox container to align divs side by side -->
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
                                            <span class="tm-text-gray-dark">Catégorie : </span>
                                            <span class="tm-text-white" id="">Catégorie</span>
                                        </div>
                                    </div>
                                    <p class="mb-4" id="pageLang">
                                        <!-- Content of pageLang -->
                                    </p>
                                </div>

                                <!-- Description -->
                                <div class="mb-4">
                                    <h4 class="tm-text-gray-dark">Description :</h4>
                                    <p id="descriptionn" style="font-size: 12px;"></p>
                                </div>

                                <!-- Price -->
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
            var qteS = this.getAttribute('data-qteS');
            var idProd = this.getAttribute('data-id');
            
            document.getElementById('titre-modal').innerText = title;
            document.getElementById('modal-img').src = img;
            document.getElementById('auteurL').innerText = auteur;
            document.getElementById('pageLang').innerText = 'Nombre de pages : ' + nbpage + '\n Langue : ' + langue + '\n Edition : ' + editionn + '\n Date de Publication : ' + datepublication;
            document.getElementById('descriptionn').innerText = descriptionn;
            document.getElementById('prix').innerText = prix + ' DH';
            document.getElementById('product-id').value = idProd;

        });
    });
</script>

