<?php $title = 'Admin'; ?>

<?php ob_start(); ?>
<div class="title">
	<h1>Gestion Utilisateurs</h1>
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
        <div class="other-pages"><a href="index.php?action=userManagement&amp;page=<?= $i ?>"> <?= $i ?> </a></div>
        <?php 
        }
    }
    ?>
</div>

<?php
while ($user = $users->fetch()) {
?>
	<div class="admin-user">
		<div class="admin-user-avatar">
			<img src="<?= $user['avatar_url'] ?>">
		</div>
		<div class="admin-user-name">
			<h2><?= $user['name'] ?></h2>
		</div>
		<div class="admin-user-id">
			<p>ID : <?= $user['id'] ?></p>
		</div>
		<div class="admin-user-register-date">
			<p>Date d'inscription : <?= $user['register_date_fr'] ?></p>
		</div>
		<div class="admin-user-email">
			<p>E-mail : <?= $user['email'] ?></p>
		</div>
		<div class="admin-user-score">
			<p>Meilleur Score : <?= $user['highest_score'] ?></p>
		</div>
		<div class="admin-user-total">
			<p>Nombre de parties jouées : <?= $user['total_games'] ?></p>
		</div>
		<div class="admin-user-sign">
			<p>Signature : <?= $user['signature'] ?></p>
		</div>
		<div class="admin-user-status">
			<p>Status : <?= $user['status'] ?></p>
		</div>
		<div class="admin-user-status-button">
			<?php
			if ($user['status'] === "admin")
			{
			?>
			<p>&#x2605;</p>
			<?php
			}
			elseif ($user['status'] === "blocked")
			{
			?>
			<a href="index.php?action=unblockUser&amp;id=<?= $user['id'] ?>">Débloquer&#128281;</a>
			<?php
			}
			else
			{
			?>
			<a href="index.php?action=blockUser&amp;id=<?= $user['id'] ?>">Bloquer&#128683;</a>
			<?php
			}
			?>
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
        <div class="other-pages"><a href="index.php?action=userManagement&amp;page=<?= $i ?>"> <?= $i ?> </a></div>
        <?php 
        }
    }
    ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>