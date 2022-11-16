<?php

namespace App\Model;

use PDO;

class SerieStyleManager extends AbstractManager
{
    public const TABLE = 'serie_style_tag';
    /**
     * Insert new tag(s) for serie in database
     */
    public function insertTagsBySerieId(int $styleIagId, int $serieId): void
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            " (serie_id, style_tag_id) VALUES (:serie_id, :style_tag_id)");
        $statement->bindValue('serie_id', $serieId, PDO::PARAM_INT);
        $statement->bindvalue('style_tag_id', $styleIagId, PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Get one row from database by ID.
     */
    public function selectTagsBySerieId(int $serieId): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT st.name FROM serie_style_tag as sst
                                            RIGHT JOIN style_tag as st ON sst.style_tag_id = st.id
                                            WHERE sst.serie_id = :serie_id;");
        $statement->bindValue('serie_id', $serieId, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}
