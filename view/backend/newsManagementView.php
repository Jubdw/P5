<?php $title = 'Admin'; ?>

<?php ob_start(); ?>
<div class="title">
	<h1>Gestion News</h1>
	<a href="index.php?action=admin">Retour admin</a>
</div>

<div class="create-news">
	<a href="index.php?action=createNews">Écrire une news</a>
</div>

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
        <div class="other-pages"><a href="index.php?action=newsManagement&amp;page=<?= $i ?>"> <?= $i ?> </a></div>
        <?php 
        }
    }
    ?>
</div>

<?php
while ($post = $news->fetch())
{
?>
	<div class="admin-news">
		<div class="admin-news-id">
			<p>ID : <?= $post['id'] ?></p>
		</div>
		<div class="admin-news-title">
			<p><?= $post['title'] ?></p>
		</div>
		<div class="admin-news-date">
			<p>Le : <?= $post['creation_date_fr'] ?></p>
		</div>
		<div class="admin-news-content">
			<p><?= $post['small_content'] ?> ... <a href="index.php?action=news&amp;id=<?= $post['id'] ?>">Lire la suite</a></p>
		</div>
		<div class="admin-news-button-edit">
			<p><a href="index.php?action=showNewsToEdit&amp;id=<?= $post['id'] ?>">Modifier</a> | <a href="index.php?action=deleteNews&amp;id=<?= $post['id'] ?>" onclick="return(confirm('Cette action est définitive. Etes-vous sûr de vouloir supprimer ce post ?'));">Effacer</a></p>
		</div>
	</div>
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
        <div class="other-pages"><a href="index.php?action=newsManagement&amp;page=<?= $i ?>"> <?= $i ?> </a></div>
        <?php 
        }
    }
    ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>