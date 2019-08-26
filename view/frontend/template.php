<!DOCTYPE html>
<html lang="fr">
	<head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="public/css/style.css" rel="stylesheet" />
        <script src="public/js/jquery-3.3.1.js"></script>
        <script src="public/js/ajax.js"></script>
        <script src="public/js/map.js"></script>
        <script src="public/js/scroll.js"></script>
    </head>

    <body>

    	<header>
    		<div class="header-logo"><a href="index.php"><img src="public/images/logo.png" alt="Elle est où la poulette ?"></a></div>
    		<nav>
    			<ul>
    				<li><a href="index.php?action=listNews&amp;page=1">Actus</a></li>
    				<li><a href="#">À propos</a></li>
    				<li><a href="#">Contact</a></li>
    				<li><a href="#">Scores</a></li>
    				<?php 
                    if (isset($_SESSION['id']) AND isset($_SESSION['name'])) {
                        ?>
                        <li><p class="profile-link"><a href="#"><?php echo $_SESSION['name'] ?></a></p></li>
                        <li><a href="index.php?action=logout">Déconnexion</a></li>
                        <?php
                        if (isset($_SESSION['status']) AND $_SESSION['status'] === "admin") {
                        ?>
                        <li class="admin-link"><a href="#">Administration du site</a></li>
                        <?php
                        }
                    }
                    else {
                        ?>
                        <li><a href="index.php?action=register">Connexion</a></li>
                        <?php
                    }
                    ?>
    			</ul>
    		</nav>
    	</header>

    	<div id="content">
        <?= $content ?>
    	</div>

        <div><a id="b-Back" class="b-Hidden" href="#up"></a></div>

    	<footer>
            <div id="legal">
                <p>Copyright © 2019 - <a href="https://julienbarre.fr">JBDW</a></p>
                <p>Kaamelott est la propriété d'Alexandre Astier.</p>
            </div>
    	</footer>

    </body>
</html>
