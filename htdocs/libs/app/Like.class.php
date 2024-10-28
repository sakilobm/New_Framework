<?php

class Likes
{
    public static function likePost($id)
    {
        $conn = Database::getConnection();
        $sql = "UPDATE `posts` SET `likes` = `likes` + 1 WHERE `id` = '$id'";
        return $conn->query($sql);
    }

    public static function undoLike($id)
    {
        $conn = Database::getConnection();
        $sql = "UPDATE `posts` SET `likes` = `likes` - 1 WHERE `id` = '$id'";
        return $conn->query($sql);
    }
}
