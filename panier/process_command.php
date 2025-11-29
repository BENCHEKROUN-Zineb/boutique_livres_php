<?php
include '../include/connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Démarrer une transaction
        $pdo->beginTransaction();

        // Insérer les informations de la commande dans la table `commande`
        $id_u = 3; // À remplacer par la manière dont vous récupérez l'ID de l'utilisateur
        $date_cmd = date('Y-m-d H:i:s'); // Date et heure actuelles
        $etat = 'En attente'; // État initial de la commande

        $sqlInsertCommande = "INSERT INTO commande (date_cmd, etat, id_u) VALUES (:date_cmd, :etat, :id_u)";
        $stmtInsertCommande = $pdo->prepare($sqlInsertCommande);
        $stmtInsertCommande->execute(['date_cmd' => $date_cmd, 'etat' => $etat, 'id_u' => $id_u]);

        // Récupérer l'ID de la commande insérée
        $num_cmd = $pdo->lastInsertId();

        // Insérer les détails de la commande dans la table `detailcmd`
        $sqlInsertDetailCmd = "INSERT INTO detailcmd (num_cmd, id_prod, qte) VALUES (:num_cmd, :id_prod, :qte)";
        $stmtInsertDetailCmd = $pdo->prepare($sqlInsertDetailCmd);

        // Récupérer les produits du panier
        $sqlPanier = "SELECT id_prod, qte FROM detailpanier WHERE id_pa IN (SELECT id_pa FROM panier WHERE id_u = :id_u)";
        $stmtPanier = $pdo->prepare($sqlPanier);
        $stmtPanier->execute(['id_u' => $id_u]);
        $produitsPanier = $stmtPanier->fetchAll(PDO::FETCH_ASSOC);

        // Insérer chaque produit du panier comme détail de commande
        foreach ($produitsPanier as $produit) {
            $stmtInsertDetailCmd->execute([
                'num_cmd' => $num_cmd,
                'id_prod' => $produit['id_prod'],
                'qte' => $produit['qte']
            ]);
        }

        // Vider le panier de l'utilisateur
        $sqlDeletePanier = "DELETE FROM detailpanier WHERE id_pa IN (SELECT id_pa FROM panier WHERE id_u = :id_u)";
        $stmtDeletePanier = $pdo->prepare($sqlDeletePanier);
        $stmtDeletePanier->execute(['id_u' => $id_u]);

        // Valider la transaction
        $pdo->commit();

        echo 'Commande passée avec succès.';

    } catch (Exception $e) {
        // En cas d'erreur, annuler la transaction
        $pdo->rollBack();
        echo 'Erreur lors du passage de la commande : ' . $e->getMessage();
    }
} else {
    echo 'Méthode non autorisée.';
}

// Fermer la connexion
$pdo = null;
?>
