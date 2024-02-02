<?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$db = "attendance_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

$id = "";
$firstName = "";
$lastName = "";
$email = "";
$bio = "";  
 

$errorMessage = "";
$successMessage = "";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the id from the URL
$id = $_POST['id'];

// Fetch the existing data
$sql = "SELECT * FROM user WHERE id='$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $firstName = $row["firstName"];
    $lastName = $row["lastName"];
    $email = $row["email"];
    $bio = $row["bio"];

}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $bio = $_POST["bio"];


    // $target_dir = "uploads/";
    // $target_file = $target_dir . basename($image);
    // move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    $sql = "UPDATE user SET firstName='$firstName', lastName='$lastName', email='$email', bio='$bio' WHERE id='$id'";

    echo "id = $id <br>";
    echo "firstName = $sql <br>";

    if ($conn->query($sql) === TRUE) {
        echo "Records updated successfully";
        header("Location: /yes/index.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> 
</head>
<body>
    <div class = "container my-5">

    <h2>New Clients</h2>

    <?php 

    if (!empty($errorMessage)){
        echo"
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong> $errorMessage </strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        ";
        $errorMessage = "";
    }
    ?>

    <form method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">firstName</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="firstName" value="<?php echo $firstName; ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">lastName</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="lastName" value="<?php echo $lastName; ?>">
            </div>

        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-6">
                <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Bio</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="bio" value="<?php echo $bio; ?>">
            </div>
        </div>
        


        <?php 
        if ( !empty($successMessage)){
            echo"
            <div class = ' row mb-3'> 
                <div class = 'offset-sm-3 col-sm-6'>
                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong> $successMessage </strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                </div>
            </div>

            ";

            $successMessage = "";
        }
        ?>

        <div class="row mb-3">
            <div class="offset-sm-3 col-sm-3 d-grid">
                <button type="submit" class="btn btn-primary">submit</button>
            </div>
            <div class="col-sm-3 d-grid">
                <a class="btn btn-outline-primary" href="/yes/index.php" role="button">cencel</a>
            </div>
        </div>

    </form>

    </div>
</body>
</html>
