<?php
$conn = mysqli_connect("localhost", "root", "", "attendance_system");
$sql = "SELECT * FROM user WHERE id = 'UD01'";

$result = mysqli_query($conn, $sql);
if (!$result) {
    $_SESSION['error'] = "Failed to view user: " . mysqli_error($conn);
    header('Location: ../index.php');
    exit;
}

// Fetch data
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>User Profile</title>
        <link href="css/styles.css" rel="stylesheet" />
        <!-- Include Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <style>
            body {
                background-color: #343a40;
            }
            .container {
                background-color: white;
                margin-top: 50px;
                padding: 20px;
                border-radius: 10px;
                word-wrap: break-word;
                max-width: 800px;
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <div class="container">
            <h1 class="mt-4">User Profile</h1>
            <table class='table table-striped'>
                <tr><th>First Name</th><td><?php echo $row['firstName']; ?></td></tr>
                <tr><th>Last Name</th><td><?php echo $row['lastName']; ?></td></tr>
                <tr><th>Email</th><td><?php echo $row['email']; ?></td></tr>
                <tr><th>Bio</th><td><?php echo $row['bio']; ?></td></tr>
            </table>
            <a href="../index.php" class="btn btn-primary mt-3">Back to Dashboard</a>
        </div>
    </body>
</html>