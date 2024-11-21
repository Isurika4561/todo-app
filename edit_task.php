<?php
include 'db.php';
$id = $_GET['id'];
$task = $conn->prepare("SELECT * FROM tasks WHERE id = :id");
$task->execute(['id' => $id]);
$task = $task->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $task_date = $_POST['task_date'];
    $stmt = $conn->prepare("UPDATE tasks SET title = :title, description = :description, task_date = :task_date WHERE id = :id");
    $stmt->execute(['title' => $title, 'description' => $description, 'task_date' => $task_date, 'id' => $id]);
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
    <form action="update_completion.php" method="POST">
    <div class="mb-3">
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($task['title']) ?>" required>
        </div>
        <div class="mb-3">
            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($task['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <input type="date" name="task_date" class="form-control" value="<?= $task['task_date'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
    <label for="completion_slider_<?= $task['id'] ?>">Completion Level:</label>
    <input 
        type="range" 
        id="completion_slider_<?= $task['id'] ?>" 
        name="completion_level" 
        class="form-range" 
        min="0" 
        max="100" 
        step="10" 
        value="<?= $task['completion_level'] ?>" 
        oninput="updateCompletionValue<?= $task['id'] ?>(this.value)"
    >
    <span id="completion_value_<?= $task['id'] ?>" class="fw-bold"><?= $task['completion_level'] ?>%</span>
    <button type="submit" class="btn btn-primary btn-sm mt-2">Update</button>
</form>
<script>
    function updateCompletionValue<?= $task['id'] ?>(value) {
        document.getElementById('completion_value_<?= $task['id'] ?>').textContent = value + '%';
    }
</script>

</div>
</body>
</html>
