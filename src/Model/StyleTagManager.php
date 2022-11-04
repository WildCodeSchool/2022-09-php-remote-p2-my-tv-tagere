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
            $statement->bindValue('user_id', 1, \PDO::PARAM_INT);
            $statement->execute();

            $mostUsedTag['series'] = $statement->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $mostUsedTags;
    }
}
