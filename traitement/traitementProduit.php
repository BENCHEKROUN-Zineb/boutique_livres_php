<?php
    include '../include/connexion.php';

    if (isset($_POST['ajouter'])) {   
        $titre = $_POST['titre'];
        $nbpage = $_POST['nbpage'];
        $langue = $_POST['langue'];
        $editionn = $_POST['editionn'];
        $datepublication = $_POST['datepublication'];
        $descriptionn = $_POST['descriptionn'];
        $note = $_POST['note'];
        $prix = $_POST['prix'];
        $remise = $_POST['remise'];
        $qteS = $_POST['qteS'];
        $auteur = $_POST['auteur'];
        $categories = isset($_POST['categories']) ? $_POST['categories'] : [];

        // Vérifier si le fichier a été téléchargé
        if (isset($_FILES['inputImage']) && $_FILES['inputImage']['error'] == 0) {
            $file_name = $_FILES['inputImage']['name'];
            $file_size = $_FILES['inputImage']['size'];
            $file_tmp = $_FILES['inputImage']['tmp_name'];
            $file_type = $_FILES['inputImage']['type'];

            // Vérification des champs
            $fields = [
                'titre' => $titre,
                'nbpage' => $nbpage,
                'langue' => $langue,
                'editionn' => $editionn,
                'datepublication' => $datepublication,
                'descriptionn' => $descriptionn,
                'note' => $note,
                'prix' => $prix,
                'remise' => $remise,
                'qteS' => $qteS,
                'id_a' => $auteur
            ];

            $emptyFields = array_filter($fields, function($value) {
                return empty($value);
            });

            if (empty($emptyFields)) {
                $uniqueFileName = uniqid() . '.png';
                $targetFilePath = "../uploads/" . $uniqueFileName;
            
                if (move_uploaded_file($file_tmp, $targetFilePath)) {
                    $pdo->beginTransaction();
                    try {
                        $req = $pdo->prepare("INSERT INTO produit (titre, nbpage, langue, editionn, datepublication, descriptionn, note, prix, remise, qteS, img, id_a) 
                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");

                        if ($req->execute(array($titre, $nbpage, $langue, $editionn, $datepublication, $descriptionn, $note, $prix, $remise, $qteS, $uniqueFileName, $auteur))) {
                            $productId = $pdo->lastInsertId();

                            // Insertion des catégories sélectionnées
                            if (!empty($categories)) {
                                $insertCatStmt = $pdo->prepare("INSERT INTO prod_categ (id_prod, id_c) VALUES (?, ?)");
                                foreach ($categories as $categorieId) {
                                    $insertCatStmt->execute([$productId, $categorieId]);
                                }
                            }

                            $pdo->commit();
                            header('Location: ../Admin/indexAdmin.php?page=produitAdmin');
                            exit;
                        } else {
                            throw new Exception('Erreur lors de l\'ajout du produit.');
                        }
                    } catch (Exception $e) {
                        $pdo->rollBack();
                        echo 'Erreur : ' . $e->getMessage();
                    }
                } else {
                    echo "Erreur lors du téléchargement de l'image.";
                }
            } else {
                echo 'Les champs suivants ne peuvent pas être vides : ' . implode(', ', array_keys($emptyFields)) . '.';
            }
        } else {
            echo 'Erreur lors du téléchargement de l\'image.';
        }
    }



    // Récupérer les auteurs pour le select
    // try {
    //     $stmt = $pdo->prepare("SELECT id_a, nomComplet FROM auteur");
    //     $stmt->execute();
    //     $auteurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // } catch(PDOException $e) {
    //     echo "Erreur : " . $e->getMessage();
    // }



    if (isset($_POST['modifier'])) {
        $id_prod = htmlspecialchars($_POST['id_prod']);
        $titre = htmlspecialchars($_POST['titre']);
        $nbpage = htmlspecialchars($_POST['nbpage']);
        $langue = htmlspecialchars($_POST['langue']);
        $editionn = htmlspecialchars($_POST['editionn']);
        $datepublication = htmlspecialchars($_POST['datepublication']);
        $descriptionn = htmlspecialchars($_POST['descriptionn']);
        $note = htmlspecialchars($_POST['note']);
        $prix = htmlspecialchars($_POST['prix']);
        $remise = htmlspecialchars($_POST['remise']);
        $qteS = htmlspecialchars($_POST['qteS']);
        $id_a = htmlspecialchars($_POST['id_a']);

        $img = $_FILES['img']['name'];
        $imgPath = null;

        if ($img) {
            $imgPath = '../uploads/' . basename($img);
            if (!move_uploaded_file($_FILES['img']['tmp_name'], $imgPath)) {
                echo "Erreur lors du téléchargement de l'image.";
                exit;
            }
        }

        try {
            $sql = 'UPDATE produit SET titre = ?, nbpage = ?, langue = ?, editionn = ?, datepublication = ?, descriptionn = ?, note = ?, prix = ?, remise = ?, qteS = ?, id_a = ?';
            $params = [$titre, $nbpage, $langue, $editionn, $datepublication, $descriptionn, $note, $prix, $remise, $qteS, $id_a, $id_prod];

            if ($imgPath) {
                $sql .= ', img = ? WHERE id_prod = ?';
                array_splice($params, -1, 0, $img);
            } else {
                $sql .= ' WHERE id_prod = ?';
            }

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);

            header('Location: ../Admin/indexAdmin.php?page=produitAdmin');
            exit;
            
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }

    if (isset($_GET['id'])) {
        $id = htmlspecialchars($_GET['id']);
    
        try {
            $stmt = $pdo->prepare('DELETE FROM produit WHERE id_prod = ?');
            $stmt->execute([$id]);
    
            // Redirigez vers la page de liste des produits après suppression
            header('Location: ../Admin/indexAdmin.php?page=produitAdmin');
            exit;
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            exit;
        }
    }
?>
