<?php
    require 'header.php';
    require_once (__DIR__ . '/bdd.php');

    // Connexion BDD
    $pdo = getPDO();
    // Recupartion id dans URL
    $id = $_GET['id'];
    // Requete SQL
    $oeuvreStatment = $pdo->prepare('SELECT * FROM oeuvres WHERE id = ?');
    $oeuvreStatment->execute([$id]);
    $oeuvre = $oeuvreStatment->fetch();

    // Si l'URL ne contient pas d'id ou que l'id n'est pas present dans la BDD, on redirige vers la page d'accueil
    if(!$id || !$oeuvre) {
        header('Location: index.php');
        exit;
    }
?>

<article id="detail-oeuvre">
    <div id="img-oeuvre">
        <img src="<?= $oeuvre['image'] ?>" alt="<?= $oeuvre['titre'] ?>">
    </div>
    <div id="contenu-oeuvre">
        <h1><?= $oeuvre['titre'] ?></h1>
        <p class="description"><?= $oeuvre['artiste'] ?></p>
        <p class="description-complete">
             <?= $oeuvre['description'] ?>
        </p>
    </div>
</article>

<?php require 'footer.php'; ?>
