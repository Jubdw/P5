<?php $title = "Toutes les actus de la Poulette"; ?>

<?php ob_start(); ?>
<div class="title">
    <h1>Toutes les actus de la Poulette</h1>
    <a href="index.php">Retour à l'acceuil</a>
</div>

<div class="list-news">
	<div class="paging">
	    <?php 
	    for ($i = 1; $i <= $maxPages; $i++) {
	        if ($i == $currentPage) 
	        {
	        ?>
	        <div class="current-page"><p> <?= $i ?> </p></div>
	        <?php 
	        }
	        else 
	        {
	        ?>
	        <div class="other-pages"><a href="index.php?action=listNews&amp;page=<?= $i ?>"> <?= $i ?> </a></div>
	        <?php 
	        }
	    }
	    ?>
	</div>
	<?php
	while ($data = $news->fetch())
	{
	?>
	    <div class="news">
	        <div class="news-title">
	            <h2><a href="index.php?action=news&amp;id=<?= $data['id'] ?>"><?= $data['title'] ?></a></h2>
	            <em>le <?= $data['creation_date_fr'] ?></em>
	        </div><br>

	        <p><?= nl2br($data['small_content']) ?> ... <em><a href="index.php?action=news&amp;id=<?= $data['id'] ?>">Lire la suite</a></em></p>
	    </div><br>
	<?php
	}
	?>
	<div class="paging">
	    <?php 
	    for ($i = 1; $i <= $maxPages; $i++) {
	        if ($i == $currentPage) 
	        {
	        ?>
	        <div class="current-page"><p> <?= $i ?> </p></div>
	        <?php 
	        }
	        else 
	        {
	        ?>
	        <div class="other-pages"><a href="index.php?action=listPosts&amp;page=<?= $i ?>"> <?= $i ?> </a></div>
	        <?php 
	        }
	    }
	    ?>
	</div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>