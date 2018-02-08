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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
</head>
<body>
<!-- Navigation -->
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" href="#">Accueil</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="post.php">Posts</a>
    </li>
</ul>

<div class="home">
    <img src="img/heisenberg.jpg" class="profile_picture">
    <p class="welcome_message">Bienvenue utilisateur</p>
</div>
<div class="container posts">
    <?php
    foreach ($posts

    as $id => $medias) {
    $comment = key($medias);
    $htmlID = "post$id";
    $medias = array_values($medias)[0];
    ?>
    <p><?= $comment ?></p>
    <div id="<?= $htmlID ?>" class="carousel slide" data-ride="carousel" data-interval="false">
        <ol class="carousel-indicators">
            <li data-target="#<?= $htmlID ?>" data-slide-to="0" class="active"></li>
            <li data-target="#<?= $htmlID ?>" data-slide-to="1"></li>
            <li data-target="#<?= $htmlID ?>" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <?php
            foreach ($medias

            as $index => $media) {
            $nameMedia = $media[1];
            $type = $media[2];
            ?>
            <div class="carousel-item <?php if ($index == 0) echo 'active'; ?>">
                <?php
                if (strpos($type, "video") != false) {
                ?>
                <video width="320" height="240" controls>
                    <source src="uploads/<?=$nameMedia?>" type="<?=$type?>">
                </video>
            </div>
            <?php
            } else {
            ?>
            <img class="d-block w-100" src="uploads/<?= $nameMedia ?>" alt="First slide">
        </div>
        <?php
        }
        }
        ?>

    </div>
    <a class="carousel-control-prev" href="#<?= $htmlID ?>" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#<?= $htmlID ?>" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<?php
}
?>
</div>
</body>
</html>