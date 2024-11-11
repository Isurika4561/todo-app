<?php
include 'db.php';

// Handle date filtering
$dateFilter = isset($_GET['task_date']) ? $_GET['task_date'] : date('Y-m-d');

// Fetch tasks based on the selected date
$query = $conn->prepare("SELECT * FROM tasks WHERE task_date = :task_date ORDER BY id DESC");
$query->execute(['task_date' => $dateFilter]);
$tasks = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ToDo List</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2 class="text-center my-4">To-Do List</h2>

    <!-- Date Filter -->
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="date" name="task_date" class="form-control" value="<?= $dateFilter ?>" required>
            <button class="btn btn-secondary" type="submit">Filter by Date</button>
        </div>
    </form>

    <!-- Add Task Form -->
    <form action="add_task.php" method="POST" class="mb-3">
        <div class="input-group mb-2">
            <input type="text" name="title" class="form-control" placeholder="Task Title" required>
            <input type="date" name="task_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>
        <textarea name="description" class="form-control mb-2" placeholder="Task Description" rows="3"></textarea>
        <button class="btn btn-primary w-100" type="submit">Add Task</button>
    </form>

    <!-- Task List -->
    <ul class="list-group">
        <?php if (count($tasks) > 0): ?>
            <?php foreach ($tasks as $task): ?>
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="fw-bold <?= $task['completed'] ? 'text-decoration-line-through' : '' ?>">
                        <?= htmlspecialchars($task['title']) ?>
                    </div>
                    <small class="text-muted"><?= htmlspecialchars($task['description']) ?></small>
                </div>
                <div>
                    <a href="mark_complete.php?id=<?= $task['id'] ?>" class="btn btn-sm <?= $task['completed'] ? 'btn-secondary' : 'btn-success' ?> me-1">
                        <?= $task['completed'] ? 'Uncomplete' : 'Complete' ?>
                    </a>
                    <a href="edit_task.php?id=<?= $task['id'] ?>" class="btn btn-warning btn-sm me-1">Edit</a>
                    <a href="delete_task.php?id=<?= $task['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                </div>
            </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="list-group-item text-center">No tasks found for this date.</li>
        <?php endif; ?>
    </ul>
</div>
</body>
</html>
