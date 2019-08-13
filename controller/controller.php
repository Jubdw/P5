<?php

use Ju\Poulette\Model\UserManager;

require_once('model/UserManager.php');
// Acceuil ---------------------------------------------------------------------------------
function welcome()
{
	require('view/frontend/homeView.php');
}

// fonctions UserManager -------------------------------------------------------------------

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
        header('Location: index.php');
    }
}

// autres fonctions ----------------------------------------------------------------------

function register()
{
    require('view/frontend/registerView.php');
}