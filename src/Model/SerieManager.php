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
                " WHERE name REGEXP :regex LIMIT 12");
            $statement->bindValue(':regex', $regex, \PDO::PARAM_STR);
            $statement->execute();
        } else {
            $statement = $this->pdo->prepare("SELECT id FROM " . self::TABLE .
                " WHERE name LIKE :research1 OR year= :research2 LIMIT 12");
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

    // SELECT s_t.id, COUNT(s.id) as numSerie, s_t.name FROM serie s
    // JOIN serie_style_tag s_s_t ON s_s_t.serie_id=s.id
    // JOIN style_tag s_t ON s_s_t.style_tag_id = s_t.id
    // JOIN user_serie u_s ON u_s.serie_id = s.id
    // GROUP BY s_t.id ORDER BY numSerie DESC;


//     SELECT DISTINCT s.id, s.name, s.image, s_t.name, s_t.id AS styleId from serie s
// JOIN serie_style_tag s_s_t ON s_s_t.serie_id=s.id
// JOIN style_tag s_t ON s_s_t.style_tag_id = s_t.id
// WHERE s.id NOT IN (SELECT serie_id FROM user_serie WHERE user_id='1')
// AND s_t.id IN (
//     SELECT s_t.id FROM serie s
//     JOIN serie_style_tag s_s_t ON s_s_t.serie_id=s.id
//     JOIN style_tag s_t ON s_s_t.style_tag_id = s_t.id
//     JOIN user_serie u_s ON u_s.serie_id = s.id
//     WHERE u_s.user_id=1
//     GROUP BY s_t.id ORDER BY COUNT(s.id) DESC
// );


}
