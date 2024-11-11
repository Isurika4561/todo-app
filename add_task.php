<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $task_date = $_POST['task_date'];
    
    $stmt = $conn->prepare("INSERT INTO tasks (title, description, task_date, completed) VALUES (:title, :description, :task_date, 0)");
    $stmt->execute(['title' => $title, 'description' => $description, 'task_date' => $task_date]);
}

header('Location: index.php');
exit;
?>
