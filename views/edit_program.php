<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Program</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Program</h2>

        <?php
        if (!isset($_GET['id'])) {
            echo "<p class='error-msg'>❌ No program selected.</p>";
            echo "<a class='back-btn' href='create_program.php'>← Back</a>";
            exit;
        }

        $id = intval($_GET['id']);
        $program = $conn->query("SELECT * FROM programs WHERE id = $id")->fetch_assoc();

        if (!$program) {
            echo "<p class='error-msg'>❌ Program not found.</p>";
            echo "<a class='back-btn' href='create_program.php'>← Back</a>";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newName = trim($conn->real_escape_string($_POST['program_name']));
            // Check for duplicates excluding current one
            $exists = $conn->query("SELECT id FROM programs WHERE name = '$newName' AND id != $id");
            if ($exists->num_rows > 0) {
                echo "<p class='error-msg'>❌ Another program with that name already exists!</p>";
            } else {
                $conn->query("UPDATE programs SET name = '$newName' WHERE id = $id");
                echo "<p class='success-msg'>✅ Program updated successfully!</p>";
                $program['name'] = $newName;
            }
        }
        ?>

        <form method="POST" class="form-card">
            <input type="text" name="program_name" value="<?= htmlspecialchars($program['name']) ?>" required>
            <button type="submit">Update Program</button>
        </form>

        <a class="back-btn" href="create_program.php">← Back to Program List</a>
    </div>
</body>
</html>
