<?php

namespace Tgu\Karimov;

use Tgu\Karimov\Article;
use Tgu\Karimov\User;

class Comment 
{
    function __construct(private int $id, private User $author, private Article $article, private string $text)
    {
        
    }

    function __toString()
    {
        return "$this->author написал комментарий $this->text к статье <br/> $this->article";
    }
}

?>