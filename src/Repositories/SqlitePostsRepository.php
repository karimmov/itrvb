<?

namespace Tgu\Karimov\Repositories;

use Tgu\Karimov\Posts\Article;
use Tgu\Karimov\Posts\UUID;
use PDO;
use Tgu\Karimov\Exception\PostNotFoundException;

class SqlitePostsRepository implements PostsRepositoryInterface
{
    public function __construct(private PDO $conn) 
    {
        
    }
    public function save(Article $article) : void
    {
        $statement = $this->conn->prepare(
            'INSERT INTO posts (uuid, author_uuid, title, text) VALUES (:uuid, :author_uuid, :title, :text)'
        );

        $statement->execute([
            ":uuid"=> (string)$article->getUUID(),
            ":author_uuid"=>(string)$article->getAuthor()->getUUID(),
            ":title"=>$article->getTitle(),
            ":text"=>$article->getText()
        ]);
    }

    public function get(UUID $uuid) : Article
    {
        $statement = $this->conn->prepare(
            'SELECT * FROM posts WHERE uuid = :uuid'
        );

        $statement->execute([
            ':uuid' => (string)$uuid
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result == false) {
            throw new PostNotFoundException("Cannot get article: $uuid");
        }

        $userRepository = new SqliteUsersRepository($this->conn);
        $author = $userRepository->get(new UUID($result['author_uuid']));

        return new Article(
            new UUID($result['uuid']),
            $author,
            $result['title'],
            $result['text']
        );
    }
}