<?php
//aku nge declare ini
$conn = mysqli_connect("localhost", "root", "", "attendance_system");
$id = $_POST['id'];
$sql = "DELETE FROM user WHERE id = '$id'";
    // delete.php
$result = mysqli_query($conn, $sql);
if (!$result) {
    $_SESSION['error'] = "Failed to delete user: " . mysqli_error($conn);
    header('Location: ../index.php');
    exit;
}
else
{
    header('Location: ../index.php');
    exit;
}

// index.php
if (isset($_SESSION['error'])) {
    echo "<p class='error'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']);
}
?>