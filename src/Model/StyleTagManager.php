<?php

namespace App\Model;

use PDO;

class StyleTagManager extends AbstractManager
{
    public const TABLE = 'style_tag';

    public function getMostUsedTags(): array
    {
        // Recupération des tags les plus utilisés
        $statement = $this->pdo->query("SELECT st.name as tagName, st.id FROM " . self::TABLE . " st
            JOIN serie_style_tag stt ON st.id = stt.style_tag_id
            GROUP BY st.id
            ORDER BY count(stt.id) DESC
            LIMIT 3;");
        $mostUsedTags = $statement->fetchAll();
        return $mostUsedTags;
    }

    public function getFirstSeriesByTag()
    {
        //Récupération (et ajout au tableau) des premières séries pour chaque tags les plus utilisés
        $mostUsedTags = $this->getMostUsedTags();
        foreach ($mostUsedTags as &$mostUsedTag) {
            $statement = $this->pdo->prepare("SELECT s.name AS name, s.id, s.image, us.id as fav FROM " .
                self::TABLE . " st
                LEFT JOIN serie_style_tag stt ON st.id = stt.style_tag_id
                LEFT JOIN serie s ON s.id=stt.serie_id
                LEFT JOIN user_serie us ON us.serie_id=s.id AND us.user_id=:user_id
                WHERE st.id='" . $mostUsedTag['id'] . "'
                LIMIT 4;");
            $statement->bindValue('user_id', $_SESSION['user_id'], \PDO::PARAM_INT);
            $statement->execute();
            $mostUsedTag['series'] = $statement->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $mostUsedTags;
    }

    //Récupération des séries non visionnées par tags favoris
    public function getMostUsedFavs(): array
    {
        $statement = $this->pdo->prepare("SELECT DISTINCT s.id, s.name, s.image,
            s_t.name, s_t.id AS styleId FROM serie s
            JOIN serie_style_tag s_s_t ON s_s_t.serie_id=s.id
            JOIN style_tag s_t ON s_s_t.style_tag_id = s_t.id
            WHERE s.id NOT IN (SELECT serie_id FROM user_serie WHERE user_id=:user_id)
            AND s_t.id IN (
                SELECT s_t.id FROM serie s
                JOIN serie_style_tag s_s_t ON s_s_t.serie_id=s.id
                JOIN style_tag s_t ON s_s_t.style_tag_id = s_t.id
                JOIN user_serie u_s ON u_s.serie_id = s.id
                WHERE u_s.user_id=:user_id
                GROUP BY s_t.id ORDER BY COUNT(s.id) DESC)
                LIMIT 4");
        $statement->bindValue('user_id', $_SESSION['user_id'], \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}
