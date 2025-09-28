<?php
// Recupere les valeurs des champs en enlevant espaces avant et apres la valeur 
$title = isset($_POST['titre']) ? trim($_POST['titre']) : '';
$artiste = isset($_POST['artiste']) ? trim($_POST['artiste']) : '';
$img = isset($_POST['image']) ? trim($_POST['image']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';

// Connexion BDD
require_once __DIR__ . '/bdd.php';

// Variable de toutes les erreurs possible 
$errors = [];

// Validation des champs celon cahier des charges
if (empty($title)) {
    $errors['title'] = "Vous devez renseigner un titre.";
}

if (empty($artiste)) {
    $errors['artiste'] = "Vous devez renseigner un artiste.";
}

if (empty($img) || !filter_var($img, FILTER_VALIDATE_URL)) {
    $errors['image'] = "L'URL de l'image n'est pas valide.";
}

if (empty($description) || mb_strlen($description) < 3) {
    $errors['description'] = "Vous devez renseigner une description de pljus de trois caracteres.";
}

// Si il y au moins une erreur l'utilisateur est redirige sur la pasge ajouter.php
if (!empty($errors)) {
    header('Location: ajouter.php');
    exit;
} 
// Ajout a la BDD
else {
    try {
        // Requete SQL
        $sql = "INSERT INTO oeuvres (titre, description, artiste, image) VALUES (:titre, :description, :artiste, :image)";
        $statmentOeuvre = $pdo->prepare($sql);
        // Valeurs a transmettre
        $statmentOeuvre->execute([
            ':titre' => $title,
            ':description' => $description,
            ':artiste' => $artiste,
            ':image' => $img,
        ]);

        // Recuperation du dernier id ajoute
        $lastId = $pdo->lastInsertId();
        // Redirection vers page de l'oeuvre qui vient d'etre ajoutee
        header('Location: oeuvre.php?id=' . urlencode($lastId));
        exit;
    }
    // En cas d'erreur 
    catch (PDOException $e) {
        // Affiche l'erreur
        die('Erreur: '.$e->getMessage());

        // Redirection vers la page ajouter.php
        header('Location: ajouter.php');
        exit;
    }
}
?>