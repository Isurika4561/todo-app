<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskId = $_POST['task_id'];
    $comment = $_POST['comment'];

    $stmt = $conn->prepare("INSERT INTO task_comments (task_id, comment) VALUES (:task_id, :comment)");
    $stmt->execute(['task_id' => $taskId, 'comment' => $comment]);
}

header('Location: index.php');
exit;
?>
