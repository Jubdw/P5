<?php 
if (!isset($_SESSION['name'])) {
	header('Location: index.php?action=register');
}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
        <meta charset="utf-8" />
        <title>Elle est où la poulette ?</title>
        <link href="public/css/style.css" rel="stylesheet" />
        <script src="public/js/jquery-3.3.1.js"></script>
        <script src="public/js/ajax.js"></script>
    </head>

    <body>
    	<div id="canvas-div">

	    	<div id="hud">
	    		<a href="index.php"><img src="public/images/logo.png" alt="Elle est où la poulette ?"></a>
	    		<p id ="hud-timer">Temps restant</p>
	    		<p id="hud-score">Score : 0</p>
	    		<p id ="hud-player-name"><a href="index.php?action=showProfile&amp;id=<?= $_SESSION['id'] ?>&amp;page=1" title="Voir le profil"><?= $_SESSION['name'] ?></a></p>
	    	</div>

			<canvas id="canvas-game">Votre navigateur ne supporte pas HTML5, veuillez le mettre à jour pour jouer.</canvas>

			<div id="game-sounds"></div>

		</div>

		<script src="public/js/map.js"></script>
		<script src="public/js/app.js"></script>

	</body>
</html>
