<?php $title = 'Elle est où la poulette ?'; ?>

<?php ob_start(); ?>
<div id="canvas-div">
	<canvas id="canvas-game">Votre navigateur ne supporte pas HTML5, veuillez le mettre à jour pour jouer.</canvas>
</div>

<script src="public/js/map.js"></script>
<script src="public/js/app.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>