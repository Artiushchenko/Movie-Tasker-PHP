<?php
function getUserTags($connection, $user_email)
{
    $stmt = $connection->prepare('SELECT * FROM tags WHERE user_email = ?');
    $stmt->bind_param('s', $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    $tags = [];

    while ($row = $result->fetch_assoc()) {
        $tags[] = $row;
    }

    $stmt->close();
    return $tags;
}