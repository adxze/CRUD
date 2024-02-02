<?php


echo "ID: $id";
echo "Query: $sql";
echo "Result: $newID";



ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$database = "attendance_system";




$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$id = "";
$firstName = "";
$lastName = "";
$email = "";
$bio = "";  
$image = "";


$errorMessage = "";
$successMessage = "";


if ($_SERVER['REQUEST_METHOD'] == 'GET'){

    if (isset($_POST['id'])){
        header ("location: /yes/index.php");
        exit;
    }

    $id = $_GET['id'];

    $id = $connection->real_escape_string($_GET['id']);
    $sql = "SELECT * FROM user WHERE id = '$id'";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if(!$row){
        header ("location: /yes/index.php");
        exit;
    }

    $firstName = $row["firstName"];
    $lastName = $row["lastName"];
    $email = $row["email"];
    $bio = $row["bio"];
    $images = $row["images"];

    


}
else{

    $id = $_POST['id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $bio = $_POST['bio'];
    $images = $_POST['images'];

    do{
        if (empty($firstName) || empty($lastName) || empty($email)){
            $errorMessage = "All fields are required";
            break;
        }

        $sql = "SELECT * FROM user WHERE email = '$email' AND id != $id";
        $result = $connection->query($sql);

        if($result && $result->num_rows > 0){
            $errorMessage = "Email already exists";
            break;
        }

        $sql = "UPDATE user ". "SET firstName = '$firstName', lastName = '$lastName', email = '$email', bio = '$bio', images = $images". "WHERE id = $id";
        $result = $connection->query($sql);


        if(!$result){
            $errorMessage = "Invalid query:" . $connection->error; 
            break;
        }

        $successMessage = "Client updated successfully";

        header("Location: /yes/index.php");
        exit;

    }while(false);
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Edit User </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> 
</head>
<body>
    <div class = "container my-5">

    <h2>New User</h2>

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
            <label class="col-sm-3 col-form-label">email</label>
            <div class="col-sm-6">
                <input type="email" class="form-control" name="phone" value="<?php echo $email; ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">bio</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="bio" value="<?php echo $bio; ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">images</label>
            <div class="col-sm-6">
                <input type="file" class="form-control" name="images" value="<?php echo $images; ?>">
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