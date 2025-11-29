<?php
// Include de la connexion à la base de données
include 'include/connexion.php';

// Vérification si numCmd est passé en GET
if (isset($_GET['numCmd'])) {
    $numCmd = $_GET['numCmd'];

    // Requête pour récupérer les détails de la commande
    $sql = "SELECT c.num_cmd, c.date_cmd, c.etat, p.titre, p.id_a, p.img, dc.qte
            FROM commande c
            JOIN detailcmd dc ON dc.num_cmd = c.num_cmd
            JOIN produit p ON p.id_prod = dc.id_prod
            JOIN auteur a ON p.id_a = a.id_a
            WHERE c.num_cmd = :numCmd";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['numCmd' => $numCmd]);
    $details_commande = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Construction du contenu HTML pour afficher dans le modal
    if ($details_commande) {
        $html = '<div class="modal-content">';
        $html .= '<div class="modal-header">';
        $html .= '<h5 class="modal-title" id="detailsModalLabel">Détails de la Commande #' . $details_commande[0]['num_cmd'] . '</h5>';
        $html .= '</div>';
        $html .= '<div class="modal-body">';
        $html .= '<p class="text-dark"><strong>Date de commande :</strong> ' . htmlspecialchars($details_commande[0]['date_cmd']) . '</p>';
        $etat = htmlspecialchars($details_commande[0]['etat']);        
        switch ($etat) {
            case 'En attente':
                $html .= '<p class="text-dark"><strong>État :</strong> <span class="text-secondary"> ' . $etat . '</span></p>';
                break;
            case 'en cours de traitement':
                $html .= '<p class="text-dark"><strong>État :</strong> <span class="text-warning"> ' . $etat . '</span></p>';
                break;
            case 'terminee':
                $html .= '<p class="text-dark"><strong>État :</strong> <span class="text-warning"> ' . $etat . '</span></p>';
                break;
            case 'envoyee':
                $html .= '<p class="text-dark"><strong>État :</strong> <span class="text-warning"> ' . $etat . '</span></p>';
                break;
            case 'annulee':
                $html .= '<p class="text-dark"><strong>État :</strong> <span class="text-warning"> ' . $etat . '</span></p>';
                break;
            default:
                echo htmlspecialchars($etat);
        }
        // $html .= '<p class="text-dark"><strong>État :</strong> ' . $etat . '</p>';
        $html .= '<p class="text-dark"><strong>Détails des produits :</strong></p>';
        $html .= '<ul>';
        foreach ($details_commande as $detail) {
            $html .= '<li>';
            $html .= '<strong>Produit :</strong> ' . htmlspecialchars($detail['titre']) . ' (Quantité : ' . htmlspecialchars($detail['qte']) . ')';
            $html .= '</li>';
        }
        $html .= '</ul>';
        $html .= '</div>';
        $html .= '<div class="modal-footer">';
        $html .= htmlspecialchars($detail['prix'] * $detail['qte']).'DH';
        $html .= '</div>';
        $html .= '</div>';

        echo $html;
    } else {
        echo '<p>Aucun détail trouvé pour la commande #' . htmlspecialchars($numCmd) . '</p>';
    }
} else {
    echo '<p>Numéro de commande non spécifié.</p>';
}
?>
