<?php
session_start();

require('controller/controller.php');

try {
	if (isset($_GET['action'])) {
		if ($_GET['action'] == 'login') {
			if (!empty($_POST['name']) && !empty($_POST['password'])) {
                connect($_POST['name']);
            }
            else {
                throw new Exception('Nom et/ou mot de passe non-transmis...');
            }
		}
		elseif ($_GET['action'] == 'logout') {
            disconnect();
        }
        elseif ($_GET['action'] == 'registerUser') {
            if (!empty($_POST['password']) && !empty($_POST['password_check']) && $_POST['password'] == $_POST['password_check']) {
                if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email'])) {
                    $hashed_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    addUser($_POST['name'], $_POST['email'], $hashed_pass);
                }
                else {
                    throw new Exception('L\'adresse email n\'est pas valide !');
                }
            }
            else {
                throw new Exception('Le mot de passe est différent d\'un champ à l\'autre');
            }
        }
        elseif ($_GET['action'] == 'register') {
            register();
        }
        elseif ($_GET['action'] == 'about') {
            if (isset($_GET['page']) && $_GET['page'] > 0) {
                about($_GET['page']);
            }
            else {
                throw new Exception('Ne modifiez pas l\'url SVP');
            }
        }
        elseif ($_GET['action'] == 'showProfile') {
            if (isset($_GET['id']) && $_GET['id'] > 0 && isset($_GET['page']) && $_GET['page'] > 0) {
                profile($_GET['page']);
            }
            else {
                throw new Exception('Aucun membre sélectionné !');
            }
        }
        elseif ($_GET['action'] == 'editProfile') {
            editProfile();
        }
        elseif ($_GET['action'] == 'updateName') {
            if (isset($_SESSION['id'])) {
                if (!empty($_POST['name'])) {
                    updateName($_SESSION['id'], $_POST['name']);
                }
                else {
                    throw new Exception('Aucun nouveau nom envoyé !');
                }
            }
            else {
                throw new Exception('Vous n\'êtes pas autorisé à accéder à cette page.');
            }
        }
        elseif ($_GET['action'] == 'updateEmail') {
            if (!empty($_POST['email'])) {
                if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email'])) {
                    updateEmail($_SESSION['id'], $_POST['email']);
                }
                else {
                    throw new Exception('L\'adresse email n\'est pas valide !');
                }
            }
            else {
                throw new Exception('Aucun nouvel e-mail envoyé !');
            }
        }
        elseif ($_GET['action'] == 'updatePassword') {
            if (!empty($_POST['password']) && !empty($_POST['password_check']) && $_POST['password'] == $_POST['password_check']) {
                $hashed_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
                updatePassword($_SESSION['id'], $hashed_pass);
            }
            else {
                throw new Exception('Les mots de passes entrés ne sont pas identiques !');
            }
        }
        elseif ($_GET['action'] == 'upload') {
            if (isset($_FILES["avatar"])) {
                upload();
            }
            else {
                throw new Exception('Aucun fichier sélectionné !');
            }
        }
        elseif ($_GET['action'] == 'updateAvatar') {
            updateAvatar($_SESSION['id'], $_GET['url']);
        }
        elseif ($_GET['action'] == 'updateSignature') {
            updateSignature($_SESSION['id'], $_POST['signature']);
        }
        elseif ($_GET['action'] == 'postComment') {
            if (!empty($_POST['comment'])) {
                    postComment($_SESSION['id'], $_SESSION['name'], $_POST['comment']);
                }
                else {
                    throw new Exception('Vous n\'avez pas écris de commentaire !');
                }
        }
        elseif ($_GET['action'] == 'update') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                update();
            }
            else {
                throw new Exception('Aucun identifiant de commentaire envoyé');
            }
        }
        elseif ($_GET['action'] == 'updateComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!empty($_POST['comment'])) {
                    updateComment($_GET['id'], $_POST['comment']);
                }
                else {
                    throw new Exception('Tous les champs ne sont pas remplis !');
                }
            }
            else {
                throw new Exception('Aucun identifiant de commentaire envoyé');
            }
        }
        elseif ($_GET['action'] == 'news') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                news();
            }
            else {
                throw new Exception('Aucune news sélectionnée !');
            }
        }
        elseif ($_GET['action'] == 'listNews') {
            if (isset($_GET['page']) && $_GET['page'] > 0) {
                listNews($_GET['page']);
            }
            else {
                throw new Exception('Ne modifiez pas l\'url SVP');
            }
        }
        elseif ($_GET['action'] == 'play') {
            playGame();
        }
        elseif ($_GET['action'] == 'saveScorePlay') {
            saveScorePlay($_POST['score'], $_SESSION['name'], $_SESSION['id']);
        }
        elseif ($_GET['action'] == 'saveScoreList') {
            saveScoreList($_POST['score'], $_SESSION['name'], $_SESSION['id']);
        }
        elseif ($_GET['action'] == 'listScores') {
            if (isset($_GET['page']) && $_GET['page'] > 0) {
                listScores($_GET['page']);
            }
            else {
                throw new Exception('Ne modifiez pas l\'url SVP');
            }
        }
        // ADMIN -----------------------------------------
        elseif ($_GET['action'] == 'admin') {
            if (isset($_SESSION['status']) && $_SESSION['status'] === 'admin') {
                admin();
            }
            else {
                throw new Exception("Vous n'êtes pas autorisé à accéder à cette page.");
            }
        }
        elseif ($_GET['action'] == 'userManagement') {
            if (isset($_SESSION['status']) && $_SESSION['status'] === 'admin') {
                userManagement($_GET['page']);
            }
            else {
                throw new Exception("Vous n'êtes pas autorisé à accéder à cette page.");
            }
        }
        elseif ($_GET['action'] == 'blockUser') {
            if (isset($_SESSION['status']) && $_SESSION['status'] === 'admin') {
                blockUser($_GET['id']);
            }
            else {
                throw new Exception("Vous n'êtes pas autorisé à accéder à cette page.");
            }
        }
        elseif ($_GET['action'] == 'unblockUser') {
            if (isset($_SESSION['status']) && $_SESSION['status'] === 'admin') {
                unblockUser($_GET['id']);
            }
            else {
                throw new Exception("Vous n'êtes pas autorisé à accéder à cette page.");
            }
        }
        elseif ($_GET['action'] == 'commentManagement') {
            if (isset($_SESSION['status']) && $_SESSION['status'] === 'admin') {
                commentManagement($_GET['page']);
            }
            else {
                throw new Exception("Vous n'êtes pas autorisé à accéder à cette page.");
            }
        }
        elseif ($_GET['action'] == 'deleteComment') {
            if (isset($_SESSION['status']) && $_SESSION['status'] === 'admin') {
                deleteComment($_GET['id']);
            }
            else {
                throw new Exception("Vous n'êtes pas autorisé à accéder à cette page.");
            }
        }
        elseif ($_GET['action'] == 'newsManagement') {
            if (isset($_SESSION['status']) && $_SESSION['status'] === 'admin') {
                newsManagement($_GET['page']);
            }
            else {
                throw new Exception("Vous n'êtes pas autorisé à accéder à cette page.");
            }
        }
        elseif ($_GET['action'] == 'createNews') {
            if (isset($_SESSION['status']) && $_SESSION['status'] === 'admin') {
                createNews();
            }
            else {
                throw new Exception("Vous n'êtes pas autorisé à accéder à cette page.");
            }
        }
        elseif ($_GET['action'] == 'addNews') {
            if (isset($_SESSION['status']) && $_SESSION['status'] === 'admin') {
                addNews($_POST['title'], $_POST['content']);
            }
            else {
                throw new Exception("Vous n'êtes pas autorisé à accéder à cette page.");
            }
        }
        elseif ($_GET['action'] == 'showNewsToEdit') {
            if (isset($_SESSION['status']) && $_SESSION['status'] === 'admin') {
                showNewsToEdit($_GET['id']);
            }
            else {
                throw new Exception("Vous n'êtes pas autorisé à accéder à cette page.");
            }
        }
        elseif ($_GET['action'] == 'editNews') {
            if (isset($_SESSION['status']) && $_SESSION['status'] === 'admin') {
                editNews($_GET['id'], $_POST['title'], $_POST['content']);
            }
            else {
                throw new Exception("Vous n'êtes pas autorisé à accéder à cette page.");
            }
        }
        elseif ($_GET['action'] == 'deleteNews') {
            if (isset($_SESSION['status']) && $_SESSION['status'] === 'admin') {
                deleteNews($_GET['id']);
            }
            else {
                throw new Exception("Vous n'êtes pas autorisé à accéder à cette page.");
            }
        }
        // ---------------------------
	}
	else {
        welcome();
    }
}
catch(Exception $e) {
    $errorMessage = $e->getMessage();
    require('view/frontend/errorView.php');
}