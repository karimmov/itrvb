<?php

namespace Tgu\Karimov\Posts;


class Comment 
{
    function __construct(private UUID $uuid, private User $author, private Article $article, private string $text)
    {
        
    }

    public function getUUID()
    {
        return $this->uuid;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getPost()
    {
        return $this->article;
    }

    public function getText()
    {
        return $this->text;
    }

    function __toString()
    {
        return "$this->author написал комментарий $this->text к статье <br/> $this->article";
    }
}

?>