<?php

namespace App\Model;

use App\Model\UserSerieManager;

class SerieManager extends AbstractManager
{
    public const TABLE = 'serie';

    /**
     * Insert new item in database
     */
    public function insertSerie(array $serie): string|false
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
        return $this->pdo->lastInsertId();
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

    public function searchEngine(string $research): false|array
    {
        $intResearch = is_numeric($research) ? intval($research) : 0;

        if (strlen($research) == 1) {
            $regex = ".*\\b[" . strtolower($research) . strtoupper($research) . "].*";
            $statement = $this->pdo->prepare("SELECT id FROM " . self::TABLE .
                " WHERE name REGEXP :regex LIMIT 200");
            $statement->bindValue(':regex', $regex, \PDO::PARAM_STR);
            $statement->execute();
        } else {
            $statement = $this->pdo->prepare("SELECT id FROM " . self::TABLE .
                " WHERE name LIKE :research1 OR year= :research2 LIMIT 200");
            $statement->bindValue(':research1', "%" . $research . "%", \PDO::PARAM_STR);
            $statement->bindValue(':research2', $intResearch, \PDO::PARAM_INT);
            $statement->execute();
        }
        return $statement->fetchALL();
    }

    public function createCards(array $cardsIds): array
    {

        foreach ($cardsIds as &$cardsId) {
            $statement = $this->pdo->prepare(
                "SELECT s.id, s.name, s.image, s.nb_of_seasons AS totseasons,
                us.nb_of_seen_seasons AS seen, us.id AS fav FROM " . self::TABLE . " s " .
                    "LEFT JOIN user_serie us ON us.serie_id=s.id AND us.user_id=:user_id
                WHERE s.id=:cardId"
            );
            $statement->bindValue(':user_id', $_SESSION['user_id'], \PDO::PARAM_INT);
            $statement->bindValue(':cardId', $cardsId['id'], \PDO::PARAM_STR);
            $statement->execute();

            $cardsId['serie'] = $statement->fetch(\PDO::FETCH_ASSOC); //changer self::TABLE SI ça déconne
        }
        return $cardsIds;
    }
}
