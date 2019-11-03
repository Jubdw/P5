<?php $title = "Les Scores"; ?>

<?php ob_start(); ?>
<div class="title">
	<h1>scores</h1>
	<a href="index.php">Retour à l'acceuil</a>
</div>

<div class="score-div">
	<div id="list-best-scores">
		<div class="sub-title">
			<h2>Les meilleurs joueurs</h2>
		</div>
		<div class="container-best container-names">
			<div class="column-item column-name">
				<p>Nom</p>
			</div>
			<div class="column-item">
				<p>Score</p>
			</div>
			<div class="column-item">
				<p>Nombre de parties</p>
			</div>
		</div>
		<?php
		while ($userData = $user->fetch())
		{
		?>
		    <div class="container-best">
		    	<div class="avatar">
		        	<img src="<?= $userData['avatar_url'] ?>" alt="Avatar de <?= $userData['name'] ?>">
		        </div>
		    	<div class="user-name">
		        	<p><?= $userData['name'] ?></p>
		        </div>
		        <div class="score">
		        	<p><?= $userData['highest_score'] ?></p>
		        </div>
		        <div class="total-games">
		        	<p><?= $userData['total_games'] ?></p>
		        </div>
		        <div class="user-profile-link">
		        	<a href="index.php?action=showProfile&amp;id=<?= $userData['id'] ?>&amp;page=1" title="Voir le profil">👤</a>
		        </div>
		    </div>
		<?php
		}
		?>

	</div>

	<div id="list-all-scores">
		<div class="sub-title">
			<h2>Tous les scores</h2>
		</div>
		
		<div class="container-all">
			<div class="column-item column-position">
				<p>Position</p>
			</div>
			<div class="column-item">
				<p>Nom</p>
			</div>
			<div class="column-item">
				<p>Score</p>
			</div>
		</div>
		<?php
		$rank = ($currentPage * 10) - 10 + 1;
		while ($scoreData = $scores->fetch())
		{
		?>
		<div class="container-all">
			<div class="rank">
				<p><?= $rank ?></p>
				<?php
				$rank++
				?>
			</div>
	    	<div class="all-user-name">
	        	<p><?= $scoreData['user_name'] ?></p>
	        </div>
	        <div class ="all-score">
	        	<p><?= $scoreData['value'] ?></p>
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
		        <div class="other-pages"><a href="index.php?action=listScores&amp;page=<?= $i ?>#list-all-scores"> <?= $i ?> </a></div>
		        <?php 
		        }
		    }
		    ?>
		</div>
	</div>
</div>


<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>