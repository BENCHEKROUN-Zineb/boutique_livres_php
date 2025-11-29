<?php
    include 'include/connexion.php';

    try {
        $stmt = $pdo->query("
            SELECT p.titre, p.prix, p.img, p.nbpage, p.langue, p.editionn, p.datepublication, p.descriptionn, p.qteS, a.nomComplet , a.id_a
            FROM produit p
            JOIN auteur a ON p.id_a = a.id_a");
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        $items = [];
    }
    
?>
