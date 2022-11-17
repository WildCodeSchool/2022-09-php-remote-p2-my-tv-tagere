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
        $statement->bindValue('userId', $_SESSION['user_id'], \PDO::PARAM_INT);
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
            $statement->bindValue('user_id', $_SESSION['user_id'], \PDO::PARAM_INT);
            $statement->execute();
        }
    }

    public function selectOneById(int $id): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT serie_id FROM " . static::TABLE . " WHERE user_id=:user_id");
        $statement->bindValue('user_id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function favoritesSeriesById()
    {
        $statement = $this->pdo->prepare("SELECT serie_id as id FROM " . self::TABLE .
            " WHERE user_id=:user_id");
        $statement->bindValue('user_id', $_SESSION['user_id'], \PDO::PARAM_INT);
        $statement->execute();
        $favSeries = $statement->fetchAll();
        return $favSeries;
    }

    public function update(array $seenUpdate): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `nb_of_seen_seasons` = :seenSeasons,
        WHERE user_id = :user_id AND serie_id = :serie_id ");

        $statement->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
        $statement->bindValue(':serie_id', $_POST['serie_id'], PDO::PARAM_STR);
        $statement->bindValue(':seenSeasons', $_POST['updateseenseasons'], PDO::PARAM_STR);


        return $statement->execute();
    }
}
