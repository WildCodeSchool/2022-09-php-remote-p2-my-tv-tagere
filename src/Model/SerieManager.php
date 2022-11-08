<?php

namespace App\Model;

class SerieManager extends AbstractManager
{
    public const TABLE = 'serie';

    /**
     * Insert new item in database
     */
    public function insertSerie(array $serie): void
    {

        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
         " (name, year, nb_of_seasons, description, image) VALUES (
            :serieName, :year, :nbOfSeasons, :description, :image)");
        $statement->bindValue(':serieName', $serie['serieName'], \PDO::PARAM_STR);
        $statement->bindValue(':year', $serie['year'], \PDO::PARAM_INT);
        $statement->bindValue(':nbOfSeasons', $serie['nbOfSeasons'], \PDO::PARAM_INT);
        $statement->bindValue(':description', $serie['description'], \PDO::PARAM_STR);
        $statement->bindValue(':image', $serie['image'], \PDO::PARAM_STR);
        $statement->execute();
    }

    public function selectOneByNameAndYear(array $serie): false|array
    {
        $statement = $this->pdo->prepare("SELECT name, year FROM " . self::TABLE .
        " WHERE name=:serieName AND year=:year");
        $statement->bindValue(':serieName', $serie['serieName'], \PDO::PARAM_STR);
        $statement->bindValue(':year', $serie['year'], \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }
}
