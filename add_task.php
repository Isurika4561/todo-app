<?php
include 'db.php';

$title = $_POST['task_title'];
$description = $_POST['task_description'];
$task_date = $_POST['task_date'];
$completion_level = $_POST['completion_level']; // Get completion level from form

$sql = "INSERT INTO tasks (title, description, task_date, completion_level) VALUES (:title, :description, :task_date, :completion_level)";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':title' => $title,
    ':description' => $description,
    ':task_date' => $task_date,
    ':completion_level' => $completion_level
]);

header("Location: index.php?task_date=$task_date");
exit;
?>
