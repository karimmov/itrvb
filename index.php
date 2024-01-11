<?php

use Tgu\Karimov\Posts\Article;
use Tgu\Karimov\Posts\Comment;
use Tgu\Karimov\Posts\User;
use Tgu\Karimov\Posts\UUID;

require_once __DIR__. "/vendor/autoload.php";

$user = new User(UUID::random(), 'vasek', 'Vasiliy', 'Artemov');
$user2 = new User(UUID::random(), 'vasek2', 'Ivan', 'Artemov');

$article = new Article(1, $user, "Какой-то заголовок", "Какой-то текст");
$comment = new Comment(1, $user2, $article, "Какой-то комментарий");


echo $article;
echo "<br/> <br/>";
echo $comment;
?>

