<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Clients</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Registered Clients</h2>

        <div class="table-container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Profile</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $clients = $conn->query("SELECT * FROM clients");
                    if ($clients->num_rows > 0) {
                        while ($row = $clients->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['contact']}</td>
                                <td>{$row['age']}</td>
                                <td>{$row['gender']}</td>
                                <td><a class='view-btn' href='view_client.php?id={$row['id']}'>View</a></td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='error-msg'>❌ No clients registered yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

    <a class="back-btn" href="../index.php">← Back to Home</a>
</body>
</html>
