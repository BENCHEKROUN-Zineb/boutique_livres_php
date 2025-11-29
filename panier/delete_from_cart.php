<?php
include '../include/connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pa = intval($_POST['id_pa']);
    $id_prod = intval($_POST['id_prod']);

    try {
        // Démarrer une transaction
        $pdo->beginTransaction();

        // Récupérer la quantité actuelle
        $sqlGetQuantity = "SELECT qte FROM detailpanier WHERE id_pa = :id_pa AND id_prod = :id_prod";
        $stmtGetQuantity = $pdo->prepare($sqlGetQuantity);
        $stmtGetQuantity->execute(['id_pa' => $id_pa, 'id_prod' => $id_prod]);
        $currentQuantity = $stmtGetQuantity->fetchColumn();

        if ($currentQuantity === false) {
            throw new Exception('Produit non trouvé dans le panier.');
        }

        if ($currentQuantity > 1) {
            // Si la quantité est supérieure à 1, décrémenter la quantité
            $sqlDecrement = "UPDATE detailpanier SET qte = qte - 1 WHERE id_pa = :id_pa AND id_prod = :id_prod";
            $stmtDecrement = $pdo->prepare($sqlDecrement);
            $stmtDecrement->execute(['id_pa' => $id_pa, 'id_prod' => $id_prod]);
        } else {
            // Si la quantité est égale à 1, supprimer le produit du panier
            $sqlDelete = "DELETE FROM detailpanier WHERE id_pa = :id_pa AND id_prod = :id_prod";
            $stmtDelete = $pdo->prepare($sqlDelete);
            $stmtDelete->execute(['id_pa' => $id_pa, 'id_prod' => $id_prod]);
        }

        // Valider la transaction
        $pdo->commit();
        
        echo 'Produit supprimé avec succès.';

    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        $pdo->rollBack();
        echo 'Erreur : ' . $e->getMessage();
    }
}

// Fermer la connexion
$pdo = null;
?>
