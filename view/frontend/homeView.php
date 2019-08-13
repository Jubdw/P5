<?php $title = 'Elle est où la poulette ?'; ?>

<?php ob_start(); ?>
<div class="title">
    <h1>Elle est ou la poulette ?</h1>
</div>

<div class="home-news-tilte">
	<h3>Les dernières nouvelles concernant la poulette !</h3>
    <em>(ou pas)</em>
</div>

<div class="home-news">
<?php
while ($data = $news->fetch())
{
?>
    <div class="h-news">
        <div class="news-title">
            <h3><a href="#"><?= $data['title'] ?></a></h3>
        </div><br>
        <em>le <?= $data['creation_date_fr'] ?></em>

        <p><?= nl2br($data['small_content']) ?> ... <em><a href="#">Lire la suite</a></em></p>
    </div><br>
<?php
}
?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>