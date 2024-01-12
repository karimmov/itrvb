<?php

namespace Tgu\Karimov\Repositories;

use Tgu\Karimov\Posts\Comment;
use Tgu\Karimov\Posts\UUID;
use PDO;
use Tgu\Karimov\Exception\CommentNotFoundException;

class SqliteCommentsRepository implements CommentsRepositoryInterface
{
    public function __construct(private PDO $conn) 
    {
        
    }

    public function save(Comment $comment):void
    {
        $statement=$this->conn->prepare(
            'INSERT INTO comments (uuid, post_uuid, author_uuid, text) VALUES (:uuid, :post_uuid, :author_uuid, :text)'
        );

        $statement->execute([
            ":uuid"=>$comment->getUUID(),
            ":post_uuid"=>(string)$comment->getPost(),
            ":author_uuid"=>(string)$comment->getAuthor(),
            ":text"=>$comment->getText()
        ]);
    }

    public function get(UUID $uuid):Comment
    {
        $statement = $this->conn->prepare(
            'SELECT * FROM comments WHERE uuid = :uuid'
        );

        $statement->execute([
            ":uuid"=>(string)$uuid
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result == false) {
            throw new CommentNotFoundException("Cannot get comment: $uuid");
        }

        $userRepository = new SqliteUsersRepository($this->conn);
        $author = $userRepository->get(new UUID($result['author_uuid']));
        
        $postRepository = new SqlitePostsRepository($this->conn);
        $article = $postRepository->get(new UUID($result['post_uuid']));

        return new Comment(
            new UUID($result['uuid']),
            new UUID($result['author_uuid']),
            new UUID($result['post_uuid']),
            $result['text']
        );
    }
}