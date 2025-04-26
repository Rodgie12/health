<?php include '../includes/db.php';

if (!isset($_GET['id'])) {
    header('Location: create_program.php');
    exit;
}

$id = intval($_GET['id']);

// Check if this program has enrolled clients
$enrolled = $conn->query("SELECT COUNT(*) as total FROM enrollments WHERE program_id = $id")->fetch_assoc();

if ($enrolled['total'] > 0) {
    echo "<script>
        alert('❌ Cannot delete a program with enrolled clients.');
        window.location.href = 'create_program.php';
    </script>";
    exit;
}

// Delete program
$conn->query("DELETE FROM programs WHERE id = $id");

echo "<script>
    alert('✅ Program deleted successfully.');
    window.location.href = 'create_program.php';
</script>";
exit;
