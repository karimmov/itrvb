<?php

namespace Tgu\Karimov\Repositories;

use PDO;
use Tgu\Karimov\Exceptions\UserNotFoundException;
use Tgu\Karimov\Posts\User;
use Tgu\Karimov\Posts\UUID;

class SqliteUsersRepository implements UserRepositoryInterface
{
    public function __construct(private PDO $conn) 
    {
        
    }
    public function save(User $user) : void
    {
        $statement = $this->conn->prepare(
            'INSERT INTO users (uuid, username, first_name, second_name) VALUES (:uuid, :username, :first_name, :second_name)'
        );

        $statement->execute([
            ":uuid" => (string)$user->getUUID(),
            ":username" =>$user->getUsername(),
            ":first_name" => $user->getFirstName(),
            ":second_name" => $user->getSecondName()
        ]);
    }

    public function get(UUID $uuid) : User
    {
        $statement = $this->conn->prepare(
            'SELECT * FROM users WHERE uuid = :uuid'
        );

        $statement->execute([
            ':uuid' => $uuid
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result == false) {
            throw new UserNotFoundException("Cannot get user: $uuid");
        }

        return new User(
            new UUID($result['uuid']),
            $result['username'],
            $result['first_name'],
            $result['second_name']
        );
    }
}