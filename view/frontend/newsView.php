<?php $title = "Actus-Poulette"; ?>

<?php ob_start(); ?>

<div class="title">
    <h1>Actus de la Poulette</h1>
</div>

<div class="links">
	<p><a href="index.php">Retour à l'acceuil</a></p><br>
    <p><a href="index.php?action=listNews&amp;page=1">Retour à la liste des news</a></p><br>
</div>

<div class="news news-post">
    <div class="news-title">
        <h2><?= $news['title'] ?></h2>
        <em>le <?= $news['creation_date_fr'] ?></em>
    </div><br>

    <p><?= $news['content'] ?><br></p>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>