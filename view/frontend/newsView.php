<?php $title = "Actus-Poulette"; ?>

<?php ob_start(); ?>

<?php
$newsData = $news->fetch();
?>

<div class="title title-links">
    <h1>Actus de la Poulette</h1>
    <a href="index.php">Retour à l'acceuil</a><br>
    <a href="index.php?action=listNews&amp;page=1">Retour à la liste des news</a>
</div>

<div class="news news-post">
    <div class="news-title">
        <h2><?= $newsData['title'] ?></h2>
        <em>le <?= $newsData['creation_date_fr'] ?></em>
    </div><br>

    <p><?= $newsData['content'] ?><br></p>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>