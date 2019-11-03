<?php $title = 'Admin'; ?>

<?php ob_start(); ?>
<div class="title">
	<h1>Gestion admin</h1>
</div>

<div class="management-link">
	<a href="index.php?action=userManagement&amp;page=1">Utilisateurs</a>
</div>

<div class="management-link">
	<a href="index.php?action=commentManagement&amp;page=1">Commentaires</a>
</div>

<div class="management-link">
	<a href="index.php?action=newsManagement&amp;page=1">Actus</a>
</div>


<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>