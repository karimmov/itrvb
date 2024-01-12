<?php

namespace Tgu\Karimov\tests;

use PHPUnit\Framework\TestCase;
use PDO;
use PDOStatement;
use Tgu\Karimov\Posts\UUID;
use Tgu\Karimov\Repositories\SqliteUsersRepository;
use Tgu\Karimov\Posts\User;
use Tgu\Karimov\Exceptions\UserNotFoundException;
use Tgu\Karimov\Posts\Article;

final class SqliteUsersRepositoryTest extends TestCase
{
    public function testItSaveUserToDatabase():void
    {
        $connectionStub = $this->createStub(PDO::class);

        $statementMock = $this->createMock(PDOStatement::class);

        $statementMock->expects($this->once())->method('execute')->with([
            ':uuid'=>'73a0b2d0-2408-4aaa-ac00-14180264dd1f',
            ':username'=>'_alex_',
            ':first_name'=>'Алексей',
            ':second_name'=>'Иванов'
        ]);

        $connectionStub->method('prepare')->willReturn($statementMock);

        $repository = new SqliteUsersRepository($connectionStub);

        $repository->save(new User(
            new UUID('73a0b2d0-2408-4aaa-ac00-14180264dd1f'),
            '_alex_',
            'Алексей',
            'Иванов'
        ));
    }

    public function testItThrowAnExceptionWhenUserNotFound() : void
    {
        $connectionStub = $this->createStub(PDO::class);

        $statementStub= $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);

        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteUsersRepository($connectionStub);

        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage("Cannot get user: 73a0b2d0-2408-4aaa-ac00-14180264dd1f");

        $repository->get(new UUID('73a0b2d0-2408-4aaa-ac00-14180264dd1f'));
    }

    public function testItGetUserByUUID()
    {
        $connectionStub = $this->createStub(PDO::class);

        $statementStub = $this->createStub(PDOStatement::class);

        $queryReturn = [
            "uuid"=>'73a0b2d0-2408-4aaa-ac00-14180264dd1f',
            'username'=>'_alex_',
            'first_name'=>'Алексей',
            'second_name'=>'Иванов'
        ];

        $statementStub->method('fetch')->willReturn($queryReturn);

        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteUsersRepository($connectionStub);

        $result=$repository->get(new UUID('73a0b2d0-2408-4aaa-ac00-14180264dd1f'));
        $this->assertEquals(new User(new UUID('73a0b2d0-2408-4aaa-ac00-14180264dd1f'), '_alex_', 'Алексей', 'Иванов'), $result);

    }

}