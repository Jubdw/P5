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
	}
	else {
        welcome();
    }
}
catch(Exception $e) {
    $errorMessage = $e->getMessage();
    require('view/frontend/errorView.php');
}