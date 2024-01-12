<?php

namespace Tgu\Karimov\tests;

use PHPUnit\Framework\TestCase;
use PDO;
use PDOStatement;
use Tgu\Karimov\Posts\UUID;
use Tgu\Karimov\Posts\Article;
use Tgu\Karimov\Repositories\SqlitePostsRepository;
use Tgu\Karimov\Exceptions\PostNotFoundException;

final class SqlitePostsRepositoryTest extends TestCase
{
    public function testItSavePostToDatabase():void
    {
        $connectionStub = $this->createStub(PDO::class);

        $statementMock = $this->createMock(PDOStatement::class);

        $statementMock->expects($this->once())->method('execute')->with([
            ":uuid"=>'89e1519a-5684-44e6-9429-d227dc79f735',
            ":author_uuid"=>'73a0b2d0-2408-4aaa-ac00-14180264dd1f',
            ":title"=>'Название',
            ":text"=>'Текст'
        ]);

        $connectionStub->method('prepare')->willReturn($statementMock);

        $repository = new SqlitePostsRepository($connectionStub);

        $repository->save(new Article(
            new UUID('89e1519a-5684-44e6-9429-d227dc79f735'),
            new UUID('73a0b2d0-2408-4aaa-ac00-14180264dd1f'),
            'Название',
            'Текст'
        ));
    }

    public function testItThrowAnExceptionWhenPostNotFound() : void
    {
        $connectionStub = $this->createStub(PDO::class);

        $statementStub= $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);

        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqlitePostsRepository($connectionStub);

        $this->expectException(PostNotFoundException::class);
        $this->expectExceptionMessage("Cannot get article: 73a0b2d0-2408-4aaa-ac00-14180264dd1f");

        $repository->get(new UUID('73a0b2d0-2408-4aaa-ac00-14180264dd1f'));
    }

    public function testItGetPostByUUID() : void
    {
        $connectionStub = $this->createStub(PDO::class);

        $statementStub = $this->createStub(PDOStatement::class);

        $queryReturn = [
            'uuid'=>'73a0b2d0-2408-4aaa-ac00-14180264dd1f',
            'author_uuid'=>'89e1519a-5684-44e6-9429-d227dc79f735',
            'title'=>'Название',
            'text'=>"Текст"
        ];
        
        $statementStub->method('fetch')->willReturn($queryReturn);

        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqlitePostsRepository($connectionStub);
        $repository->get(new UUID('73a0b2d0-2408-4aaa-ac00-14180264dd1f'));

        $result=$repository->get(new UUID('73a0b2d0-2408-4aaa-ac00-14180264dd1f'));
        $this->assertEquals(new Article(
            new UUID('73a0b2d0-2408-4aaa-ac00-14180264dd1f'),
            new UUID('89e1519a-5684-44e6-9429-d227dc79f735'),
            'Название',
            'Текст'), $result);
    }
}