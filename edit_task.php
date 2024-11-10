<?php
include 'db.php';
$id = $_GET['id'];
$task = $conn->prepare("SELECT * FROM tasks WHERE id = :id");
$task->execute(['id' => $id]);
$task = $task->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $task_date = $_POST['task_date'];
    $stmt = $conn->prepare("UPDATE tasks SET title = :title, task_date = :task_date WHERE id = :id");
    $stmt->execute(['title' => $title, 'task_date' => $task_date, 'id' => $id]);
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Task</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="my-4">Edit Task</h2>
    <form method="POST">
        <div class="mb-3">
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($task['title']) ?>" required>
        </div>
        <div class="mb-3">
            <input type="date" name="task_date" class="form-control" value="<?= $task['task_date'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
