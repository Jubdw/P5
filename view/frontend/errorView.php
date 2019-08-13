<?php $title = 'Erreur'; ?>

<?php ob_start(); ?>
<div class="title">
	<h1>Une erreur a eu lieu</h1>
</div>

<div class="error-div">
	<img src="public/images/error-logo.png" alt="error">
	<p><?php echo 'Erreur : ' . $e->getMessage(); ?></p>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>