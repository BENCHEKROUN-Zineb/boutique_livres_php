<?php
    include '../include/connexion.php';

    if (isset($_POST['ajouter'])) {
        $nomComplet = htmlspecialchars($_POST['nomComplet']);
        $img = $_FILES['img']['name'];

        if ($nomComplet && $img) {
            $imgPath = '../uploads/' . basename($img);
            if (move_uploaded_file($_FILES['img']['tmp_name'], $imgPath)) {
                try {
                    $stmt = $pdo->prepare('INSERT INTO auteur (nomComplet, img) VALUES (?, ?)');
                    $stmt->execute([$nomComplet, $img]);

                    header('Location: ../Admin/indexAdmin.php?page=auteurAdmin&success=true');
                    exit;
                } catch (PDOException $e) {
                    echo 'Erreur : ' . $e->getMessage();
                }
            } else {
                echo 'Erreur lors du téléchargement de l\'image.';
            }
        } else {
            echo 'Tous les champs sont obligatoires.';
        }
    }

    // if (isset($_POST['ajouter'])) {
    //     // Code pour ajouter un auteur
    // } else
    
    if (isset($_POST['modifier'])) {
        // Code pour modifier un auteur
        $id = $_POST['id_auteur'];
        $nomComplet = $_POST['nomComplet'];
        $img = $_FILES['img'];

        // Si une nouvelle image est téléchargée, remplacez l'ancienne
        if ($img['size'] > 0) {
            $imgPath = '../uploads/' . basename($img['name']);
            move_uploaded_file($img['tmp_name'], $imgPath);
            $stmt = $pdo->prepare("UPDATE auteur SET nomComplet = :nomComplet, img = :img WHERE id_a = :id");
            $stmt->execute(['nomComplet' => $nomComplet, 'img' => basename($img['name']), 'id' => $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE auteur SET nomComplet = :nomComplet WHERE id_a = :id");
            $stmt->execute(['nomComplet' => $nomComplet, 'id' => $id]);
        }

        header("Location: ../Admin/indexAdmin.php?page=auteurAdmin&success=true");
        exit();
    }

    if (isset($_GET['id'])) {
        $id = htmlspecialchars($_GET['id']);

        try {
            $stmt = $pdo->prepare('DELETE FROM auteur WHERE id_a = ?');
            $stmt->execute([$id]);
            
            // Redirection après la suppression
            header('Location: ../Admin/indexAdmin.php?page=auteurAdmin&success=true');
            exit;
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }
?>
