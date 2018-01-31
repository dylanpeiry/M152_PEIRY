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
    <figure>
        <p>description photos</p>
        <img src="uploads/heisenberg.jpg" alt="" class="post_picture">
        <img src="uploads/heisenberg.jpg" alt="" class="post_picture">
        <img src="uploads/jessie.jpg" alt="" class="post_picture">
    </figure>
    <br>
    <?php
    $lastId = -1;

    foreach ($posts as $post) {
        $id = $post[3];

        if ($id != $lastId) {
            ?>
            <figure id="<?= $id ?>">
            <p><?= $post[4] ?></p>
            <?php
        }
        ?>
        <img src="uploads/<?= $post[1] ?>" alt="Photo de commentaire" class="post_picture">
        <?php
        if ($id == $lastId) {
            ?>
            </figure><br>
            <?php
        }
        $lastId = $id;
    }
    ?>
</div>
</body>
</html>
