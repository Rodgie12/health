<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Client</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Search Clients</h2>

        <form method="GET" class="form-card">
            <div class="form-group">
                <input type="text" name="query" placeholder="Enter client name or email..." required>
            </div>
            <button type="submit">Search</button>
        </form>

        <?php
        if (isset($_GET['query'])) {
            $query = $conn->real_escape_string($_GET['query']);
            $results = $conn->query("SELECT * FROM clients WHERE name LIKE '%$query%' OR email LIKE '%$query%'");

            if ($results->num_rows > 0) {
                echo "<div class='table-container'>";
                echo "<table class='styled-table'>";
                echo "<thead><tr><th>Full Name</th><th>Email</th><th>Contact</th><th>Age</th><th>Gender</th><th>Profile</th></tr></thead>";
                echo "<tbody>";

                while ($row = $results->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['contact']}</td>
                        <td>{$row['age']}</td>
                        <td>{$row['gender']}</td>
                        <td><a class='view-btn' href='view_client.php?id={$row['id']}'>View</a></td>
                    </tr>";
                }

                echo "</tbody></table>";
                echo "</div>";
            } else {
                echo "<p class='error-msg'>❌ No clients found matching '$query'.</p>";
            }
        }
        ?>
    </div>

    <a class="back-btn" href="../index.php">← Back to Home</a>
</body>
</html>
