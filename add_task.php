<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $task_date = $_POST['task_date'] ?? '';
    $completion_level = $_POST['completion_level'] ?? '';

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
}

// Fetch tasks to display in the task list
$sql = "SELECT * FROM tasks ORDER BY task_date DESC";
$stmt = $conn->query($sql);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
