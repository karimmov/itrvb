<?php

require_once __DIR__. "/vendor/autoload.php";

use Tgu\Karimov\Article;
use Tgu\Karimov\Comment;
use Tgu\Karimov\User;

spl_autoload_register(function ($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . 'php';
    $index = strripos($file, "Class_");
    if ($index !== false) {
        $name = substr($file, $index+6);
        $file = str_replace("Class_", "Class/$name", $file);
    }
    

    if (file_exists($file)) {
        require "$class.php"; 
    }
    
});

$user = new User(1, "Иван", "Васильев");
$article = new Article(1, $user, "Какой-то заголовок", "Какой-то текст");
$user2 = new User(1, "Василий", "Редькин");
$comment = new Comment(1, $user2, $article, "Какой-то комментарий");


echo $article;
echo "<br/> <br/>";
echo $comment;
?>

