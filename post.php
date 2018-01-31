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
    $files = $_FILES['images'];
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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navigation">
    <a href="index.php">Home</a> |
    <a href="post.php" class="active">Post</a>
</nav>
<fieldset>
    <legend>Poster un statut</legend>
    <form action="post.php" method="POST" enctype="multipart/form-data" class="post_form">
        <label for="comment">Commentaire</label>
        <textarea name="comment" id="comment" cols="30" rows="5" required></textarea>
        <br>
        <label for="image">Image</label>
        <input type="file" name="images[]" id="image" required multiple accept="image/*">
        <br>
        <input type="submit" value="Envoyer">
    </form>
</fieldset>
</body>
</html>
