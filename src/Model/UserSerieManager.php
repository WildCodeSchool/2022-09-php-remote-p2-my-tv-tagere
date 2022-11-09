<?php

namespace App\Model;

use PDO;

class UserSerieManager extends AbstractManager
{
    public const TABLE = 'user_serie';

    public function addOrDeleteToUser(int $serieId)
    {
        /*
        * Add (if not already added or Delete (if already added) a Show in user list
        */

        //Verifing if already in user list
        $statement = $this->pdo->prepare("SELECT id FROM " . self::TABLE .
            " WHERE serie_id=:serieId AND user_id=:userId");
        $statement->bindValue('serieId', $serieId, \PDO::PARAM_INT);
        $statement->bindValue('userId', 1, \PDO::PARAM_INT);
        $statement->execute();
        $userSerie = $statement->fetch();

        //Si elle existe, je la supprime... sinon je l'ajoute
        if (isset($userSerie["id"])) {
            $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
            $statement->bindValue('id', $userSerie["id"], \PDO::PARAM_INT);
            $statement->execute();
        } else {
            $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
                "(serie_id, user_id) VALUES (:serie_id, :user_id)");
            $statement->bindValue('serie_id', $serieId, \PDO::PARAM_INT);
            $statement->bindValue('user_id', 1, \PDO::PARAM_INT);
            $statement->execute();
        }
    }

    public function favoritesSeriesById()
    {
        $statement = $this->pdo->query("SELECT serie_id as id FROM " . self::TABLE .
            " WHERE user_id=1");
        $favSeries = $statement->fetchAll();
        return $favSeries;
    }
}
