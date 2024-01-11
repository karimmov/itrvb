<?php

namespace Tgu\Karimov\Repositories;

use Tgu\Karimov\Posts\Article;
use Tgu\Karimov\Posts\UUID;

interface PostsRepositoryInterface
{
    public function save(Article $article) : void;
    public function get(UUID $uuid) : Article;


}