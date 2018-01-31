<?php
/**
 * Created by PhpStorm.
 * User: peiryd_info
 * Date: 24.01.2018
 * Time: 14:21
 */

class App
{
    public static function insertPost($comment, $mediaType, $mediaName): bool
    {
        $sql = "INSERT INTO posts(comment) VALUES (:c)";
        try {
            $db = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
            $db->execute(array(
                ':c' => $comment
            ));
            $id = EDatabase::lastInsertId;
            $sql = "INSERT INTO medias(nameMedia,typeMedia,"
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function getPosts()
    {
        $posts = [];
        $sql = "SELECT * FROM posts";
        try {
            $db = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
            $db->execute();
            while ($row = $db->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
                array_push($posts, array($row['idPost'], $row['comment'], $row['typeMedia'], $row['nameMedia'], $row['datePost']));
            }
            return $posts;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function insertMoveFile($errorCode,$fileName,$fileType,$fileTmp,$comment){
        if ($errorCode == 0) {
            $result = App::insertPost($comment, $fileType, $fileName);
            if ($result) {
                $dest = "uploads/" . $fileName;
                move_uploaded_file($fileTmp, $dest);
                header('Location: index.php');
                exit();
            } else {
                return "Erreur lors de l'insertion du post.";
            }
        } else {
            return "Erreur lors de l'upload du fichier.";
        }
    }
}