<?php $title = 'Modifier un commentaire'; ?>

<?php ob_start(); ?>
<div class="titles">
    <h1><?php echo $_SESSION['name'] ?></h1>

    <h2>Modifier un commentaire</h2>
</div>

<?php $onlyComment = $comment->fetch(); ?>

<div class="update-comment">
    <form action="index.php?action=updateComment&amp;id=<?= $_GET['id'] ?>" method="post">
        <div>
            <label for="comment">Modifiez votre commentaire :</label>
            <br>
            <br>
            <textarea id="comment" name="comment" rows="12" cols="60"><?php echo $onlyComment['comment'] ?></textarea>
        </div>
        <br>
        <div>
            <input type="submit" />
        </div>
    </form>
</div>
<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>