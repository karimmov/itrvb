<?php

namespace Tgu\Karimov\tests;

use PHPUnit\Framework\TestCase;
use PDO;
use PDOStatement;
use Tgu\Karimov\Exceptions\CommentNotFoundException;
use Tgu\Karimov\Posts\Comment;
use Tgu\Karimov\Repositories\SqliteCommentsRepository;
use Tgu\Karimov\Posts\UUID;

final class SqliteCommentsRepositoryTest extends TestCase
{
    public function testItSaveCommentsToDatabase():void
    {
        $connectionStub = $this->createStub(PDO::class);

        $statementMock = $this->createMock(PDOStatement::class);

        $statementMock->expects($this->once())->method('execute')->with([
            ":uuid"=>'89e1519a-5684-44e6-9429-d227dc79f735',
            ":author_uuid"=>'73a0b2d0-2408-4aaa-ac00-14180264dd1f',
            ":post_uuid"=>'32c6434e-8377-444d-867a-056b34e623e9',
            ":text"=>'Текст'
        ]);

        $connectionStub->method('prepare')->willReturn($statementMock);

        $repository = new SqliteCommentsRepository($connectionStub);

        $repository->save(new Comment(
            new UUID('89e1519a-5684-44e6-9429-d227dc79f735'),
            new UUID('73a0b2d0-2408-4aaa-ac00-14180264dd1f'),
            new UUID('32c6434e-8377-444d-867a-056b34e623e9'),
            'Текст'
        ));
    }

    public function testItThrowAnExceptionWhenCommentNotFound() : void
    {
        $connectionStub = $this->createStub(PDO::class);

        $statementStub= $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);

        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteCommentsRepository($connectionStub);

        $this->expectException(CommentNotFoundException::class);
        $this->expectExceptionMessage("Cannot get comment: 73a0b2d0-2408-4aaa-ac00-14180264dd1f");

        $repository->get(new UUID('73a0b2d0-2408-4aaa-ac00-14180264dd1f'));
    }

    public function testItGetPostByUUID() : void
    {
        $connectionStub = $this->createStub(PDO::class);

        $statementStub = $this->createStub(PDOStatement::class);

        $queryReturn = [
            'uuid'=>'73a0b2d0-2408-4aaa-ac00-14180264dd1f',
            'author_uuid'=>'89e1519a-5684-44e6-9429-d227dc79f735',
            "post_uuid"=>'32c6434e-8377-444d-867a-056b34e623e9',
            'text'=>"Текст"
        ];
        
        $statementStub->method('fetch')->willReturn($queryReturn);

        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteCommentsRepository($connectionStub);

        $result=$repository->get(new UUID('73a0b2d0-2408-4aaa-ac00-14180264dd1f'));
        $this->assertEquals(new Comment(
            new UUID('73a0b2d0-2408-4aaa-ac00-14180264dd1f'),
            new UUID('89e1519a-5684-44e6-9429-d227dc79f735'),
            new UUID('32c6434e-8377-444d-867a-056b34e623e9'),
            'Текст'), $result);
    }
}