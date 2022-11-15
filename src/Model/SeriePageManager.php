<?php

namespace App\Model;

use PDO;

class SeriePageManager extends AbstractManager
{
    public const TABLE = 'serie';

    public function __construct()
    {
        parent::__construct();
    }


    public function update(array $serieUpdate): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `name` = :serieName, `year` = :year,
    `nb_of_seasons` = :nbOfSeasons, `description` = :description WHERE id=:id");

        $statement->bindValue(':id', $serieUpdate['id'], PDO::PARAM_STR);
        $statement->bindValue(':serieName', $serieUpdate['serieName'], PDO::PARAM_STR);
        $statement->bindValue(':year', $serieUpdate['year'], PDO::PARAM_STR);
        $statement->bindValue(':nbOfSeasons', $serieUpdate['nbOfSeasons'], PDO::PARAM_INT);
        $statement->bindValue(':description', $serieUpdate['description'], PDO::PARAM_STR);

        return $statement->execute();
    }
}
