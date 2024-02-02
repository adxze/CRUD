<?php


// echo "ID: $id";
// echo "Query: $sql";
// echo "Result: $newID";



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


if ($_SERVER['REQUEST_METHOD'] == 'GET' ){

    if (!isset($_GET['id'])){
        header ("location: /yes/index.php");
        exit;
    }

    $id = $_GET['id'];

    $id = $connection->real_escape_string($id);
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
else if ($_SERVER['REQUEST_METHOD'] == 'POST'){


    $id = $connection->real_escape_string($_POST['id']);
    $firstName = $connection->real_escape_string($_POST['firstName']);
    $lastName = $connection->real_escape_string($_POST['lastName']);
    $email = $connection->real_escape_string($_POST['email']);
    $bio = $connection->real_escape_string($_POST['bio']);
    $images = $connection->real_escape_string($_POST['images']);


    if (isset($_POST['submit'])) {
        do {
            if (empty($firstName) || empty($lastName) || empty($email)) {
                $errorMessage = "All fields are required";
                break;
            }

            // Pengecekan apakah email baru sama dengan email lama (pada akun yang sama)
            $sql = "SELECT * FROM user WHERE email = '$email' AND id = '$id'";
            $result = $connection->query($sql);

            if ($result && $result->num_rows === 0) {
                // Email baru tidak sama dengan email lama, lanjutkan pengecekan lainnya
                $sql = "SELECT * FROM user WHERE email = '$email' AND id != '$id'";
                $result = $connection->query($sql);

                if ($result && $result->num_rows > 0) {
                    $errorMessage = "Email already exists in another account";
                    break;
                }
            }

            $sql = "SELECT images FROM user WHERE id = '$id'";
            $result = $connection->query($sql);
            $row = $result->fetch_assoc();
            $oldImagePath = $row['images'];

            if(isset($_FILES["images"]) && $_FILES["images"]["error"] == 0){
                $fileExtension = pathinfo($_FILES["images"]["name"], PATHINFO_EXTENSION);
                $filename = uniqid('', true) . '.' . $fileExtension;
                $filetype = $_FILES["images"]["type"];
                $filesize = $_FILES["images"]["size"];

                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                if(!in_array($fileExtension, $allowedExtensions)) {
                    $errorMessage = "Please select a valid file format.";
                    break;
                }

                $maxsize = 5 * 1024 * 1024;
                if($filesize > $maxsize) {
                    $errorMessage = "File size is larger than the allowed limit.";
                    break;
                }

                $destinationDirectory = "../photofile";

                if(file_exists($destinationDirectory . '/' . $filename)){
                    $errorMessage = $filename . " already exists.";
                    break;
                } else{
                    // Delete the old image file
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }

                    move_uploaded_file($_FILES["images"]["tmp_name"], $destinationDirectory . '/' . $filename);
                    $images = "/yes/photofile/". $filename; 
                }
            } else{
                $images = $oldImagePath;
            }


    

            $sql = "UPDATE user SET firstName = '$firstName', lastName = '$lastName', email = '$email', bio = '$bio', images = '$images' WHERE id = '$id'";
            $result = $connection->query($sql);
    
            if (!$result) {
                $errorMessage = "Invalid query:" . $connection->error;
                break;
            }
    
            $successMessage = "Client updated successfully";
    
            header("Location: /yes/index.php");
            exit;
        } while (false);
    }
    
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

    <script>
    function previewImage(event) {
        var input = event.target;
        var reader = new FileReader();

        reader.onload = function(){
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
            output.style.display = 'block'; // Show the image element

            var previewLabel = document.getElementById('previewLabel');
            previewLabel.style.display = 'block'; // Show the preview label
        };

        if(input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>

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

    <form method="post" enctype="multipart/form-data">
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
                <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">bio</label>
            <div class="col-sm-6">
                <textarea class="form-control" name="bio" rows="5"><?php echo $bio; ?></textarea>
            </div>
        </div>
        
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label" id="previewLabel">Preview</label>
            <div class="col-sm-6">
                <img id="imagePreview" src="<?php echo $images; ?>" alt="Image Preview" style="max-width: 200px;">
            </div>
        </div>


        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Images</label>
            <div class="col-sm-6">
                <input type="file" class="form-control" name="images" id="imageInput" onchange="previewImage(event)">
                <small class="form-text text-muted">Allowed file types: JPG,JPEG, PNG</small>
            </div>
        </div>
        
        <br>
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
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="col-sm-3 d-grid">
                <a class="btn btn-outline-primary" href="/yes/index.php" role="button">cancel</a>
            </div>
        </div>

    </form>

    </div>
</body>
</html>