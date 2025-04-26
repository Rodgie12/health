<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Profile</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <?php
        if (isset($_GET['id'])) {
            $client_id = intval($_GET['id']);
            $client = $conn->query("SELECT * FROM clients WHERE id = $client_id")->fetch_assoc();

            if ($client) {
                echo "<h2>{$client['name']}'s Profile</h2>";
                echo "<div class='profile-card'>";
                
                // Display the client photo
                if (!empty($client['photo'])) {
                    echo "<img class='profile-photo' src='{$client['photo']}' alt='Profile Photo'>";
                }

                echo "<p><strong>Email:</strong> {$client['email']}</p>";
                echo "<p><strong>Contact:</strong> {$client['contact']}</p>";
                echo "<p><strong>Age:</strong> {$client['age']}</p>";
                echo "<p><strong>Gender:</strong> {$client['gender']}</p>";
                echo "</div>";

                // Programs the client is enrolled in
                $programs = $conn->query("
                    SELECT programs.name FROM enrollments
                    JOIN programs ON enrollments.program_id = programs.id
                    WHERE enrollments.client_id = $client_id
                ");

                echo "<div class='programs-section'>";
                echo "<h3>Enrolled Programs</h3>";

                if ($programs->num_rows > 0) {
                    echo "<ul class='program-list'>";
                    while ($row = $programs->fetch_assoc()) {
                        echo "<li>✅ {$row['name']}</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>This client is not enrolled in any program yet.</p>";
                }
                echo "</div>";

            } else {
                echo "<p class='error-msg'>❌ Client not found!</p>";
            }
        } else {
            echo "<p class='error-msg'>❌ No client selected!</p>";
        }
        ?>
    </div>

    <a class="back-btn" href="search_client.php">← Back to Search</a>
</body>
</html>
