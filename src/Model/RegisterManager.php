<?php

namespace App\Model;

class RegisterManager extends AbstractManager
{
    public const TABLE = 'user';

    /**
     * Insert new item in database
     */
    public function insert(array $user): void
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
        " (lastname, firstname, birthdate, email)
        VALUES (:lastname, :firstname, :birthdate, :email)");
        $statement->bindValue(':lastname', $user['lastname'], \PDO::PARAM_STR);
        $statement->bindValue(':firstname', $user['firstname'], \PDO::PARAM_STR);
        $statement->bindValue(':birthdate', $user['birthdate'], \PDO::PARAM_STR);
        $statement->bindValue(':email', $user['email'], \PDO::PARAM_STR);
        $statement->execute();
    }
}
