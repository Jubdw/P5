<?php $title = 'Admin'; ?>

<?php ob_start(); ?>
<div class="title">
	<h1>Modifier News</h1>
	<a href="index.php?action=admin">Retour admin</a>
</div>

<?php
$news = $newsToEdit->fetch();
?>

<div class="admin-news-form">
	<form action="index.php?action=addNews" method="post">
		<div>
			<label for="title">Titre :</label><br>
			<input type="text" name="title" value="<?= $news['title'] ?>" /><br>

            <label for="news-content">Content :</label><br>
            <textarea id="news-content" name="content" rows="10" cols="80"><?= $news['content'] ?></textarea><br>
        </div>
        <div>
            <input type="submit" />
        </div><br>
	</form>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>