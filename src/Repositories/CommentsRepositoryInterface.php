<?php

namespace Tgu\Karimov\Repositories;

use Tgu\Karimov\Posts\Comment;
use Tgu\Karimov\Posts\UUID;

interface CommentsRepositoryInterface
{
    public function save(Comment $comment) : void;
    public function get(UUID $uuid) : Comment;
}