<?php
include 'db.php';
$id = $_GET['id'];
$task = $conn->prepare("SELECT completed FROM tasks WHERE id = :id");
$task->execute(['id' => $id]);
$completed = $task->fetch(PDO::FETCH_ASSOC)['completed'] ? 0 : 1;

$stmt = $conn->prepare("UPDATE tasks SET completed = :completed WHERE id = :id");
$stmt->execute(['completed' => $completed, 'id' => $id]);
header('Location: index.php');
exit;
?>
