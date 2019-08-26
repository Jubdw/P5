<?php $title = 'Elle est où la poulette ?'; ?>

<?php ob_start(); ?>
<div class="title poulette">
    <h1>Elle est ou la poulette ?</h1>
    <a href="index.php?action=play">jouer</a>
    <span id="citation"></span>
</div>
<div class="animation-poulette">
    <h2>div anim poulette</h2>
</div>

<div class="home-news-title">
	<h3><a href="index.php?action=listNews&amp;page=1">Les dernières nouvelles concernant la poulette !</a></h3>
    <em>(ou pas)</em><br>
</div>

<div class="home-news">
<?php
while ($data = $news->fetch())
{
?>
    <div class="h-news">
        <div class="news-title">
            <h3><a href="index.php?action=news&amp;id=<?= $data['id'] ?>"><?= $data['title'] ?></a></h3>
        </div><br>
        <em>le <?= $data['creation_date_fr'] ?></em>

        <p><?= nl2br($data['small_content']) ?> ... <em><a href="index.php?action=news&amp;id=<?= $data['id'] ?>">Lire la suite</a></em></p>
    </div><br>
<?php
}
?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>