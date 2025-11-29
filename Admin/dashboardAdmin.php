<?php
    include '../include/connexion.php';

    // Récupérer le nombre total de commandes
    try {
        $stmt = $pdo->query('SELECT COUNT(*) AS total_cmd FROM commande');
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalCmd = $result['total_cmd'];
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        $totalCmd = 0;
    }

    // Récupérer le total des prix de toutes les commandes
    try {
        $stmt = $pdo->query('SELECT SUM(p.prix * dc.qte) AS total_price FROM commande c JOIN detailcmd dc ON dc.num_cmd = c.num_cmd JOIN produit p ON p.id_prod = dc.id_prod');
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalPrice = $result['total_price'];
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        $totalPrice = 0;
    }

    // Récupérer le nombre de commandes par état
    try {
        $stmt = $pdo->query('SELECT etat, COUNT(*) AS count FROM commande GROUP BY etat');
        $cmdByStatus = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        $cmdByStatus = [];
    }

    // Initialiser les états
    $statuses = [
        'en attente' => 0,
        'en cours de traitement' => 0,
        'terminee' => 0,
        'envoyee' => 0,
        'annulee' => 0,
    ];

    foreach ($cmdByStatus as $status) {
        $statuses[$status['etat']] = $status['count'];
    }
?>

    <style>
        .card-deck .card {
            min-width: 18rem;
        }

        .card:hover {
            border-color: rgba(0, 0, 0, 0.2);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }
    </style>

<div class="container mt-5">
    <h2 class="mb-4">Tableau de Bord </h2>
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card border-secondary text-white h-100">
                <div class="card-header bg-secondary">Total des Commandes</div>
                <div class="card-body">
                    <h5 class="card-title text-dark"><?= htmlspecialchars($totalCmd) ?></h5>
                    <p class="card-text">Nombre total de commandes.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-secondary text-white h-100">
                <div class="card-header bg-secondary">Total des Prix des Commandes</div>
                <div class="card-body">
                    <h5 class="card-title text-dark"><?= htmlspecialchars(number_format($totalPrice, 2)) ?> DH</h5>
                    <p class="card-text">Somme des prix de toutes les commandes.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-warning mb-3 text-white h-100">
                <div class="card-header bg-warning">Commandes en attente</div>
                <div class="card-body">
                    <h5 class="card-title text-dark"><?= htmlspecialchars($statuses['en attente']) ?></h5>
                    <p class="card-text">Nombre de commandes en attente.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-primary mb-3 text-white h-100">
                <div class="card-header bg-primary">Commandes en cours de traitement</div>
                <div class="card-body">
                    <h5 class="card-title text-dark"><?= htmlspecialchars($statuses['en cours de traitement']) ?></h5>
                    <p class="card-text">Nombre de commandes en cours de traitement.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-success mb-3 text-white h-100">
                <div class="card-header bg-success">Commandes terminées</div>
                <div class="card-body text-dark">
                    <h5 class="card-title"><?= htmlspecialchars($statuses['terminee']) ?></h5>
                    <p class="card-text">Nombre de commandes terminées.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-info mb-3 text-white h-100">
                <div class="card-header bg-info">Commandes envoyées</div>
                <div class="card-body text-dark">
                    <h5 class="card-title"><?= htmlspecialchars($statuses['envoyee']) ?></h5>
                    <p class="card-text">Nombre de commandes envoyées.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-danger mb-3 text-white h-100">
                <div class="card-header bg-danger">Commandes annulées</div>
                <div class="card-body text-dark">
                    <h5 class="card-title"><?= htmlspecialchars($statuses['annulee']) ?></h5>
                    <p class="card-text">Nombre de commandes annulées.</p>
                </div>
            </div>
        </div>
    </div>
</div>

