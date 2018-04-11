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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css"
          integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <script src="js/app.js" type="text/javascript"></script>
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
    $count = count($medias);
    ?>
    <div class="row">
        <div class="card mb-3">
            <div id="<?= $htmlID ?>" class="carousel slide" data-ride="carousel" data-interval="false">
                <?php if ($count > 1) { ?>
                    <ol class="carousel-indicators">
                        <?php
                        for ($i = 0; $i < $count; $i++) {
                            ?>
                            <li data-target="#<?= $htmlID ?>" data-slide-to="<?= $count ?>"
                                class="<?php if ($i == 0) echo "active"; ?>"></li>
                            <?php
                        }
                        ?>
                    </ol>
                    <?php
                }
                ?>
                <div class="carousel-inner">
                    <?php
                    foreach ($medias

                    as $index => $media) {
                    $nameMedia = $media[1];
                    $type = $media[2];
                    ?>
                    <div class="carousel-item <?php if ($index == 0) echo 'active'; ?>">
                        <?php
                        if (strpos($type, "video") !== false) {
                        ?>
                        <video width="320" height="240" controls <?php if ($index == 0) echo 'autoplay'; ?>>
                            <source src="uploads/<?= $nameMedia ?>" type="<?= $type ?>">
                        </video>
                    </div>
                    <?php
                    }else if (strpos($type, "audio") !== false) {
                    ?>
                    <audio controls>
                        <source src="uploads/<?= $nameMedia ?>" type="<?= $type ?>">
                    </audio>
                </div>
                <?php
                } else {
                ?>
                <img class="d-block w-100 post_picture" src="uploads/<?= $nameMedia ?>" alt="First slide">
            </div>
            <?php
            }
            }
            ?>
        </div>
    </div>
    <div class="card-block text-center">
        <h4 class="card-title"><?= $comment ?></h4>
        <button type="button" class="btn btn-danger delete" id="delete_post#<?= $id ?>"><i class="fa fa-trash"></i>
        </button>
        <button type="button" class="btn btn-warning edit" id="edit_post#<?= $id ?>"><i
                    class="fa fa-pencil-alt "></i></button>
    </div>
    <?php
    if ($count > 1) {
        ?>
        <a class="carousel-control-prev" href="#<?= $htmlID ?>" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#<?= $htmlID ?>" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        <?php
    }
    ?>
</div>
</div>
<?php
}
?>

<div class="modal fade" id="deleteConfirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmation de suppression</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert" id="postAlert">
                    Êtes-vous sur de vouloir supprimer ce post "<a class="postDescription"></a>" ainsi que ses images ?
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-danger deletepost">Supprimer</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modification d'un post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="#post_content">Description du post</label>
                <input id="post_content" class="form-control">
                <label for="#post_medias">Médias</label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-warning editpost">Modifier</button>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    $('.delete').click(function () {
        var text = $(this).siblings()[0].textContent;
        var id = $(this).parent().prev()[0].id.substr(4);
        MessageBox.confirmation(text, id);

    })
    $('.deletepost').click(function () {
        var id = $(this).parent().siblings('.modal-body').find(".postDescription")[0].id;
        MessageBox.accepted(id);
    });
    $('.edit').click(function () {
        var text = $(this).siblings()[0].textContent;
        $('#post_content').attr('placeholder', text);
        $('#edit').modal('show');
    })
</script>
</html>