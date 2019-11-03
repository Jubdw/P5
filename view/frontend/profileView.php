<?php 
if (isset($_SESSION['id']) && $_SESSION['id'] == $_GET['id']) {
	$title = "Votre profil";
	$u_com = "Vos commentaires";
}
if (!isset($_SESSION['id']) || $_SESSION['id'] != $_GET['id']) {
	$title = "Profil du membre " . $profile['name'];
	$u_com = "Commentaires de " . $profile['name'];
}
?>

<?php ob_start(); ?>
<div class="title">
	<h1><?= $title ?></h1>
	<a href="index.php">Retour à l'acceuil</a>
</div>

<div class="user-profile">
	<div class="user-avatar">
		<img src="<?= $profile['avatar_url'] ?>">
	</div>

	<div class="user-info">
		<h2><?= $profile['name'] ?></h2>
		<div class="games-data">
			<p>Meilleur Score : </p>
			<div class="user-score">
				<p><?= $profile['highest_score'] ?></p>
			</div>
			<p>sur <strong><?= $profile['total_games'] ?></strong> parties jouées</p>
		</div>

		<p>Signature :</p>
		<div class="user-signature">
			<p><?= $profile['signature'] ?></p>
		</div><br>

		<?php
		if (isset($_SESSION['id']) && $_SESSION['id'] == $_GET['id']) {
		?>
			<em>E-mail : <a href="mailto:<?= $profile['email'] ?>"><?= $profile['email'] ?></a></em>
		<?php
		}
		?>

		<em><p>Membre depuis le : <?= $profile['register_date_fr'] ?></p></em>

		<?php 
		if (isset($_SESSION['id']) && $_SESSION['id'] == $_GET['id']) {
		?>
			<div class="link-edit">
				<a href="index.php?action=editProfile">Modifier votre profil</a>
			</div>
		<?php
		}
		?>
	</div>

</div>

<?php 
if ($commentNb > 0) {
?>
<div>
	<h4><?= $u_com ?></h4>
</div>

<div class="user-comments">
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
            <div class="other-pages"><a href="index.php?action=showProfile&id=<?= $_GET['id'] ?>&page=<?= $i ?>"> <?= $i ?> </a></div>
            <?php 
            }
        }
        ?>
    </div>
	<?php 
	while ($data = $userComments->fetch())
	{
	?>
	<div class="comment">
		<p><em>le <?= $data['comment_date_fr'] ?></em></p>
		<p><?= nl2br(htmlspecialchars($data['comment'])) ?></p>
		<?php
		if (isset($_SESSION['id']) && $_SESSION['id'] == $_GET['id']) {
			?>
			<div class="link-update"><a href="index.php?action=update&amp;id=<?= $data['id'] ?>">&#9997; Modifier &#9997;</a></div>
			<?php
		}
		?>
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
            <div class="other-pages"><a href="index.php?action=showProfile&id=<?= $_GET['id'] ?>&page=<?= $i ?>"> <?= $i ?> </a></div>
            <?php 
            }
        }
        ?>
    </div>
</div>
<?php 
}
?>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>