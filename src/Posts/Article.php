<?php

namespace Tgu\Karimov\Posts;


class Article
{ 
    function __construct(private UUID $uuid, private UUID $author_uuid, private string $title, private string $text)
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

    public function getTitle()
    {
        return $this->title;
    }

    public function getText()
    {
        return $this->text;
    }

    // function __toString()
    // {
    //     return "Заголовок: $this->title <br/> Текст: $this->text <br/> Автор: $this->author";
    // }
}

?>