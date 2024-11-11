<?php
include 'db.php';
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id']) && isset($data['completed'])) {
    $id = $data['id'];
    $completed = $data['completed'];
    
    $stmt = $conn->prepare("UPDATE tasks SET completed = :completed WHERE id = :id");
    $stmt->execute(['completed' => $completed, 'id' => $id]);
    
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
