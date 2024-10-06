<?php
require 'dto/Tag.php';

function getTags($user_id) {
    $connection = new mysqli("db", "root", "admin", "movie_tasker");

    if($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $stmt = $connection->prepare("SELECT * FROM tags WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $tags = [];

    while($row = $result->fetch_assoc()) {
        $tags = new Tag($row["id"], $row["title"], $row["is_used"], $row["user_id"]);
    }

    $stmt->close();
    $connection->close();
    return $tags;
}

function addTag($tagDTO) {
    $connection = new mysqli("db", "root", "admin", "movie_tasker");

    if($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $stmt = $connection->prepare("INSERT INTO tags (title, is_used, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $tagDTO->title, $tagDTO->is_used, $tagDTO->user_id);

    if($stmt->execute()) {
        $tagDTO->id = $connection->insert_id;
        $stmt->close();
        $connection->close();
        return $tagDTO;
    } else {
        $stmt->close();
        $connection->close();
        return false;
    }
}

function deleteTag($id) {
    $connection = new mysqli("db", "root", "admin", "movie_tasker");

    if($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $stmt = $connection->prepare("DELETE FROM tags WHERE id = ?");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();

    $stmt->close();
    $connection->close();
    return $result;
}