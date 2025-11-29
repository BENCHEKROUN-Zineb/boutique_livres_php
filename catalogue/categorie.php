<?php
    include 'include/connexion.php';

    try {
        $stmt = $pdo->query('SELECT c.id_c, c.nom_c AS categorie, COUNT(pc.id_prod) AS nombre_de_livres 
                            FROM categorie c 
                            LEFT JOIN prod_categ pc ON c.id_c = pc.id_c 
                            GROUP BY c.id_c');
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        $categories = [];
    }
?>

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

    <div class="tm-hero d-flex justify-content-center align-items-center" data-parallax="scroll" style="margin-top: 60px;">
        <form class="d-flex tm-search-form">
            <p class="form-control tm-search-input" style="border-radius: 15px; text-align: center; font-weight: 700; font-size: large;">Les Categories :</p>
        </form>
    </div>

    <div class="container mt-3">
        <div class="row">
            <?php foreach ($categories as $categorie): ?>
                <div class="col-md-3 mb-3">
                    <div class="card border-success">
                        <a href="afficher_categ_prod.php?id=<?= htmlspecialchars($categorie['id_c']) ?>">
                            <div class="card-body text-success">
                                <h5 class="card-title" style="text-align: center;"><?= htmlspecialchars($categorie['categorie']) ?></h5>
                            </div>
                            <div class="card-footer bg-transparent border-success">
                                Nombre de livres: <?= htmlspecialchars($categorie['nombre_de_livres']) ?>
                                <i class="fa-solid fa-swatchbook" style="color: #0da05c;"></i>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

