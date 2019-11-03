<?php $title = 'Admin'; ?>

<?php ob_start(); ?>
<div class="title">
	<h1>Gestion des Commentaires</h1>
	<a href="index.php?action=admin">Retour admin</a>
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
        <div class="other-pages"><a href="index.php?action=commentManagement&amp;page=<?= $i ?>"> <?= $i ?> </a></div>
        <?php 
        }
    }
    ?>
</div>

<?php
while ($comment = $comments->fetch())
{
?>
	<div class="admin-comment">
		<div class="admin-comment-id">
			<p>ID : <?= $comment['id'] ?></p>
		</div>
		<div class="admin-comment-user-id">
			<p>user ID : <?= $comment['user_id'] ?></p>
		</div>
		<div class="admin-comment-user-name">
			<p><?= $comment['user_name'] ?></p>
		</div>
		<div class="admin-comment-date">
			<p>le : <?= $comment['comment_date_fr'] ?></p>
		</div>
		<div class="admin-comment-comment">
			<p>"<?= $comment['comment'] ?>"</p>
		</div>
		<div class="admin-comment-delete">
			<a href="index.php?action=deleteComment&amp;id=<?= $comment['id'] ?>" onclick="return(confirm('Cette action est définitive. Etes-vous sûr de vouloir supprimer ce commentaire ?'));">&#10060; Effacer &#10060;</a>
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
        <div class="other-pages"><a href="index.php?action=commentManagement&amp;page=<?= $i ?>"> <?= $i ?> </a></div>
        <?php 
        }
    }
    ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>