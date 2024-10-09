<?php
require_once 'dto/Tag.php';
require_once './connection.php';

function getTags($user_email) {
    $stmt = $connection->prepare("SELECT * FROM tags WHERE user_email = ?");
    $stmt->bind_param("i", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    $tags = [];

    while($row = $result->fetch_assoc()) {
        $tags = new Tag($row["id"], $row["title"], $row["is_used"], $row["user_email"]);
    }

    $stmt->close();
    $connection->close();
    return $tags;
}

function addTag($tagDTO) {
    $stmt = $connection->prepare("INSERT INTO tags (title, is_used, user_email) VALUES (?, ?, ?)");
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
    $stmt = $connection->prepare("DELETE FROM tags WHERE id = ?");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();

    $stmt->close();
    $connection->close();
    return $result;
}