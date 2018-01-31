<?php
/**
 * Created by PhpStorm.
 * User: peiryd_info
 * Date: 24.01.2018
 * Time: 13:27
 */

require_once 'php/inc.all.php';
$posts = App::getPosts();
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>

    <!-- CSS & Scripts -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navigation">
    <a href="index.php" class="active">Home</a> |
    <a href="post.php">Post</a>
</nav>
<div class="home">
    <img src="img/heisenberg.jpg" class="profile_picture">
    <p class="welcome_message">Bienvenue utilisateur</p>
</div>
<div class="posts">
    <?php
    foreach ($posts as $post) {
        ?>
        <figure>
            <img src="uploads/<?=$post[3]?>" alt="Photo de commentaire" class="post_picture">
            <figcaption><?=$post[1]?></figcaption>
        </figure>
        <?php
    }
    ?>
</div>
</body>
</html>
