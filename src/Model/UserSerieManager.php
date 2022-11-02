<?php

namespace App\Model;

use PDO;

class UserSerieManager extends AbstractManager
{
    public const TABLE = 'user_serie';

    public function addOrDeleteToUser(int $serieId)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            "(serie_id, user_id) VALUES (:serie_id, :user_id)");
        // Insertion ou délétion d'une série dans sa propre bibliothèque
        $statement->bindValue('serie_id', $serieId, \PDO::PARAM_INT);
        $statement->bindValue('user_id', 1, \PDO::PARAM_INT);
        $statement->execute();
    }
}
