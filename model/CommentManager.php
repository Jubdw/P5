<?php

namespace Ju\Poulette\Model;

require_once("model/Manager.php");

class CommentManager extends Manager
{
	public function postComment($userId, $userName, $comment)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('INSERT INTO comments(user_id, user_name, comment, comment_date) VALUES(?, ?, ?, NOW())');
        $affectedLines = $comments->execute([$userId, $userName, $comment]);

        return $affectedLines;
    }

    public function getComment($id)
    {
        $db = $this->dbConnect();
        $comment = $db->prepare('SELECT id, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments WHERE id = ?');
        $comment->execute([$id]);

        return $comment;
    }

    public function updateComment($id, $comment)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('UPDATE comments SET comment = ? WHERE id = ?');
        $affectedLines = $comments->execute([$comment, $id]);

        return $affectedLines;
    }

    public function countComments()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT COUNT(id) as commentNb FROM comments');
        $data = $req->fetch();

        return $data;
    }

    public function getCommentsPaged($start, $perPage)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('SELECT id, user_id, user_name, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments ORDER BY comment_date ASC LIMIT :start, :perPage');
        $comments->bindValue('start', $start, \PDO::PARAM_INT);
        $comments->bindValue('perPage', $perPage, \PDO::PARAM_INT);
        $comments->execute();

        return $comments;
    }

    public function countUserComments($userId)
    {
        $db = $this->dbConnect();
        $data = $db->prepare('SELECT COUNT(id) as commentNb FROM comments WHERE user_id = :user_id');
        $data->bindValue('user_id', $userId, \PDO::PARAM_INT);
        $data->execute();
        $count = $data->fetch();

        return $count;
    }

    public function getUserCommentsPaged($userId, $start, $perPage)
    {
        $db = $this->dbConnect();
        $userComments = $db->prepare('SELECT id, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments WHERE user_id = :user_id ORDER BY comment_date DESC LIMIT :start, :perPage');
        $userComments->bindValue('start', $start, \PDO::PARAM_INT);
        $userComments->bindValue('perPage', $perPage, \PDO::PARAM_INT);
        $userComments->bindValue('user_id', $userId, \PDO::PARAM_INT);
        $userComments->execute();

        return $userComments;
    }

    public function deleteComment($id)
    {
        $db = $this->dbConnect();
        $deletedComment = $db->prepare('DELETE FROM comments WHERE id = ?');
        $affectedLines = $deletedComment->execute([$id]);

        return $affectedLines;
    }
}