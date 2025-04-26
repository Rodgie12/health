<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Program</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Create a Health Program</h2>
        <form method="POST" class="form-card">
            <input type="text" name="program_name" placeholder="Program Name e.g., TB, Malaria, HIV, etc." required>
            <button type="submit">Create Program</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($conn->real_escape_string($_POST['program_name']));
            $exists = $conn->query("SELECT id FROM programs WHERE name = '$name'");
            if ($exists->num_rows > 0) {
                echo "<p class='error-msg'>❌ Program '$name' already exists!</p>";
            } else {
                if ($conn->query("INSERT INTO programs (name) VALUES ('$name')")) {
                    echo "<p class='success-msg'>✅ Program '$name' created successfully!</p>";
                } else {
                    echo "<p class='error-msg'>❌ Error: " . $conn->error . "</p>";
                }
            }
        }
        ?>

        <div class="programs-section">
            <h3>Available Programs</h3>
            <input type="text" id="searchInput" placeholder="🔍 Search programs..." style="margin-bottom: 20px; padding: 10px; width: 100%; border-radius: 8px; border: 1px solid #ccc; font-size: 1rem;">

            <ul class="program-list" id="programList">
                <?php
                $programs = $conn->query("SELECT p.*, (SELECT COUNT(*) FROM enrollments e WHERE e.program_id = p.id) as client_count FROM programs p ORDER BY name ASC");
                if ($programs->num_rows > 0) {
                    while ($row = $programs->fetch_assoc()) {
                        echo "<li>
                            📋 <strong>{$row['name']}</strong><br>
                            <small>👥 Enrolled: {$row['client_count']}</small><br>
                            <a href='edit_program.php?id={$row['id']}' class='view-btn'>✏️ Edit</a>
                            <a href='delete_program.php?id={$row['id']}' class='view-btn' style='background-color:#dc3545;' onclick=\"return confirm('Are you sure you want to delete this program?')\">🗑️ Delete</a>
                        </li>";
                    }
                } else {
                    echo "<li>No programs found.</li>";
                }
                ?>
            </ul>
        </div>
    </div>

    <a class="back-btn" href="../index.php">← Back to Home</a>

    <script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        const listItems = document.querySelectorAll('#programList li');
        listItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(filter) ? 'block' : 'none';
        });
    });
    </script>
</body>
</html>
