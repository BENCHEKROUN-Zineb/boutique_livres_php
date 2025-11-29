<?php
include '../include/connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_u = 3; // ID de l'utilisateur (à adapter selon votre logique d'authentification)
    $id_prod = intval($_POST['id_prod']);
    $qte = intval($_POST['qte']);

    // Vérification si le produit existe
    $sqlCheckProduct = "SELECT COUNT(*) FROM produit WHERE id_prod = :id_prod";
    $stmtCheckProduct = $pdo->prepare($sqlCheckProduct);
    $stmtCheckProduct->execute(['id_prod' => $id_prod]);
    $productExists = $stmtCheckProduct->fetchColumn();

    if ($productExists == 0) {
        die('Erreur : Le produit avec cet ID n\'existe pas.');
    }

    try {
        // Démarrer une transaction
        $pdo->beginTransaction();

        // Vérifier si le panier existe déjà pour l'utilisateur
        $sqlCheckPanier = "SELECT id_pa FROM panier WHERE id_u = :id_u";
        $stmtCheckPanier = $pdo->prepare($sqlCheckPanier);
        $stmtCheckPanier->execute(['id_u' => $id_u]);
        $panier = $stmtCheckPanier->fetch(PDO::FETCH_ASSOC);

        if ($panier) {
            // Si le panier existe, utiliser son ID
            $id_pa = $panier['id_pa'];
        } else {
            // Sinon, créer un nouveau panier
            $sqlInsertPanier = "INSERT INTO panier (id_u) VALUES (:id_u)";
            $stmtInsertPanier = $pdo->prepare($sqlInsertPanier);
            $stmtInsertPanier->execute(['id_u' => $id_u]);
            $id_pa = $pdo->lastInsertId();
        }

        // Vérifier si le produit existe déjà dans le détail du panier
        $sqlCheckDetailPanier = "SELECT qte FROM detailpanier WHERE id_pa = :id_pa AND id_prod = :id_prod";
        $stmtCheckDetailPanier = $pdo->prepare($sqlCheckDetailPanier);
        $stmtCheckDetailPanier->execute([
            'id_pa' => $id_pa,
            'id_prod' => $id_prod
        ]);
        $detailPanier = $stmtCheckDetailPanier->fetch(PDO::FETCH_ASSOC);

        if ($detailPanier) {
            // Si le produit existe déjà, incrémenter la quantité
            $sqlUpdateDetailPanier = "UPDATE detailpanier SET qte = qte + :qte WHERE id_pa = :id_pa AND id_prod = :id_prod";
            $stmtUpdateDetailPanier = $pdo->prepare($sqlUpdateDetailPanier);
            $stmtUpdateDetailPanier->execute([
                'qte' => $qte,
                'id_pa' => $id_pa,
                'id_prod' => $id_prod
            ]);
        } else {
            // Sinon, insérer un nouveau détail de panier
            $sqlInsertDetailPanier = "INSERT INTO detailpanier (id_pa, id_prod, qte) VALUES (:id_pa, :id_prod, :qte)";
            $stmtInsertDetailPanier = $pdo->prepare($sqlInsertDetailPanier);
            $stmtInsertDetailPanier->execute([
                'id_pa' => $id_pa,
                'id_prod' => $id_prod,
                'qte' => $qte
            ]);
        }

        // Valider la transaction
        $pdo->commit();

        // Rediriger vers une page de confirmation ou afficher un message de succès
        header('Location: ../index.php?page=dashboardClient');
        exit;

    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        $pdo->rollBack();
        die('Erreur : ' . $e->getMessage());
    }
}

// Fermer la connexion
$pdo = null;
?>
