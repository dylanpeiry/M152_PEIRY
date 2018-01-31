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
        $sql = "INSERT INTO posts(comment,typeMedia,nameMedia) VALUES (:c,:t,:n)";
        try {
            $db = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
            $db->execute(array(
                ':c' => $comment,
                ':t' => $mediaType,
                ':n' => $mediaName
            ));
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
}