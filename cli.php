<?php

use Tgu\Karimov\Posts\UUID;
use Tgu\Karimov\Repositories\SqliteUsersRepository;
use Tgu\Karimov\Posts\User;

require_once __DIR__. "/vendor/autoload.php";




$connection = new PDO('sqlite:' .__DIR__ .'/blog.sqlite');

$userRepository = new SqliteUsersRepository($connection);
$userRepository->save(new User(UUID::random(), 'pro100 nekit', 'Никита', 'Никитов'));

?>