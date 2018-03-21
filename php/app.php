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
        $posts = array();
        $sql = "SELECT idPost FROM posts";
        try {
            $db = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
            $db->execute();
            while ($row = $db->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
                $t = self::getMediasByPost($row['idPost']);
                $posts[$row['idPost']] = $t;
            }
            return $posts;
        } catch (PDOException $e) {
            return false;
        }
    }

    private static function getPost($postId)
    {
        $post = array();
        $sql = "SELECT * FROM posts WHERE idPost = :id";
        try {
            $db = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
            $db->execute(array(':id' => $postId));
            while ($row = $db->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
                array_push($post, array($row['idPost'], $row['comment'], $row['datePost']));
            }
            return $post;
        } catch (PDOException $e) {
            return false;
        }
    }

    private static function getMediasByPost($postId)
    {
        $comment = self::getPost($postId)[0][1];
        $medias = [];
        $sql = "SELECT idMedia,nameMedia,typeMedia FROM medias WHERE idPost = :id";
        try {
            $db = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
            $db->execute(array(':id' => $postId));
            while ($row = $db->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
                array_push($medias, array($row['idMedia'], $row['nameMedia'], $row['typeMedia']));
            }
            $data = array($comment => $medias);
            return $data;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function deletePost($postId){
        $sql = "DELETE * FROM medias, posts WHERE posts.idPost = medias.idPost AND posts.idPost = :id";
        try {
            $db = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
            $db->execute(array(':id' => $postId));
        } catch (PDOException $e){
            return false;
        }

    }
}