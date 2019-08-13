<!DOCTYPE html>
<html lang="fr">
	<head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="public/css/style.css" rel="stylesheet" />
    </head>

    <body>

    	<header>
    		<div class="header-logo"><a href="index.php"><img src="public/images/logo.png" alt="Elle est où la poulette ?"></a></div>
    		<nav>
    			<ul>
    				<li><a href="#">Actus</a></li>
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

    	<footer>
            <div id="legal">
                <p>Copyright © 2019 - Julien Barré - Tous droits réservés - <a href="#">Mentions Légales</a> | Site réalisé par <a href="https://julienbarre.fr">JBDW</a></p>
                <div class="footer-links">
                <p>Plan du site : <a href="index.php">Acceuil</a> | <a href="#">Actus</a> | <a href="#">À propos</a> | <a href="#">Contact</a> | <a href="#">Scores</a> | <?php if (isset($_SESSION['id']) AND isset($_SESSION['name'])) { ?><span class="profile-link"><a href="#"><?php echo $_SESSION['name'] ?></a></span> | <a href="index.php?action=logout">Déconnexion</a><?php } else { ?><a href="index.php?action=register">Connexion</a><?php }?></p>
                </div>
            </div>
    	</footer>

    </body>
</html>
