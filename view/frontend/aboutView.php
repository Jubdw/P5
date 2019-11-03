<?php $title = "Arthour !.. Couillère !"; ?>

<?php ob_start(); ?>
<div class="title">
	<h1>Arthour ... Couillere</h1>
	<a href="index.php">Retour à l'acceuil</a>
</div>

<div class="about">
	<h2>Qu'est ce a dire que ceci ?!</h2>
	<p>Ce site est realisé dans le cadre du projet 5 du parcours Développeur Web Junior de <a href="https://openclassrooms.com/fr">Openclassrooms</a>. Étant libre dans le choix de l'application pour ce projet, j'ai décidé de coder en JS ce petit jeu de chasse à la poulette. Les règles sont simples, déplacez le personnage avec ZQSD ou les flèches directionnelles et appuyez sur E ou la barre espace pour effectuer une action : ramasser des objets qui vous rapportent des points ou attraper la poulette. Une fois celle-ci attrapée ou une fois les 2 minutes écoulées, la partie se termine et le total des points est compté. Vous devez vous inscrire à l'espace membre pour pouvoir jouer. Ne vous inquiétez pas, je ne demande qu'un pseudo et une adresse mail (même fausse) pour se connecter.</p><br>
	<p>Si ce jeu ou le site ont réussi à au moins vous faire souffler du nez, vous pouvez poster un commentaire plus bas sur cette page. N'hésitez pas à me faire part de vos impressions !</p><br>
	<span id="about-quote">"Odi panem quid meliora"</span><br>
	<p> Ça ne veut rien dire, mais je trouve que ça boucle bien.</p>
</div>

<div id="comment-section">
	<?php 
    if (isset($_SESSION['id']) AND isset($_SESSION['name'])) 
    {
    ?>
    <h2>Commentaires</h2>
    <p>Écrivez un commentaire en tant que : <?= $_SESSION['name'] ?></p>
    <form action="index.php?action=postComment" method="post">
        <div>
            <label for="comment">Commentaire</label><br>
            <textarea id="comment" name="comment" rows="8" cols="40"></textarea>
        </div>
        <div>
            <input type="submit" />
        </div>
    </form>
    <?php 
    }
    else
    {
    ?>
    <p>Connectez-vous ou inscrivez-vous à l'espace membre pour pouvoir rédiger un commentaire.</p>
    <a href="index.php?action=register">Connexion | Inscription</a>
    <?php 
    }
    ?>
</div>
<div class="comment-list">
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
	        <div class="other-pages"><a href="index.php?action=about&amp;page=<?= $i ?>"> <?= $i ?> </a></div>
	        <?php 
	        }
	    }
	    ?>
	</div>
	<?php
	while ($comment = $comments->fetch())
	{
	?>
	<div class="comment">
		<p><strong><a href="index.php?action=showProfile&amp;id=<?= $comment['user_id'] ?>&amp;page=1"><?= $comment['user_name'] ?></a></strong> le <?= $comment['comment_date_fr'] ?></p>
		<p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
		<?php
        if (isset($_SESSION['id'])) {
            if ($_SESSION['id'] == $comment['user_id']) 
            {
            ?>
            <div class="link-update"><a href="index.php?action=update&amp;id=<?= $comment['id'] ?>">&#9997; Modifier &#9997;</a></div>
            <?php
            }
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
	        <div class="other-pages"><a href="index.php?action=about&amp;page=<?= $i ?>"> <?= $i ?> </a></div>
	        <?php 
	        }
	    }
	    ?>
	</div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>