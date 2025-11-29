
    <?php
        require('../include/connexion.php');

        if(isset($_POST['ajouter'])){
            $nom = $_POST['nom_c'];

            if(!empty($nom)){
                $req = $pdo->prepare("INSERT INTO categorie (nom_c) VALUES (:nom)");
                $req->bindParam(':nom', $nom, PDO::PARAM_STR);
                
                if ($req->execute()) {
                    header('Location: ../Admin/indexAdmin.php?page=categorieAdmin');
                    exit();
                } else {
                    echo 'Erreur lors de l\'ajout de la catégorie.';
                }
            } else {
                echo 'Le champ nom ne peut pas être vide.';
            }
        }

        if (isset($_POST['modifier'])) {
            $id = htmlspecialchars($_POST['id_c']);
            $nom_c = htmlspecialchars($_POST['nom_c']);

            try {
                $stmt = $pdo->prepare('UPDATE categorie SET nom_c = ? WHERE id_c = ?');
                $stmt->execute([$nom_c, $id]);
                
                // Redirection après la modification
                header('Location: ../Admin/indexAdmin.php?page=categorieAdmin');
                exit;
            } catch (PDOException $e) {
                echo 'Erreur : ' . $e->getMessage();
            }
        }

        if (isset($_GET['id'])) {
            $id = htmlspecialchars($_GET['id']);

            try {
                $stmt = $pdo->prepare('DELETE FROM categorie WHERE id_c = ?');
                $stmt->execute([$id]);
                
                // Redirection après la suppression
                header('Location: ../Admin/indexAdmin.php?page=categorieAdmin');
                exit;
            } catch (PDOException $e) {
                echo 'Erreur : ' . $e->getMessage();
            }
        } else {
            echo "ID de catégorie non spécifié.";
            exit;
        }
    ?>



