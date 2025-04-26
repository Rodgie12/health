<?php
include '../includes/db.php';

// Set the response type to JSON
header('Content-Type: application/json');

// Check if ID is provided
if (isset($_GET['id'])) {
    $client_id = intval($_GET['id']);

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $client = $result->fetch_assoc();

        // Get enrolled programs
        $programs_stmt = $conn->prepare("
            SELECT programs.name 
            FROM enrollments 
            JOIN programs ON enrollments.program_id = programs.id
            WHERE enrollments.client_id = ?
        ");
        $programs_stmt->bind_param("i", $client_id);
        $programs_stmt->execute();
        $programs_result = $programs_stmt->get_result();

        $programs = [];
        while ($row = $programs_result->fetch_assoc()) {
            $programs[] = $row['name'];
        }

        // Return client data + programs
        echo json_encode([
            'status' => 'success',
            'data' => [
                'id' => $client['id'],
                'name' => $client['name'],
                'email' => $client['email'],
                'contact' => $client['contact'],
                'age' => $client['age'],
                'gender' => $client['gender'],
                'photo' => $client['photo'],
                'enrolled_programs' => $programs
            ]
        ], JSON_PRETTY_PRINT);

    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Client not found'
        ], JSON_PRETTY_PRINT);
    }

} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No client ID provided'
    ], JSON_PRETTY_PRINT);
}
?>
