<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Client</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Register New Client</h2>
        <form method="POST" enctype="multipart/form-data" class="form-card">
            <div class="form-group">
                <input name="name" type="text" placeholder="Name" required>
            </div>

            <div class="form-row">
                <div class="form-group half">
                    <input name="email" type="email" placeholder="Email" required>
                </div>
                <div class="form-group half">
                    <input name="contact" type="text" placeholder="Contact" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group half">
                    <input name="age" type="number" placeholder="Age" required>
                </div>
                <div class="form-group half">
                    <select name="gender" required>
                        <option value="">-- Gender --</option>
                        <option>Male</option>
                        <option>Female</option>
                        <option>Other</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Upload Photo:</label>
                <input type="file" name="photo" accept="image/*" required>
            </div>

            <button type="submit">Register Client</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $conn->real_escape_string($_POST['name']);
            $email = $conn->real_escape_string($_POST['email']);
            $contact = $conn->real_escape_string($_POST['contact']);
            $age = intval($_POST['age']);
            $gender = $conn->real_escape_string($_POST['gender']);

            // Check if email already exists
            $check = $conn->query("SELECT * FROM clients WHERE email = '$email'");
            if ($check->num_rows > 0) {
                echo "<p class='error-msg'>❌ A client with this email already exists.</p>";
            } else {
                $target_dir = "../uploads/";
                if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

                $photo_name = basename($_FILES["photo"]["name"]);
                $target_file = $target_dir . time() . "_" . $photo_name;

                if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                    $photo_url = $conn->real_escape_string($target_file);

                    $sql = "INSERT INTO clients (name, email, contact, age, gender, photo)
                            VALUES ('$name', '$email', '$contact', $age, '$gender', '$photo_url')";

                    if ($conn->query($sql)) {
                        echo "<script>
                            document.getElementById('successModal').style.display = 'block';
                        </script>";
                    } else {
                        echo "<p class='error-msg'>❌ Error: " . $conn->error . "</p>";
                    }
                } else {
                    echo "<p class='error-msg'>❌ Failed to upload photo.</p>";
                }
            }
        }
        ?>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <h3>✅ Client Registered Successfully!</h3>
           
        </div>
    </div>

    <a class="back-btn" href="../index.php">← Back to Home</a>

    <script>
        function closeModal() {
            document.getElementById('successModal').style.display = 'none';
            window.location.href = 'register_client.php';
        }
    </script>
</body>
</html>
