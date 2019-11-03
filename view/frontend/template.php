<!DOCTYPE html>
<html lang="fr">
	<head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="public/css/style.css" rel="stylesheet" />
        <link rel="apple-touch-icon" sizes="57x57" href="public/images/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="public/images/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="public/images/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="public/images/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="public/images/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="public/images/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="public/images/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="public/images/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="public/images/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="public/images/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="public/images/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="public/images/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="public/images/favicon/favicon-16x16.png">
        <script src="public/js/jquery-3.3.1.js"></script>
        <script src="public/js/ajax.js"></script>
        <script src="public/js/scroll.js"></script>
    </head>

    <body>

    	<header>
    		<div class="header-logo"><a href="index.php"><img src="public/images/logo.png" alt="Elle est où la poulette ?"></a></div>
    		<nav>
    			<ul>
                    <li><a href="index.php?action=about&amp;page=1">Qu'est ce à dire que ceci ?!</a></li>
    				<li><a href="index.php?action=listNews&amp;page=1">Actus</a></li>
    				<li><a href="index.php?action=listScores&amp;page=1">Scores</a></li>
    				<?php 
                    if (isset($_SESSION['id']) AND isset($_SESSION['name'])) {
                        ?>
                        <li><p class="profile-link"><a href="index.php?action=showProfile&amp;id=<?= $_SESSION['id'] ?>&amp;page=1"><?php echo $_SESSION['name'] ?></a></p></li>
                        <li><a href="index.php?action=logout">Déconnexion</a></li>
                        <?php
                        if (isset($_SESSION['status']) AND $_SESSION['status'] === "admin") {
                        ?>
                        <li class="admin-link"><a href="index.php?action=admin&amp;page=1">Administration du site</a></li>
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
