<?php $title = 'Elle est où la poulette ?'; ?>

<?php ob_start(); ?>
<div class="poulette">
    <div class="welcome">
        <div class="welcome-title">
            <h1>Elle est ou la poulette ?</h1>
        </div>
        <div class="welcome-quote">
            <span id="citation"><?= $quote ?></span>
        </div>
        <div class="welcome-play-button">
            <a href="index.php?action=play">Jouer</a>
        </div>
        <div class="welcome-scroll-button">
            <div id="scroll-bottom">&#9660;</div>
        </div>
    </div>
    <div class="poulette-background"><img src="public/images/<?= $background ?>.jpg"></div>
</div>

<div class="separation"></div>

<div class="home-content">
    <div class="content-home-scores">
        <div class="home-scores-title">
            <h1><a href="index.php?action=listScores&amp;page=1">Les meilleurs scores</a></h1>
        </div>

        <?php
        while ($data = $scores->fetch())
        {
        ?>
            <div class="home-scores">
                <div class="home-scores-name">
                    <p><?= $data['user_name'] ?></p>
                </div>
                <div class="home-scores-value">
                    <p><?= $data['value'] ?></p>
                </div>
                <div class="home-scores-link profile-link">
                    <a href="index.php?action=showProfile&amp;id=<?= $data['user_id'] ?>&amp;page=1" title="Voir le profil">👤</a>
                </div>  
            </div><br>
        <?php
        }
        ?>
    </div>

    <div class="home-news-title">
    	<h1><a href="index.php?action=listNews&amp;page=1">Les dernieres nouvelles</a></h1>
    </div>

    <div class="home-news">
        <?php
        while ($data = $news->fetch())
        {
        ?>
            <div class="h-news">
                <div class="news-title">
                    <h3><a href="index.php?action=news&amp;id=<?= $data['id'] ?>"><?= $data['title'] ?></a></h3>
                </div><br>
                <em>le <?= $data['creation_date_fr'] ?></em>

                <p><?= nl2br($data['small_content']) ?> ... <em><a href="index.php?action=news&amp;id=<?= $data['id'] ?>">Lire la suite</a></em></p>
            </div><br>
        <?php
        }
        ?>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>