<?php
include 'include/connexion.php';

// Requête SQL
$id_u = 3; // ID de l'utilisateur
$sql = "SELECT panier.id_pa, panier.id_u, produit.id_prod, produit.img, produit.titre, auteur.nomComplet, produit.id_a, produit.prix, dp.qte
        FROM produit
        JOIN detailpanier dp ON produit.id_prod = dp.id_prod
        JOIN panier ON panier.id_pa = dp.id_pa
        JOIN auteur ON auteur.id_a = produit.id_a
        WHERE panier.id_u = :id_u";

// Préparation et exécution de la requête
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_u' => $id_u]);

// Récupération des résultats
$panier = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcul du total de la commande
$total_commande = 0;
foreach ($panier as $item) {
    $total_commande += $item['prix'] * $item['qte'];
}
?>

<div class="px-4 px-lg-0">
    <div class="pb-5" style="margin-top: 5%;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-5">
                    <!-- Shopping cart table -->
                    <div class="p-5 bg-white rounded shadow-sm">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="p-2 px-3 text-uppercase">Produit</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Prix</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Quantité</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Supprimer</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($panier) > 0): ?>
                                        <?php foreach ($panier as $item): ?>
                                            <tr>
                                                <th scope="row" class="border-0">
                                                    <div class="p-2">
                                                        <img src="uploads/<?= htmlspecialchars($item['img']) ?>" alt="" width="70" class="img-fluid rounded shadow-sm">
                                                        <div class="ml-3 d-inline-block align-middle">
                                                            <h5 class="mb-0"> 
                                                                <a href="#" class="text-dark d-inline-block align-middle"><?= htmlspecialchars($item['titre']) ?></a>
                                                            </h5>
                                                            <span class="text-muted font-weight-normal font-italic d-block">
                                                                Auteur: <?= htmlspecialchars($item['nomComplet']) ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </th>
                                                <td class="border-0 align-middle">
                                                    <strong><?= htmlspecialchars($item['prix']) ?> DH</strong>
                                                </td>
                                                <td class="border-0 align-middle">
                                                    <strong><?= htmlspecialchars($item['qte']) ?></strong>
                                                </td>
                                                <td class="border-0 align-middle">
                                                    <a href="#" class="text-dark delete-product" data-id-pa="<?= $item['id_pa'] ?>" data-id-prod="<?= $item['id_prod'] ?>">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">Votre panier est vide</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- End Shopping cart table -->
                </div>
                <div class="col-lg-4">
                    <!-- Order summary -->
                    <div class="p-4 bg-white rounded shadow-sm">
                        <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Récapitulatif de la commande</div>
                        <div class="p-4">
                            <ul class="list-unstyled mb-4">
                                <li class="d-flex justify-content-between py-3 border-bottom">
                                    <strong class="text-muted">Total de la commande</strong>
                                    <strong><?= number_format($total_commande, 2) ?> DH</strong>
                                </li>
                                <li class="d-flex justify-content-between py-3 border-bottom">
                                    <strong class="text-muted">Taxe</strong>
                                    <strong>0.00 DH</strong>
                                </li>
                                <li class="d-flex justify-content-between py-3 border-bottom">
                                    <strong class="text-muted">Total</strong>
                                    <h5 class="font-weight-bold"><?= number_format($total_commande, 2) ?> DH</h5>
                                </li>
                            </ul>
                            
                            <a href="#" class="btn btn-dark rounded-pill py-2 btn-block btn-commander">
                                Commander <i class="fa-regular fa-circle-check"></i>
                            </a>

                        </div>
                    </div>
                    <!-- End Order summary -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.delete-product').forEach(function(element) {
    element.addEventListener('click', function(event) {
        event.preventDefault();

        var idPa = this.getAttribute('data-id-pa');
        var idProd = this.getAttribute('data-id-prod');

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'panier/delete_from_cart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                location.reload(); // Recharger la page après suppression
            }
        };

        xhr.send('id_pa=' + idPa + '&id_prod=' + idProd);
    });
});

document.querySelector('.btn-commander').addEventListener('click', function(event) {
    event.preventDefault();

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'panier/process_command.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert(xhr.responseText);
            location.reload(); // Recharger la page après la commande
        }
    };

    xhr.send();
});
</script>

<?php
// Fermer la connexion
$pdo = null;
?>
