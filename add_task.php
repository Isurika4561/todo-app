<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $task_date = $_POST['task_date'];
    $stmt = $conn->prepare("INSERT INTO tasks (title, task_date) VALUES (:title, :task_date)");
    $stmt->execute(['title' => $title, 'task_date' => $task_date]);
}

header('Location: index.php');
exit;
?>
