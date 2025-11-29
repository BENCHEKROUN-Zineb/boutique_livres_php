
<div class="d-flex justify-content-center mb-4">
    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
        <i class="fa-solid fa-circle-plus"></i>
        Ajouter une Categorie
    </button> 
</div>

<div class="container" style="width:50%;">
    <table id="myTable" class="hover row-border stripe">
        <thead>
            <tr>
                <th  style="text-align: center;">Categories</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../include/connexion.php';

            try {
                $stmt = $pdo->query('SELECT * FROM categorie');
                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo 'Erreur : ' . $e->getMessage();
                $categories = [];
            }

            if ($categories) {
                foreach ($categories as $categorie) {
            ?>
                    <tr>
                        <td style="text-align: center;"><?= htmlspecialchars($categorie['nom_c']) ?></td>
                        <td>
                            <button class="btn btn-outline-primary" onclick="openEditModal(<?= htmlspecialchars($categorie['id_c']) ?>, '<?= htmlspecialchars($categorie['nom_c']) ?>')">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                            <a href="../traitement/traitementCategorie.php?id=<?=htmlspecialchars($categorie['id_c']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie (<?=htmlspecialchars($categorie['nom_c']) ?>) ?');"><button class="btn btn-outline-danger"><i class="fa-regular fa-trash-can"></i></button></a> 
                        </td>
                    </tr>
            <?php
                }
            ?>
        </tbody>
        <?php
            } else {
                echo "<tr><td colspan='2'>Aucune catégorie trouvée.</td></tr>";
            }
        ?>
    </table> 
</div>

<!-- Modal for adding category -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Ajouter une Categorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm" action="../traitement/traitementCategorie.php" method="post">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Nom de la Categorie</label>
                        <input type="text" class="form-control" id="categoryName" name="nom_c" required>
                    </div>
                    <button type="submit" name="ajouter" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for editing category -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Modifier la Categorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCategoryForm" action="../traitement/traitementCategorie.php" method="post">
                    <input type="hidden" id="editCategoryId" name="id_c">
                    <div class="mb-3">
                        <label for="editCategoryName" class="form-label">Nom de la Categorie</label>
                        <input type="text" class="form-control" id="editCategoryName" name="nom_c" required>
                    </div>
                    <button type="submit" name="modifier" class="btn btn-primary">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openEditModal(id, name) {
        $('#editCategoryId').val(id);
        $('#editCategoryName').val(name);
        $('#editCategoryModal').modal('show');
    }

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
            "lengthMenu": [10, 15, 20]
        });
    });
</script>
