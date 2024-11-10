<?php
include 'db.php';
$id = $_GET['id'];
$task = $conn->prepare("SELECT completed FROM tasks WHERE id = :id");
$task->execute(['id' => $id]);
$status = $task->fetch(PDO::FETCH_ASSOC)['completed'] ? 0 : 1;

$stmt = $conn->prepare("UPDATE tasks SET completed = :status WHERE id = :id");
$stmt->execute(['status' => $status, 'id' => $id]);
header('Location: index.php');
exit;
?>
