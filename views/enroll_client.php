<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enroll Client</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Enroll Client in Program</h2>
        <form method="POST" class="form-card">
            <div class="form-group">
                <select name="client_id" required>
                    <option value="">-- Select Client --</option>
                    <?php
                    $clients = $conn->query("SELECT * FROM clients");
                    while ($row = $clients->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Select Program(s):</label>
                <div class="checkbox-group">
                    <?php
                    $programs = $conn->query("SELECT * FROM programs");
                    while ($row = $programs->fetch_assoc()) {
                        echo "
                        <label>
                            <input type='checkbox' name='program_ids[]' value='{$row['id']}'>
                            {$row['name']}
                        </label>";
                    }
                    ?>
                </div>
            </div>

            <button type="submit">Enroll Client</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $client_id = intval($_POST['client_id']);
            $program_ids = $_POST['program_ids'] ?? [];

            if (empty($program_ids)) {
                echo "<p class='error-msg'>❌ Please select at least one program.</p>";
            } else {
                $enrolledCount = 0;
                foreach ($program_ids as $program_id) {
                    $program_id = intval($program_id);

                    // Check if client already enrolled
                    $check = $conn->query("SELECT * FROM enrollments WHERE client_id = $client_id AND program_id = $program_id");
                    if ($check->num_rows === 0) {
                        $conn->query("INSERT INTO enrollments (client_id, program_id) VALUES ($client_id, $program_id)");
                        $enrolledCount++;
                    }
                }

                if ($enrolledCount > 0) {
                    echo "<p class='success-msg'>✅ Client enrolled in $enrolledCount new program(s)!</p>";
                } else {
                    echo "<p class='error-msg'>⚠️ Client is already enrolled in all selected program(s).</p>";
                }
            }
        }
        ?>
    </div>

    <a class="back-btn" href="../index.php">← Back to Home</a>
</body>
</html>
