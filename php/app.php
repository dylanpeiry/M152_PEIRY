<?php
/**
 * Created by PhpStorm.
 * User: peiryd_info
 * Date: 24.01.2018
 * Time: 14:21
 */

class App
{
    public static function insertPost($comment, $namesMedias, $typesMedias): bool
    {
        $sql = "INSERT INTO posts(comment) VALUES (:c)";
        try {
            $db = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
            $db->execute(array(
                ':c' => $comment
            ));
            $id = EDatabase::lastInsertId();
            $sql = "INSERT INTO medias(nameMedia,typeMedia,idPost) VALUES (:n,:t,:id)";
            for ($i = 0; $i < count($namesMedias); $i++) {
                $db = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
                $db->execute(array(
                    ':n' => $namesMedias[$i],
                    ':t' => $typesMedias[$i],
                    ':id' => $id
                ));
            }
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function getPosts()
    {
        $posts = [];
        $sql = "SELECT idMedia,nameMedia,typeMedia,medias.idPost,comment,datePost FROM medias,posts WHERE medias.idPost = posts.idPost";
        try {
            $db = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
            $db->execute();
            while ($row = $db->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
                array_push($posts, array($row['idMedia'], $row['nameMedia'], $row['typeMedia'], $row['idPost'], $row['comment'], $row['datePost']));
            }
            return $posts;
        } catch (PDOException $e) {
            return false;
        }
    }
}