<div class="d-flex justify-content-start mb-4">
    <a href="ajouterProduit.php" style="color: inherit; text-decoration: none;">
        <button type="button" class="btn btn-outline-primary">
            <i class="fa-solid fa-circle-plus"></i>
            Ajouter un Livre
        </button> 
    </a>
</div>

<table id="myTable" class="hover row-border stripe" style="width:100%">
    <thead>
        <tr>
            <th>Image</th>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Prix</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include '../include/connexion.php';

        try {
            $stmt = $pdo->query('SELECT id_prod, titre, prix, p.img, a.NomComplet, p.id_a FROM produit p JOIN auteur a on a.id_a = p.id_a');
            $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            $produits = [];
        }

        if ($produits) {
            foreach ($produits as $produit) {
                $imgPath = '../uploads/' . htmlspecialchars($produit['img']);
                $modifierUrl = 'modifierProduit.php?id=' . htmlspecialchars($produit['id_prod']);
        ?>
                <tr>
                    <td><img src="<?= $imgPath ?>" alt="Image" class="img-fluid" style="max-width: 100px; height: auto;"></td>
                    <td><?= htmlspecialchars($produit['titre']) ?></td>
                    <td><?= htmlspecialchars($produit['NomComplet']) ?></td>
                    <td>Prix : <?= htmlspecialchars($produit['prix']) ?> DH</td>
                    <td>
                        <a href="<?= $modifierUrl ?>"><button class="btn btn-outline-primary"><i class="fa-regular fa-pen-to-square"></i></button></a>
                        <a href="../traitement/traitementProduit.php?id=<?=htmlspecialchars($produit['id_prod']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');"><button class="btn btn-outline-danger"><i class="fa-regular fa-trash-can"></i></button></a> 
                    </td>
                </tr>
        <?php
            }
        ?>

    </tbody>

    <?php
        } else {
            echo "<tr><td colspan='5'>Aucun produit trouvé.</td></tr>";
        }
    ?>
</table>


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

