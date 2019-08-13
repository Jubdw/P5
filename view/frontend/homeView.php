<?php $title = 'Elle est où la poulette ?'; ?>

<?php ob_start(); ?>
<div class="title">
    <h1>À Kadoc !</h1>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>