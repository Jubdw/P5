<?php

namespace Ju\Poulette\Model;

require_once("model/Manager.php");

class UserManager extends Manager
{
	public function getUsers()
	{
		$db = $this->dbConnect();
		$req = $db->query('SELECT id, name, email, status, DATE_FORMAT(register_date, \'%d/%m/%Y\') AS register_date_fr, highest_score, total_games, avatar_url, signature FROM users');

		return $req;
	}

	public function getBestsUsers()
	{
		$db = $this->dbConnect();
		$req = $db->query('SELECT id, name, email, status, DATE_FORMAT(register_date, \'%d/%m/%Y\') AS register_date_fr, highest_score, total_games, avatar_url, signature FROM users ORDER BY highest_score DESC LIMIT 0, 3');

		return $req;
	}

	public function getUser($id)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT name, email, status, DATE_FORMAT(register_date, \'%d/%m/%Y\') AS register_date_fr, highest_score, total_games, avatar_url, signature FROM users WHERE id = ?');
		$req->execute([$id]);
		$userInfo = $req->fetch();

		return $userInfo;
	}

	public function createUser($name, $email, $password)
	{
		$db = $this->dbConnect();
		$newUser = $db->prepare('INSERT INTO users(name, email, password, status, register_date, highest_score, total_games, avatar_url, signature) VALUES(?, ?, ?, "user", CURDATE(), "0", "0", "public/images/default_avatar.jpg", "...")');
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
		$newPassword = $db->prepare('UPDATE users SET password = ? WHERE id = ?');
		$edit = $newPassword->execute([$password, $id]);

		return $edit;
	}

	public function editAvatar($id, $avatarUrl)
	{
		$db = $this->dbConnect();		
		$newAvatar = $db->prepare('UPDATE users SET avatar_url = ? WHERE id = ?');
		$edit = $newAvatar->execute([$avatarUrl, $id]);

		return $edit;
	}

	public function editSignature($id, $signature)
	{
		$db = $this->dbConnect();		
		$newSignature = $db->prepare('UPDATE users SET signature = ? WHERE id = ?');
		$edit = $newSignature->execute([$signature, $id]);

		return $edit;
	}

	public function checkScore($id)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT id, highest_score, total_games FROM users WHERE id = ?');
		$req->execute([$id]);
		$userData = $req->fetch();
		
		return $userData;
	}

	public function addBestScore($id, $score)
	{
		$db = $this->dbConnect();
		$bestScore = $db->prepare('UPDATE users SET highest_score = ? WHERE id = ?');
		$edit = $bestScore->execute([$score, $id]);

		return $edit;
	}

	public function addOneGame($id, $total)
	{
		$db = $this->dbConnect();
		$totalGames = $db->prepare('UPDATE users SET total_games = ? WHERE id = ?');
		$edit = $totalGames->execute([$total, $id]);

		return $edit;
	}

	public function blockUser($id)
	{
		$db = $this->dbConnect();
		$blockedUser = $db->prepare('UPDATE users SET status = "blocked" WHERE id = ?');
		$edit = $blockedUser->execute([$id]);

		return $edit;
	}

	public function unblockUser($id)
	{
		$db = $this->dbConnect();
		$unblockedUser = $db->prepare('UPDATE users SET status = "user" WHERE id = ?');
		$edit = $unblockedUser->execute([$id]);

		return $edit;
	}

	public function countUsers()
	{
		$db = $this->dbConnect();
		$req = $db->query('SELECT COUNT(id) as userNb FROM users');
		$data = $req->fetch();

		return $data;
	}

	public function getUsersPaged($start, $perPage)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT id, name, email, status, DATE_FORMAT(register_date, \'%d/%m/%Y\') AS register_date_fr, highest_score, total_games, avatar_url, signature FROM users ORDER BY id ASC LIMIT :start, :perPage');
		$req->bindValue('start', $start, \PDO::PARAM_INT);
		$req->bindValue('perPage', $perPage, \PDO::PARAM_INT);
		$req->execute();

		return $req;
	}
}