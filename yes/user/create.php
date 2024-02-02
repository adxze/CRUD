
<?php 

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "attendance_system";

    function generateNextID($connection) {

        $sql = "SELECT MAX(CAST(SUBSTRING(id, 2) AS UNSIGNED)) AS maxNumericPart FROM user";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $currentMaxNumericPart = $row['maxNumericPart'];
    

        $currentLetter = 'T'; 
        $nextLetter = chr(ord($currentLetter) + 1);
    

        $nextNumericPart = ($currentMaxNumericPart % 999) + 1;

        $newID = $nextLetter . str_pad($nextNumericPart, 3, '0', STR_PAD_LEFT);
    
        return $newID;
    }
    

    function generateRandomPassword($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $password;
    }

    $connection = new mysqli($servername, $username, $password, $database);


if ($connection->connect_error) {   
    die("Connection failed: " . $connection->connect_error);
}



    // $name = "";
    // $email = "";
    // $phone = "";
    // $address = "";

    $firstName = "";
    $lastName = "";
    $email = "";
    $password = ""; // gk tau butuh gak 
    $bio = "";
    $images = "";


    $errorMessage = "";
    $successMessage = "";


    if ($_SERVER['REQUEST_METHOD'] == 'POST'){



        // $Firs = $_POST['name'];
        // $email = $_POST['email'];
        // $phone = $_POST['phone'];
        // $address = $_POST['address'];

        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        // $password = $_POST['password']; // gk tau butuh gak
        $bio = $_POST['bio'];
        // $images = $_POST['images'];


        $generatedPassword = generateRandomPassword();


        $hashedPassword = password_hash($generatedPassword, PASSWORD_DEFAULT);



        do{
            if (empty($firstName) || empty($lastName) || empty($email)){
                $errorMessage = "First last name and email are required";
                break;
            }
            
            $sql = "SELECT * FROM user WHERE email = '$email'";
            $result = $connection->query($sql);

            if ($result && $result->num_rows > 0){
                $errorMessage = "Email already exists";
                break;
            }


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
                    move_uploaded_file($_FILES["images"]["tmp_name"], $destinationDirectory . '/' . $filename);
                    $images = "/yes/photofile/". $filename; 
                }
            } else{
                $images = "";
            }
            
            
            $newID = generateNextID($connection);

            $sql = "INSERT INTO user (id, firstName, lastName, email, password, bio, images )" . "VALUES ('$newID','$firstName', '$lastName', '$email','$hashedPassword', '$bio', '$images')" ;
            $result = $connection -> query($sql);

            

            if (!$result){
                $errorMessage = "Invalid query: $connection->error"; 
                break;
            }

            $firstName = "";
            $lastName = "";
            $email = "";
            $bio = "";
            $images = "";


            $successMessage = "Client added successfully";

            header("Location: /yes/index.php");
            exit;
            
        }while (false);
    

    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Create</title>
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

    <form method="post" action="create.php" enctype="multipart/form-data">
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">First Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="firstName" value="<?php echo $firstName; ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Last Name</label>
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
                <textarea class="form-control" name="bio" rows="5"><?php echo $bio; ?></textarea>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label" id="previewLabel" style="display: none;">Preview</label>
            <div class="col-sm-6">
                <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 200px; display: none;">
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
                <button type="submit" class="btn btn-primary">submit</button>
            </div>
            <div class="col-sm-3 d-grid">
                <a class="btn btn-outline-primary" href="/yes/index.php" role="button">cancel</a>
            </div>
        </div>

    </form>

    </div>
</body>
</html>