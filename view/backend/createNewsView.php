<?php $title = 'Admin'; ?>

<?php ob_start(); ?>
<div class="title">
	<h1>Nouvelle News</h1>
	<a href="index.php?action=admin">Retour admin</a>
</div>

<div class="admin-news-form">
	<form action="index.php?action=addNews" method="post">
		<div>
			<label for="title">Titre :</label><br>
			<input type="text" name="title" /><br>

            <label for="news-content">Content :</label><br>
            <textarea id="news-content" name="content" rows="10" cols="80"></textarea><br>
        </div>
        <div>
            <input type="submit" />
        </div><br>
	</form>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>