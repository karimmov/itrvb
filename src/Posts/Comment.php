<?php

namespace Tgu\Karimov\Posts;


class Comment 
{
    function __construct(private UUID $uuid, private UUID $author_uuid, private UUID $article_uuid, private string $text)
    {
        
    }

    public function getUUID()
    {
        return $this->uuid;
    }

    public function getAuthor()
    {
        return $this->author_uuid;
    }

    public function getPost()
    {
        return $this->article_uuid;
    }

    public function getText()
    {
        return $this->text;
    }

    // function __toString()
    // {
    //     return "$this->author написал комментарий $this->text к статье <br/> $this->article";
    // }
}

?>