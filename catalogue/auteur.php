<?php
    include 'include/connexion.php';

    try {
        $stmt = $pdo->query('SELECT a.id_a, a.nomComplet, a.img, COUNT(p.id_a) AS nombre_de_livres FROM auteur a LEFT JOIN produit p ON a.id_a = p.id_a GROUP BY a.id_a;');
        $auteurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        $auteurs = [];
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
            <p class="form-control tm-search-input" style="border-radius: 15px; text-align: center; font-weight: 700; font-size: large;">Les Auteurs :</p>
        </form>
    </div>

    <div class="container mt-3">
        <div class="row">
            <?php foreach ($auteurs as $a): ?>
                <div class="col-md-3 mb-3">
                    <div class="card border-success">
                        <a href="afficher_prod_aut.php?id=<?= htmlspecialchars($a['id_a']) ?>">
                            <div class="card-body text-success">
                                <img src="uploads/<?= htmlspecialchars($a['img']) ?>" style="height: 272px;" class="card-img-top">
                                <h5 class="card-title" style="text-align: center;"><?= htmlspecialchars($a['nomComplet']) ?></h5>
                            </div>
                            <div class="card-footer bg-transparent border-success">
                                Nombre de livres: <?= htmlspecialchars($a['nombre_de_livres']) ?>
                                <i class="fa-solid fa-swatchbook" style="color: #0da05c;"></i>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>



