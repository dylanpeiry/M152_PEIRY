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
    $allowedType;
    $isTypeInvalid;
    $message;
    //file vars
    $files = array();
    if (isset($_POST['new_video'])) {
        $files = $_FILES['videos'];
        $allowedType = "video/";
    } else if (isset($_POST['new_image'])) {
        $files = $_FILES['images'];
        $allowedType = "image/";
    } else if (isset($_POST['new_audio'])) {
        $files = $_FILES['audios'];
        $allowedType = "audio/";
    }
    $filesCount = count($files['name']);

    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
    $namesMedias = array();
    $typesMedias = array();
    $tmpsMedias = array();
    for ($i = 0; $i < $filesCount; $i++) {
        $errorCode = $files['error'][$i];
        $fileName = uniqid("file_");
        $fileType = $files['type'][$i];
        $fileTmp = $files['tmp_name'][$i];
        if (strpos($fileType, $allowedType) !== false) {
            if ($errorCode == 0) {
                array_push($namesMedias, $fileName);
                array_push($typesMedias, $fileType);
                array_push($tmpsMedias, $fileTmp);
            } else {
                $message = "Erreur lors de l'upload d'un fichier.";
            }
        } else {
            $isTypeInvalid = true;
        }
    }
    if (!$isTypeInvalid) {
        $result = App::insertPost($comment, $namesMedias, $typesMedias);
        if ($result) {
            for ($i = 0; $i < count($tmpsMedias); $i++) {
                $dest = "uploads/" . $namesMedias[$i];
                if (!move_uploaded_file($tmpsMedias[$i], $dest)) {
                    $message = "Erreur lors de l'upload d'un fichier.";
                }
            }
            header('Location: index.php');
            exit();
        } else {
            $message = "Erreur lors de l'insertion d'un post.";
        }
    }else{
        $message = "Les types des fichiers doivent être les mêmes.(Video,Image ou Audio)";
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
<?php
if (isset($message)) {
    ?>
    <div class="alert alert-danger" role="alert">
        <strong>ERREUR</strong> <?=$message?>
    </div>
    <?php
}
?>
<div class="container">
    <fieldset>
        <legend>Poster des images</legend>
        <form action="post.php" method="POST" enctype="multipart/form-data" class="post_form">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <input class="btn btn-outline-primary" type="submit" name="new_image" value="Poster les images">
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
                    <input class="btn btn-outline-primary" type="submit" name="new_video" value="Poster les vidéos">
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
    <fieldset>
        <legend>Poster des audios</legend>
        <form action="post.php" method="POST" enctype="multipart/form-data" class="post_form">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <input class="btn btn-outline-primary" type="submit" name="new_audio" value="Poster les audios">
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="audio" name="audios[]" required multiple
                           accept="audio/*">
                    <label class="custom-file-label" for="video">Sélectionner des audios</label>
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
