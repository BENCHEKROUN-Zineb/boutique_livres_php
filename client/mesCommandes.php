<?php
include 'include/connexion.php';

// Requête pour récupérer les commandes avec leurs détails
$sql = "SELECT commande.num_cmd, COUNT(detailcmd.id_prod) AS nombre_produit, commande.etat
        FROM commande
        LEFT JOIN detailcmd ON commande.num_cmd = detailcmd.num_cmd
        GROUP BY commande.num_cmd";

$stmt = $pdo->query($sql);
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$i = 0;
?>

<div class="px-4 px-lg-0">
    <div class="pb-5" style="margin-top: 5%;">
        <div class="container">
            <div class="row justify-content-center"> <!-- Utilisation de justify-content-center pour centrer le contenu -->
                <div class="col-lg-8 p-5 bg-white rounded shadow-sm mb-5">
                    <!-- Shopping cart table -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" class="border-0 bg-light">
                                        <div class="p-2 px-3 text-uppercase">Numero de la Commande</div>
                                    </th>
                                    <th scope="col" class="border-0 bg-light">
                                        <div class="py-2 text-uppercase">Nombre de Produit</div>
                                    </th>
                                    <th scope="col" class="border-0 bg-light">
                                        <div class="py-2 text-uppercase">Etat</div>
                                    </th>
                                    <th scope="col" class="border-0 bg-light">
                                        <div class="py-2 text-uppercase">Action</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($commandes as $commande): ?>
                                    <tr>
                                        <td scope="row" class="border-0">
                                            <div class="p-2">
                                                Commande : <strong><?= ++$i; ?></strong>
                                            </div>
                                        </td>
                                        <td class="border-0 align-middle">
                                            <strong><?= htmlspecialchars($commande['nombre_produit']) ?></strong>
                                        </td>
                                        <td class="border-0 align-middle">
                                            <?php
                                            $etat = htmlspecialchars($commande['etat']);
                                            switch ($etat) {
                                                case 'En attente':
                                                    echo '<strong><span class="text-secondary">' . $etat . '</span></strong>';
                                                    break;
                                                case 'en cours de traitement':
                                                    echo '<strong><span class="text-warning">' . $etat . '</span></strong>';
                                                    break;
                                                case 'terminee':
                                                    echo '<strong><span class="text-primary">' . $etat . '</span></strong>';
                                                    break;
                                                case 'envoyee':
                                                    echo '<strong><span class="text-success">' . $etat . '</span></strong>';
                                                    break;
                                                case 'annulee':
                                                    echo '<strong><span class="text-danger">' . $etat . '</span></strong>';
                                                    break;
                                                default:
                                                    echo htmlspecialchars($etat);
                                            }
                                            ?>
                                        </td>
                                        <td class="border-0 align-middle" style="text-align: center;">
                                            <a href="#" class="text-dark view-details" data-numcmd="<?= $commande['num_cmd'] ?>">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- End Shopping cart table -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour afficher les détails de la commande -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!-- Le contenu du modal sera chargé via AJAX -->
    </div>
</div>

<!-- jQuery pour gérer le chargement des détails de la commande -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.view-details').click(function(e) {
        e.preventDefault();
        var numCmd = $(this).data('numcmd');

        // AJAX pour récupérer les détails de la commande
        $.ajax({
            type: 'GET',
            url: 'get_commande_details.php', // Fichier PHP qui gère la récupération des détails de commande
            data: { numCmd: numCmd },
            success: function(response) {
                $('#detailsModal .modal-dialog').html(response);
                $('#detailsModal').modal('show'); // Afficher le modal avec les détails
            },
            error: function() {
                alert('Une erreur s\'est produite lors du chargement des détails de la commande.');
            }
        });
    });
});
</script>

<?php
// Fermer la connexion
$pdo = null;
?>
