<?php

namespace Ju\Poulette\Model;

require_once("model/Manager.php");

class UserManager extends Manager
{
	public function getUsers()
	{
		$db = $this->dbConnect();
		$req = $db->query('SELECT id, name, email, status, DATE_FORMAT(register_date, \'%d/%m/%Y\') AS register_date_fr FROM users');

		return $req;
	}

	public function getUser($id)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT name, email, status, DATE_FORMAT(register_date, \'%d/%m/%Y\') AS register_date_fr FROM users WHERE id = ?');
		$req->execute([$id]);
		$userInfo = $req->fetch();

		return $userInfo;
	}

	public function createUser($name, $email, $password)
	{
		$db = $this->dbConnect();
		$newUser = $db->prepare('INSERT INTO users(name, email, password, status, register_date, highest_score, total_games) VALUES(?, ?, ?, "admin", CURDATE(), "0", "0")');
		$createNew = $newUser->execute([$name, $email, $password]);
		
		return $createNew;
	}

	public function connectUser($name)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT id, password, status FROM users WHERE name = ?');
		$req->execute([$name]);
		$userData = $req->fetch();
		
		return $userData;
	}
	
	public function editName($id, $name)
	{
		$db = $this->dbConnect();
		$newName = $db->prepare('UPDATE users SET name = ? WHERE id = ?');
		$edit = $newName->execute([$name, $id]);

		return $edit;
	}

	public function editEmail($id, $email)
	{
		$db = $this->dbConnect();
		$newEmail = $db->prepare('UPDATE users SET email = ? WHERE id = ?');
		$edit = $newEmail->execute([$email, $id]);

		return $edit;
	}

	public function editPassword($id, $password)
	{
		$db = $this->dbConnect();
		$newEmail = $db->prepare('UPDATE users SET password = ? WHERE id = ?');
		$edit = $newEmail->execute([$password, $id]);

		return $edit;
	}
}