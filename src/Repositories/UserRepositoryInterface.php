<?php

namespace Tgu\Karimov\Repositories;

use Tgu\Karimov\Posts\User;
use Tgu\Karimov\Posts\UUID;

interface UserRepositoryInterface
{
    public function save(User $user) : void;
    public function get(UUID $uuid) : User;


}