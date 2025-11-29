<!-- Button to open the modal -->
<div class="d-flex justify-content-start mb-4" style="margin-left: 3%;">
    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addAuthorModal">
        <i class="fa-solid fa-circle-plus"></i>
        Ajouter un Auteur
    </button>
</div>

<div class="container" style="width:100%;">
    <table id="myTable" class="hover row-border stripe" style="width:100%">
        <thead>
            <tr>
                <th>Image</th>
                <th>Nom complet de l'auteur</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../include/connexion.php';

            try {
                $stmt = $pdo->query('SELECT * FROM auteur');
                $auteurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo 'Erreur : ' . $e->getMessage();
                $auteurs = [];
            }

            if ($auteurs) {
                foreach ($auteurs as $auteur) {
                    $imgPath = '../uploads/' . htmlspecialchars($auteur['img']);
            ?>
                    <tr>
                        <td><img src="<?= $imgPath ?>" alt="Image" class="img-fluid" style="max-width: 100px; height: auto;"></td>
                        <td><?= htmlspecialchars($auteur['nomComplet']) ?></td>
                        <td>
                            <a href="#"><button class="btn btn-outline-info"><i class="fa-regular fa-eye"></i></button></a>
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editAuthorModal" data-id="<?= htmlspecialchars($auteur['id_a']) ?>" data-nom="<?= htmlspecialchars($auteur['nomComplet']) ?>" data-img="<?= htmlspecialchars($auteur['img']) ?>"><i class="fa-regular fa-pen-to-square"></i></button>
                            <a href="../traitement/traitementAuteur.php?id=<?= htmlspecialchars($auteur['id_a']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet auteur ?');"><button class="btn btn-outline-danger"><i class="fa-regular fa-trash-can"></i></button></a>
                        </td>
                    </tr>
            <?php
                }
            ?>

        </tbody>

        <?php
            } else {
                echo "<tr><td colspan='3'>Aucun auteur trouvé.</td></tr>";
            }
        ?>
    </table>
</div>


<!-- Modal for adding author -->
<div class="modal fade" id="addAuthorModal" tabindex="-1" aria-labelledby="addAuthorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAuthorModalLabel">Ajouter un Auteur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAuthorForm" action="../traitement/traitementAuteur.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nomComplet" class="form-label">Nom complet de l'auteur</label>
                        <input type="text" class="form-control" id="nomComplet" name="nomComplet" required>
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Image</label>
                        <input type="file" class="form-control" id="img" name="img" required>
                    </div>
                    <button type="submit" name="ajouter" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for editing author -->
<div class="modal fade" id="editAuthorModal" tabindex="-1" aria-labelledby="editAuthorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAuthorModalLabel">Modifier l'Auteur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAuthorForm" action="../traitement/traitementAuteur.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="editAuthorId" name="id_auteur">
                    <div class="mb-3">
                        <label for="editNomComplet" class="form-label">Nom complet de l'auteur</label>
                        <input type="text" class="form-control" id="editNomComplet" name="nomComplet" required>
                    </div>
                    <div class="mb-3">
                        <label for="editImg" class="form-label">Image</label>
                        <input type="file" class="form-control" id="editImg" name="img">
                    </div>
                    <button type="submit" name="modifier" class="btn btn-primary">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    $('#editAuthorModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id'); // Extract info from data-* attributes
        var nom = button.data('nom');
        var img = button.data('img');

        // Update the modal's content.
        var modal = $(this);
        modal.find('#editAuthorId').val(id);
        modal.find('#editNomComplet').val(nom);
        // You might want to display the existing image or handle it differently
    });

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

