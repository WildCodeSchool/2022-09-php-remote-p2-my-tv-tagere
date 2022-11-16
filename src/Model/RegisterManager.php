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
        " (lastname, firstname, birthdate, email, password)
        VALUES (:lastname, :firstname, :birthdate, :email, :password)");
        $statement->bindValue(':lastname', $user['lastname'], \PDO::PARAM_STR);
        $statement->bindValue(':firstname', $user['firstname'], \PDO::PARAM_STR);
        $statement->bindValue(':birthdate', $user['birthdate'], \PDO::PARAM_STR);
        $statement->bindValue(':email', $user['email'], \PDO::PARAM_STR);
        $statement->bindValue(':password', password_hash($user['password'], PASSWORD_DEFAULT), \PDO::PARAM_STR);
        $statement->execute();
    }

    public function selectByOneByEmail(string $email): array|false
    {
        $query = "SELECT * FROM " . self::TABLE . " WHERE email=:email";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('email', $email);
        $statement->execute();

        return $statement->fetch();
    }
}
