<?php
include '../include/connexion.php';

// Vérifier si l'ID utilisateur est passé en paramètre
if (isset($_GET['id_u'])) {
    $id_u = (int)$_GET['id_u'];

    // Mettre à jour l'état de la commande si le formulaire est soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['num_cmd']) && isset($_POST['etat'])) {
        $num_cmd = (int)$_POST['num_cmd'];
        $etat = $_POST['etat'];

        try {
            $stmt = $pdo->prepare('UPDATE commande SET etat = :etat WHERE num_cmd = :num_cmd');
            $stmt->execute(['etat' => $etat, 'num_cmd' => $num_cmd]);
            echo '<div class="alert alert-success">État de la commande mis à jour avec succès.</div>';
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">Erreur : ' . $e->getMessage() . '</div>';
        }
    }

    try {
        // Requête pour récupérer les commandes et leurs détails pour l'utilisateur spécifié
        $stmt = $pdo->prepare('SELECT c.num_cmd, c.date_cmd, c.etat, p.titre, p.id_a, a.nomComplet, p.img, p.prix, dc.qte 
                               FROM commande c 
                               JOIN detailcmd dc ON dc.num_cmd = c.num_cmd 
                               JOIN produit p ON p.id_prod = dc.id_prod 
                               JOIN auteur a ON p.id_a = a.id_a 
                               WHERE c.id_u = :id_u');
        $stmt->execute(['id_u' => $id_u]);
        $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        $commandes = [];
    }
} else {
    echo 'ID utilisateur non spécifié.';
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Commandes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../img/logo.png">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Historique des Commandes</h1>
    <?php if ($commandes): ?>
        <?php 
        // Grouper les commandes par num_cmd
        $groupedCommandes = [];
        foreach ($commandes as $commande) {
            $groupedCommandes[$commande['num_cmd']]['details'][] = $commande;
            $groupedCommandes[$commande['num_cmd']]['date_cmd'] = $commande['date_cmd'];
            $groupedCommandes[$commande['num_cmd']]['etat'] = $commande['etat'];
        }
        ?>

        <?php foreach ($groupedCommandes as $num_cmd => $commande): ?>
            <div class="card mt-4">
                <div class="card-header">
                    Commande #<?= htmlspecialchars($num_cmd) ?> - <?= htmlspecialchars($commande['date_cmd']) ?>
                </div>
                <div class="card-body">
                    <h5 class="card-title">État : <?= htmlspecialchars($commande['etat']) ?></h5>
                    <form method="POST" action="">
                        <input type="hidden" name="num_cmd" value="<?= htmlspecialchars($num_cmd) ?>">
                        <div class="form-group">
                            <label for="etat">Changer l'état :</label>
                            <select name="etat" id="etat" class="form-control" style="width: 200px; display: inline-block;">
                                <option value="en attente" <?= $commande['etat'] == 'en attente' ? 'selected' : '' ?>>En attente</option>
                                <option value="en cours de traitement" <?= $commande['etat'] == 'en cours de traitement' ? 'selected' : '' ?>>En cours de traitement</option>
                                <option value="terminee" <?= $commande['etat'] == 'terminee' ? 'selected' : '' ?>>Terminee</option>
                                <option value="envoyee" <?= $commande['etat'] == 'envoyee' ? 'selected' : '' ?>>Envoyee</option>
                                <option value="annulee" <?= $commande['etat'] == 'annulee' ? 'selected' : '' ?>>Annulee</option>
                            </select>
                            <button type="submit" class="btn btn-primary ml-2">Modifier</button>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Produit</th>
                                    <th>Auteur</th>
                                    <th>Prix</th>
                                    <th>Quantité</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($commande['details'] as $detail): ?>
                                    <tr>
                                        <td><img src="../uploads/<?= htmlspecialchars($detail['img']) ?>" alt="Image Produit" class="img-fluid" style="max-width: 100px;"></td>
                                        <td><?= htmlspecialchars($detail['titre']) ?></td>
                                        <td><?= htmlspecialchars($detail['nomComplet']) ?></td>
                                        <td><?= htmlspecialchars($detail['prix']) ?></td>
                                        <td><?= htmlspecialchars($detail['qte']) ?></td>
                                        <td><?= htmlspecialchars($detail['prix'] * $detail['qte']) ?> DH</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune commande trouvée pour cet utilisateur.</p>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
