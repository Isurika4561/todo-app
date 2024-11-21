<?php
include 'db.php';

$task_id = $_POST['task_id'];
$completion_level = $_POST['completion_level'];

$sql = "UPDATE tasks SET completion_level = :completion_level WHERE id = :task_id";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':completion_level' => $completion_level,
    ':task_id' => $task_id
]);

header("Location: index.php");
exit;
?>
