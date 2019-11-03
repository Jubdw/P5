<?php

namespace Ju\Poulette\Model;

require_once("model/Manager.php");

class ScoreManager extends Manager
{
    public function getWelcomeScores()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, value, user_name, user_id FROM scores ORDER BY value DESC LIMIT 0, 3');

        return $req;
    }

	public function countScores()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT COUNT(id) as scoresNb FROM scores');
        $data = $req->fetch();

        return $data;
    }

	public function getScoresPaged($start, $perPage)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, value, user_name, user_id FROM scores ORDER BY value DESC LIMIT :start, :perPage');
        $req->bindValue('start', $start, \PDO::PARAM_INT);
        $req->bindValue('perPage', $perPage, \PDO::PARAM_INT);
        $req->execute();

        return $req;
    }

    public function newScore($score, $userName, $userId)
    {
    	$db = $this->dbConnect();
    	$newScore = $db->prepare('INSERT INTO scores(value, user_name, user_id) VALUES (?, ?, ?)');

    	$saveNew = $newScore->execute([$score, $userName, $userId]);
		
		return $saveNew;
    }
}