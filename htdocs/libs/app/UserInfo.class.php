<?php

class UserInfo
{
    public static function getEmailByUser($username)
    {
        $conn = Database::getConnection();
        $sql = "SELECT `email` FROM `auth` WHERE `username` = '$username' LIMIT 50";
        $result = $conn->query($sql);
        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            $mail = $row['email'];
            return $mail;
        } else {
            return false;
        }
    }
    public static function getUserByEmail($email)
    {
        $conn = Database::getConnection();
        $sql = "SELECT `username` FROM `auth` WHERE `email` = '$email' LIMIT 50";
        $result = $conn->query($sql);
        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            $username = $row['username'];
            return $username;
        } else {
            return false;
        }
    }
    public static function getUserAlbum($email)
    {
        $conn = Database::getConnection();
        $sql = "SELECT `album` FROM `album` WHERE `email` = '$email' LIMIT 50";
        $result = $conn->query($sql);
        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            return $row['album'];
        } else {
            return false;
        }
    }
}
