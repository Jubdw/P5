<?php

namespace Ju\Poulette\Model;

require_once("model/Manager.php");

class NewsManager extends Manager
{
	public function getWelcomeNews()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, title, SUBSTRING(content, 1, 255) AS small_content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM news ORDER BY creation_date DESC LIMIT 0, 2');

        return $req;
    }
}