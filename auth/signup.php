<?php
    include '../include/connexion.php';

    if (isset($_POST['signup'])) {
        $nom_u = htmlspecialchars($_POST['nom_u']);
        $email = htmlspecialchars($_POST['email']);
        $mdp = htmlspecialchars($_POST['mdp']);
        $confirm_mdp = htmlspecialchars($_POST['confirm_mdp']);
        $genre = htmlspecialchars($_POST['genre']);

        // Check if passwords match
        if ($mdp !== $confirm_mdp) {
            echo 'Passwords do not match.';
            exit;
        }

        // Handle file upload

        try {
            // Hash the password
            $hashedPassword = password_hash($mdp, PASSWORD_DEFAULT);

            // Prepare and execute the query
            $stmt = $pdo->prepare("INSERT INTO utilisateur (nom_u, email, mdp, genre, isadmin) VALUES (?, ?, ?, ?, 0)");
            $stmt->execute([$nom_u, $email, $hashedPassword, $genre]);

            header('Location: index.php?page=dashboardClient');
            exit();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }
?>
