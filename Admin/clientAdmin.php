<div class="container" style="width:100%;">
    <table id="myTable" class="hover row-border stripe" style="width:100%">
        <thead>
            <tr>
                <th style="text-align: center;">Nom client</th>
                <th>Email Client</th>
                <th>Genre</th>
                <th>Image</th>
                <th>Nombre de Commandes</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../include/connexion.php';

            try {
                // Requête pour obtenir les utilisateurs avec leur nombre de commandes
                $stmt = $pdo->query('SELECT u.*, COUNT(c.num_cmd) as nombre_commandes 
                                     FROM utilisateur u 
                                     LEFT JOIN commande c ON u.id_u = c.id_u 
                                     WHERE u.isadmin = 0 
                                     GROUP BY u.id_u');
                $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo 'Erreur : ' . $e->getMessage();
                $clients = [];
            }

            if ($clients) {
                foreach ($clients as $client) {
                    $imgPath = '../uploads/' . htmlspecialchars($client['img']);
            ?>
                    <tr>
                        <td style="text-align: center;"><?= htmlspecialchars($client['nom_u']) ?></td>
                        <td><?= htmlspecialchars($client['email']) ?></td>
                        <td><?= htmlspecialchars($client['genre']) ?></td>
                        <td><img src="<?= $imgPath ?>" alt="Image" class="img-fluid" style="max-width: 100px; height: auto;"></td>
                        <td>
                            <a href="historiqueCommande.php?id_u=<?= htmlspecialchars($client['id_u']) ?>"><button class="btn btn-outline-primary"> <?= htmlspecialchars($client['nombre_commandes']) ?> <i class="fa-regular fa-eye"></i></button></a>
                        </td>
                    </tr>
            <?php
                }
            ?>

        </tbody>

        <?php
            } else {
                echo "<tr><td colspan='5'>Aucun client trouvé.</td></tr>";
            }
        ?>
    </table>
</div>

<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            "language": {
                "sProcessing": "Traitement en cours...",
                "sSearch": "Rechercher&nbsp;:",
                "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments par page",
                "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                "sLoadingRecords": "Chargement en cours...",
                "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
                "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
                "oPaginate": {
                    "sFirst": "Premier",
                    "sPrevious": "Pr&eacute;c&eacute;dent",
                    "sNext": "Suivant",
                    "sLast": "Dernier"
                },
                "oAria": {
                    "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                    "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                },
                "select": {
                    "rows": {
                        "_": "%d lignes s&eacute;lectionn&eacute;es",
                        "0": "Aucune ligne s&eacute;lectionn&eacute;e",
                        "1": "1 ligne s&eacute;lectionn&eacute;e"
                    }
                }
            },
            "lengthMenu": [5, 10, 15, 20]
        });
    });
</script>
