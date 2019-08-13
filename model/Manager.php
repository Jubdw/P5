<?php

namespace Ju\Poulette\Model;

class Manager
{
    protected function dbConnect()
    {
        $db = new \PDO('mysql:host=localhost;dbname=poulette;charset=utf8', 'root', '');
        return $db;
    }
}