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

    public function getNews($newsId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM news WHERE id = ?');
        $req->execute([$newsId]);

        return $req;
    }

    public function countNews()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT COUNT(id) as newsNb FROM news');
        $data = $req->fetch();

        return $data;
    }

    public function getNewsPaged($start, $perPage)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, SUBSTRING(content, 1, 255) AS small_content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM news ORDER BY creation_date DESC LIMIT :start, :perPage');
        $req->bindValue('start', $start, \PDO::PARAM_INT);
        $req->bindValue('perPage', $perPage, \PDO::PARAM_INT);
        $req->execute();

        return $req;
    }

    public function addNews($title, $content)
    {
        $db = $this->dbConnect();
        $newPost = $db->prepare('INSERT INTO news(title, content, creation_date) VALUES(?, ?, NOW())');
        $createNew = $newPost->execute([$title, $content]);
        
        return $createNew;
    }

    public function editNews($id, $title, $content)
    {
        $db = $this->dbConnect();
        $editedPost = $db->prepare('UPDATE news SET title = ?, content = ? WHERE id = ?');
        $affectedLines = $editedPost->execute([$title, $content, $id]);

        return $affectedLines;
    }

    public function deleteNews($id)
    {
        $db = $this->dbConnect();
        $deletedNews = $db->prepare('DELETE FROM news WHERE id = ?');
        $affectedLines = $deletedNews->execute([$id]);

        return $affectedLines;
    }
}