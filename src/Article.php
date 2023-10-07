<?php

namespace Tgu\Karimov;

use Tgu\Karimov\User;

class Article
{ 
    function __construct(private int $id, private User $author, private string $title, private string $text)
    {
        
    }

    function __toString()
    {
        return "Заголовок: $this->title <br/> Текст: $this->text <br/> Автор: $this->author";
    }
}

?>