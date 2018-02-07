<?php
/**
 * Created by PhpStorm.
 * User: peiryd_info
 * Date: 24.01.2018
 * Time: 13:28
 */

require_once 'php/inc.all.php';
//Si les variables contiennent les données envoyées du formulaire, on va les traiter et les ajouter dans la BDD
$message;
if (!empty($_POST) && !empty($_FILES)) {
    var_dump($_POST, $_FILES); //debug

    //file vars
    $files = array();
    if ($_POST['new_video']) {
        $files = $_FILES['videos'];
    } else if ($_POST['new_image']) {
        $files = $_FILES['images'];
    }
    $filesCount = count($files['name']);

    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
    $namesMedias = array();
    $typesMedias = array();
    $tmpsMedias = array();
    for ($i = 0; $i < $filesCount; $i++) {
        $errorCode = $files['error'][$i];
        $fileName = $files['name'][$i];
        $fileType = $files['type'][$i];
        $fileTmp = $files['tmp_name'][$i];

        if ($errorCode == 0) {
            array_push($namesMedias, $fileName);
            array_push($typesMedias, $fileType);
            array_push($tmpsMedias, $fileTmp);
        } else {
            return "Erreur lors de l'upload d'un fichier.";
        }
    }

    $result = App::insertPost($comment, $namesMedias, $typesMedias);
    if ($result) {
        for ($i = 0; $i < count($tmpsMedias); $i++) {
            $dest = "uploads/" . $namesMedias[$i];
            move_uploaded_file($tmpsMedias[$i], $dest);
        }
        header('Location: index.php');
        exit();
    } else {
        $message = "Erreur lors de l'insertion d'un post.";
    }

}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Post</title>

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
        <a class="nav-link" href="index.php">Accueil</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="#">Posts</a>
    </li>
</ul>
<div class="container">
    <fieldset>
        <legend>Poster des images</legend>
        <form action="post.php" method="POST" enctype="multipart/form-data" class="post_form">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <input class="btn btn-outline-secondary" type="submit" name="new_image" value="Poster les images">
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="image" name="images[]" required multiple
                           accept="image/*">
                    <label class="custom-file-label" for="video">Sélectionner des images</label>
                </div>
            </div>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Commentaire</span>
                </div>
                <textarea class="form-control" name="comment" id="comment" cols="30" rows="3" required></textarea>
            </div>
        </form>
    </fieldset>
    <fieldset>
        <legend>Poster des vidéos</legend>
        <form action="post.php" method="POST" enctype="multipart/form-data" class="post_form">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <input class="btn btn-outline-secondary" type="submit" name="new_video" value="Poster les vidéos">
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="video" name="videos[]" required multiple
                           accept="video/*">
                    <label class="custom-file-label" for="video">Sélectionner des vidéos</label>
                </div>
            </div>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Commentaire</span>
                </div>
                <textarea class="form-control" name="comment" id="comment" cols="30" rows="3" required></textarea>
            </div>
        </form>
    </fieldset>
</div>
</body>
</html>
