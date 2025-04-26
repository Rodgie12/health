<?php
include '../includes/db.php';

// Set the response type to JSON
header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $client_id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM clients WHERE id = $client_id");

    if ($result->num_rows > 0) {
        $client = $result->fetch_assoc();
        
        echo json_encode([
            'status' => 'success',
            'data' => [
                'id' => $client['id'],
                'name' => $client['name'],
                'email' => $client['email'],
                'contact' => $client['contact'],
                'age' => $client['age'],
                'gender' => $client['gender'],
                'photo' => $client['photo']
            ]
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Client not found'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No client ID provided'
    ]);
}
?>
