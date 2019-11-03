<?php

use Ju\Poulette\Model\UserManager;
use Ju\Poulette\Model\NewsManager;
use Ju\Poulette\Model\ScoreManager;
use Ju\Poulette\Model\CommentManager;

require_once('model/UserManager.php');
require_once('model/NewsManager.php');
require_once('model/ScoreManager.php');
require_once('model/CommentManager.php');

// Acceuil ---------------------------------------------------------------------------------
function welcome()
{
    $newsManager = new NewsManager();
    $news = $newsManager->getWelcomeNews();

    $scoreManager = new ScoreManager();
    $scores = $scoreManager->getWelcomeScores();

    $rand = rand(1, 8);
    if ($rand == 1) {
        $quote = "Une fois, à une exécution, je m'approche d'une fille. Pour rigoler, je lui fais : « Vous êtes de la famille du pendu ? »... C'était sa sœur. Bonjour l'approche !";
        $background = "perceval";
    }
    elseif ($rand == 2) {
        $quote = "Victoriae mundis et mundis lacrima. Bon, ça ne veut absolument rien dire, mais je trouve que c’est assez dans le ton..";
        $background = "loth2";
    }
    elseif ($rand == 3) {
        $quote = "Voilà… Moi de mon coté j'avais parié que vous étiez encore trop branquignole pour savoir c'qui était à vous… Je vois que j’ai encore tapé juste !";
        $background = "loth3";
    }
    elseif ($rand == 4) {
        $quote = "Quand je dis que Rome est à la Cité ce que la chèvre est au fromage de chèvre, je veux dire que c'est le petit plus qui est corollaire au noyau mais qui est pas directement dans le cœur du fruit !";
        $background = "merlin";
    }
    elseif ($rand == 5) {
        $quote = "Qu'est-ce que vous voulez, mon p'tit Bohort : entre son épée qui fait de la lumière, son Merlin qui fait pleuvoir des grenouilles et sa Dame du Lac qui se prend pour une truite, il lui manque plus qu'un numéro de trapèze, au roi des Bretons.";
        $background = "leodagan";
    }
    elseif ($rand == 6) {
        $quote = "Mais enfin, ça fait 15 lieues que vous nous pétez les noyaux avec vos bestioles : les moutons, les chèvres, les poules, vous croyez que ça nous intéresse ça ? (...) Oh la la, mais c'est pas vrai, les poules euh… c'est plus ce que c'était, les chèvres c'est pas rentable, maintenant les moutons c'est fastidieux ! Vous savez même pas ce que ça veut dire « fastidieux » !";
        $background = "arthur_hd";
    }
    elseif ($rand == 7) {
        $quote = "J'suis roi de Bretagne, j'ai pas de conseil à recevoir d'une clodo !";
        $background = "arturus_rex";
    }
    else {
        $quote = "Par exemple, vous prenez aujourd’hui. Vous comptez sept jours. Ça vous emmène dans une semaine. Et bien on sera exactement le même jour qu’aujourd’hui… À une vache près, hein… C’est pas une science exacte...";
        $background = "karadoc_de_vannes";
    }
    
	require('view/frontend/homeView.php');
}
// fonctions NewsManager ------------------------------------------------------

function listNews($page)
{
    $newsManager = new NewsManager();

    $countN = $newsManager->countNews();
    $newsNb = $countN['newsNb'];
    $perPage = 5;
    $maxPages = ceil($newsNb/$perPage);
    if ($page <= $maxPages) {
        $currentPage = $page;
    }
    else {
        $currentPage = 1;
    }
    $start = (($currentPage - 1) * $perPage);

    $news = $newsManager->getNewsPaged($start, $perPage);

    require('view/frontend/listNewsView.php');
}

function news()
{
    $newsManager = new NewsManager();
    $news = $newsManager->getNews($_GET['id']);

    require('view/frontend/newsView.php');
}
// fonctions UserManager ------------------------------------------------------

function connect($name)
{
    $userManager = new UserManager();

    $checkPass = $userManager->connectUser($name);

    $isPassCorrect = password_verify($_POST['password'], $checkPass['password']);

    if (!$checkPass)
    {
        throw new Exception('Mauvais identifiant ou mot de passe');
    }
    else
    {
        if ($isPassCorrect) {
            $_SESSION['id'] = $checkPass['id'];
            $_SESSION['name'] = $name;
            $_SESSION['status'] = $checkPass['status'];
            if ($checkPass['status'] == "admin") {
                header('Location: index.php');
            }
            elseif ($checkPass['status'] == "blocked") {
                $_SESSION = array();
                session_destroy();
                throw new Exception('Votre compte à été bloqué. Comportez-vous mieux !');
            }
            else {
                header('Location: index.php');
            }
        }
        else {
            throw new Exception('Mauvais identifiant ou mot de passe');
        }
    }
}

function disconnect()
{
    $_SESSION = array();
    session_destroy();
    header('Location: index.php');
}
function profile($page)
{
    $userManager = new UserManager();
    $profile = $userManager->getUser($_GET['id']);

    $commentManager = new CommentManager();
    $countC = $commentManager->countUserComments($_GET['id']);
    $commentNb = $countC['commentNb'];
    $perPage = 6;
    $maxPages = ceil($commentNb/$perPage);
    if ($page <= $maxPages) {
        $currentPage = $page;
    }
    else {
        $currentPage = 1;
    }
    $start = (($currentPage - 1) * $perPage);

    $userComments = $commentManager->getUserCommentsPaged($_GET['id'], $start, $perPage);

    if ($profile === false) {
        throw new Exception('Ce membre n\'existe pas !');
    }
    else {
        require('view/frontend/profileView.php');
    }
}

function editProfile()
{
    require('view/frontend/updateProfileView.php');
}
function updateName($id, $name)
{
    $userManager = new UserManager();

    $checkUsers = $userManager->getUsers();
    while ($data = $checkUsers->fetch())
    {
        if ($_POST['name'] === $data['name'])
        {
            throw new Exception('Ce pseudo est déjà pris !');
        }
    }


    $updateName = $userManager->editName($id, $name);

    if ($updateName === false) {
        throw new Exception('Impossible d\'effectuer la modification.');
    }
    else {
        $_SESSION['name'] = $name;
        header('Location: index.php?action=showProfile&id=' . $id . '&page=1');
    }
}

function updateEmail($id, $email)
{
    $userManager = new UserManager();

    $checkUsers = $userManager->getUsers();
    while ($data = $checkUsers->fetch())
    {
        if ($_POST['email'] === $data['email'])
        {
            throw new Exception('Cet e-mail est déjà associé à un compte !');
        }
    }

    $updateEmail = $userManager->editEmail($id, $email);

    if ($updateEmail === fasle) {
        throw new Exception('Impossible d\'effectuer la modification.');
    }
    else {
        header('Location: index.php?action=showProfile&id=' . $id . '&page=1');
    }
}

function updatePassword($id, $password)
{
    $userManager = new UserManager();
    $updatePassword = $userManager->editPassword($id, $password);

    if ($updatePassword === fasle) {
        throw new Exception('Impossible d\'effectuer la modification.');
    }
    else {
        header('Location: index.php?action=showProfile&id=' . $id . '&page=1');
    }
}

function upload()
{
    $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
    $filename = $_FILES["avatar"]["name"];
    $filetype = $_FILES["avatar"]["type"];
    $filesize = $_FILES["avatar"]["size"];

    // Vérifie l'extension du fichier
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if(!array_key_exists($ext, $allowed)) {
        throw new Exception("Veuillez sélectionner un format de fichier valide : jpg, jpeg, png, gif");
    }
    $maxsize = 5 * 1024 * 1024;
    if($filesize > $maxsize) {
        throw new Exception("La taille du fichier est supérieure à la limite autorisée : 5Mo");
    }

    if(in_array($filetype, $allowed)){
        // Vérifie si le fichier existe avant de le télécharger.
        if(file_exists("upload/" . $_FILES["avatar"]["name"])){
            throw new Exception("ce fichier existe déjà.");
        } else{
            move_uploaded_file($_FILES["avatar"]["tmp_name"], "upload/" . $_FILES["avatar"]["name"]);
        } 
    } else{
        throw new Exception("Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer."); 
    }

    header('Location: index.php?action=updateAvatar&url=' . $filename);
}

function updateAvatar($id, $url)
{
    $avatarUrl = 'upload/' . $url;

    $userManager = new UserManager();
    $updateAvatar = $userManager->editAvatar($id, $avatarUrl);

    if ($updateAvatar === false) {
        throw new Exception('Impossible d\'effectuer la modification.');
    }
    else {
        $_SESSION['avatar_url'] = $avatarUrl;
        header('Location: index.php?action=showProfile&id=' . $id . '&page=1');
    }
}

function updateSignature($id, $signature)
{
    $userManager = new UserManager();
    $updateSignature = $userManager->editSignature($id, $signature);

    if ($updateSignature === fasle) {
        throw new Exception('Impossible d\'effectuer la modification.');
    }
    else {
        $_SESSION['signature'] = $signature;
        header('Location: index.php?action=showProfile&id=' . $id . '&page=1');
    }
}

function addUser($name, $email, $password)
{
    $userManager = new UserManager();

    $checkUsers = $userManager->getUsers();
    while ($data = $checkUsers->fetch())
    {
        if ($_POST['name'] === $data['name'])
        {
            throw new Exception('Ce pseudo est déjà pris !');
        }
        elseif ($_POST['email'] === $data['email'])
        {
            throw new Exception('Cette adresse email est déjà associée à un compte !');
        }
    }

    $createNew = $userManager->createUser($name, $email, $password);

    if ($createNew === false) {
        throw new Exception('Impossible de créer l\'utilisateur !');
    }
    else {
        $connectNewUser = $userManager->connectUser($name);
        $_SESSION['id'] = $connectNewUser['id'];
        $_SESSION['name'] = $name;
        $_SESSION['status'] = $connectNewUser['status'];
        header('Location: index.php?action=showProfile&id=' . $connectNewUser['id'] . '&page=1');
    }
}

// fonctions ScoreManager ------------------------------------------------------
function listScores($page)
{
    $scoreManager = new ScoreManager();

    $countS = $scoreManager->countScores();
    $scoresNb = $countS['scoresNb'];
    $perPage = 10;
    $maxPages = ceil($scoresNb/$perPage);
    if ($page <= $maxPages) {
        $currentPage = $page;
    }
    else {
        $currentPage = 1;
    }
    $start = (($currentPage - 1) * $perPage);

    $scores = $scoreManager->getScoresPaged($start, $perPage);


    $userManager = new UserManager();
    $user = $userManager->getBestsUsers();

    require('view/frontend/scoreView.php');
}

function saveScorePlay($score, $userName, $userId)
{
    $scoreManager = new ScoreManager();
    $saveScore = $scoreManager->newScore($score, $userName, $userId);

    $userManager = new UserManager();
    $checkScore = $userManager->checkScore($userId);
    $bestScore = $checkScore['highest_score'];

    if ($score > $checkScore['highest_score']) {
        $newBest = $userManager->addBestScore($userId, $score);
    }

    $newTotal = $checkScore['total_games'] + 1;
    $addNewTotal = $userManager->addOneGame($userId, $newTotal);

    header('Location: index.php?action=play');
}

function saveScoreList($score, $userName, $userId)
{
    $scoreManager = new ScoreManager();
    $saveScore = $scoreManager->newScore($score, $userName, $userId);

    $userManager = new UserManager();
    $checkScore = $userManager->checkScore($userId);
    $bestScore = $checkScore['highest_score'];

    if ($score > $checkScore['highest_score']) {
        $newBest = $userManager->addBestScore($userId, $score);
    }

    $newTotal = $checkScore['total_games'] + 1;
    $addNewTotal = $userManager->addOneGame($userId, $newTotal);

    header('Location: index.php?action=listScores&page=1');
}
// fonctions CommentManager  --> aboutView <------------------------------------------------------
function about($page)
{
    $commentManager = new CommentManager();
    $countC = $commentManager->countComments();
    $commentNb = $countC['commentNb'];
    $perPage = 6;
    $maxPages = ceil($commentNb/$perPage);
    if ($page <= $maxPages) {
        $currentPage = $page;
    }
    else {
        $currentPage = 1;
    }
    $start = (($currentPage - 1) * $perPage);

    $comments = $commentManager->getCommentsPaged($start, $perPage);

    require('view/frontend/aboutView.php');
}

function postComment($userId, $userName, $comment)
{
    $commentManager = new CommentManager();

    $affectedLines = $commentManager->postComment($userId, $userName, $comment);

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    }
    else {
        header('Location: index.php?action=about&page=1#comment-section');
    }
}
function update()
{
    $commentManager = new CommentManager();

    $comment = $commentManager->getComment($_GET['id']);
    

    require('view/frontend/updateCommentView.php');
}

function updateComment($id, $comment)
{
    $commentManager = new CommentManager();

    $affectedLines = $commentManager->updateComment($id, $comment);

    if ($affectedLines === false) {
        throw new Exception('Impossible de modifier le commentaire !');
    }
    else {
        header('Location: index.php?action=about&page=1#comment-section');
    }
}
// fonctions ADMIN ----------------------------------------------------------------------
function admin()
{
    require('view/backend/adminView.php');
}

function userManagement($page)
{
    $userManager = new UserManager();

    $countU = $userManager->countUsers();
    $userNb = $countU['userNb'];
    $perPage = 5;
    $maxPages = ceil($userNb/$perPage);
    if ($page <= $maxPages) {
        $currentPage = $page;
    }
    else {
        $currentPage = 1;
    }
    $start = (($currentPage - 1) * $perPage);

    $users = $userManager->getUsersPaged($start, $perPage);

    require('view/backend/userManagementView.php');
}

function blockUser($id)
{
    $userManager = new UserManager();
    $blockedUser = $userManager->blockUser($id);

    if ($blockedUser === false) {
        throw new Exception('Impossible d\'effectuer la modification.');
    }
    else {
        header('Location: index.php?action=userManagement&page=1');
    }
}

function unblockUser($id)
{
    $userManager = new UserManager();
    $unblockedUser = $userManager->unblockUser($id);

    if ($unblockedUser === false) {
        throw new Exception('Impossible d\'effectuer la modification.');
    }
    else {
        header('Location: index.php?action=userManagement&page=1');
    }
}

function commentManagement($page)
{
    $commentManager = new CommentManager();

    $countC = $commentManager->countComments();
    $commentNb = $countC['commentNb'];
    $perPage = 10;
    $maxPages = ceil($commentNb/$perPage);
    if ($page <= $maxPages) {
        $currentPage = $page;
    }
    else {
        $currentPage = 1;
    }
    $start = (($currentPage - 1) * $perPage);

    $comments = $commentManager->getCommentsPaged($start, $perPage);

    require('view/backend/commentManagementView.php');
}

function deleteComment($id)
{
    $commentManager = new CommentManager();

    $deleteComment = $commentManager->deleteComment($id);

    if ($deleteComment === false) {
        throw new Exception('Impossible d\'effectuer la modification.');
    }
    else {
        header('Location: index.php?action=commentManagement&page=1');
    }
}

function newsManagement($page)
{
    $newsManager = new NewsManager();

    $countN = $newsManager->countNews();
    $newsNb = $countN['newsNb'];
    $perPage = 5;
    $maxPages = ceil($newsNb/$perPage);
    if ($page <= $maxPages) {
        $currentPage = $page;
    }
    else {
        $currentPage = 1;
    }
    $start = (($currentPage - 1) * $perPage);

    $news = $newsManager->getNewsPaged($start, $perPage);

    require('view/backend/newsManagementView.php');
}
function createNews()
{
    require('view/backend/createNewsView.php');
}

function addNews($title, $content)
{
    $newsManager = new NewsManager();
    $new = $newsManager->addNews($title, $content);

    if ($new === false) {
        throw new Exception('Impossible de créer la news !');
    }
    else {
        header('Location: index.php?action=newsManagement&page=1');
    }
}
function showNewsToEdit($id)
{
    $newsManager = new NewsManager();
    $newsToEdit = $newsManager->getNews($id);

    require('view/backend/editNewsView.php');
}
function editNews($id, $title, $content)
{
    $newsManager = new NewsManager();
    $postEdit = $newsManager->editNews($id, $title, $content);

    if ($postEdit === false) {
        throw new Exception('Impossible de modifier la news !');
    }
    else {
        header('Location: index.php?action=newsManagement&page=1');
    }
}

function deleteNews($id)
{
    $newsManager = new NewsManager();
    $deleteNews = $newsManager->deleteNews($id);

    if ($deleteNews === false) {
        throw new Exception('Impossible d\'effacer le chapitre !');
    }
    else {
        header('Location: index.php?action=newsManagement&page=1');
    }
}

// autres fonctions ----------------------------------------------------------------------

function register()
{
    require('view/frontend/registerView.php');
}

function playGame()
{
    require('view/frontend/gameView.php');
}