<?php
include 'db.php';

// Date filter
$dateFilter = isset($_GET['task_date']) ? $_GET['task_date'] : date('Y-m-d');

// Fetch tasks by date
$taskQuery = $conn->prepare("SELECT * FROM tasks WHERE task_date = :task_date ORDER BY id DESC");
$taskQuery->execute(['task_date' => $dateFilter]);
$tasks = $taskQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ToDo List with Comments</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2 class="text-center my-4">To-Do List with Comments</h2>

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
            <li class="list-group-item">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="form-check">
                        <input class="form-check-input mark-complete" type="checkbox" 
                               data-id="<?= $task['id'] ?>" 
                               <?= $task['completed'] ? 'checked' : '' ?>>
                        <label class="form-check-label <?= $task['completed'] ? 'text-decoration-line-through' : '' ?>">
                            <strong><?= htmlspecialchars($task['title']) ?></strong><br>
                            <small><?= htmlspecialchars($task['description']) ?></small>
                        </label>
                    </div>
                    <div>
                        <a href="edit_task.php?id=<?= $task['id'] ?>" class="btn btn-warning btn-sm me-1">Edit</a>
                        <a href="delete_task.php?id=<?= $task['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                    </div>
                </div>

                <!-- Comments Section -->
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#comments-<?= $task['id'] ?>">Comments</button>
                <div id="comments-<?= $task['id'] ?>" class="collapse">
                    <ul class="list-group mb-2">
                        <?php
                        // Fetch comments for this task
                        $commentQuery = $conn->prepare("SELECT * FROM task_comments WHERE task_id = :task_id ORDER BY created_at DESC");
                        $commentQuery->execute(['task_id' => $task['id']]);
                        $comments = $commentQuery->fetchAll(PDO::FETCH_ASSOC);
                        
                        foreach ($comments as $comment): ?>
                            <li class="list-group-item"><?= htmlspecialchars($comment['comment']) ?> <small class="text-muted">(<?= $comment['created_at'] ?>)</small></li>
                        <?php endforeach; ?>
                    </ul>

                    <!-- Add Comment Form -->
                    <form action="add_comment.php" method="POST">
                        <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                        <div class="input-group mb-2">
                            <input type="text" name="comment" class="form-control" placeholder="Add a comment..." required>
                            <button class="btn btn-primary" type="submit">Add</button>
                        </div>
                    </form>
                </div>
            </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="list-group-item text-center">No tasks found for this date.</li>
        <?php endif; ?>
    </ul>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.mark-complete').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const taskId = this.dataset.id;
            const completed = this.checked ? 1 : 0;
            
            fetch('update_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: taskId, completed: completed })
            });
        });
    });
</script>
</body>
</html>
