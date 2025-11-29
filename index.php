<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Boutique</title>
    <link rel="icon" type="image/png" href=" img/logo.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/templatemo-style.css">
    <link rel="stylesheet" href="assets/font-awesome/css/all.min.css">
</head>
<body>
    <?php
        session_start();
        include 'include/navbar.php';

        if (isset($_SESSION['email'])) {
            echo 'welcome';
        }
    ?>

    <div id="content">
        <?php
        if(isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 'dashboardClient';
        }
        
        // Define directory mapping
        $directories = [
            'auth' => ['login', 'logout', 'signup'],
            'client' => ['dashboardClient', 'mesCommandes'],
            'panier' => ['add_to_cart', 'ajouter_panier', 'delete_from_cart', 'process_command', 'get_commande_details'],
            'catalogue' => ['afficher_categ_prod', 'afficher_prod_aut', 'categorie', 'produit', 'auteur', 'recherche']
        ];
        
        $found = false;
        foreach ($directories as $dir => $files) {
            if (in_array($page, $files)) {
                include("$dir/$page.php");
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            if (file_exists("$page.php")) {
                include("$page.php");
            } else {
                echo "Page not found.";
            }
        }
        ?>
    </div>

    <?php include 'include/footer.php'; ?>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.6.0.js"></script>
    <script src="js/plugins.js"></script>
</body>
</html>
