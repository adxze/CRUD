
<?php
session_start();
$conn = "";
$stmt = "";

function connectToDB()
{
    $servername = "localhost";
    $username = "root";
    $passowrd = "";
    $dbName = "attendance_system";
    $dataSourceName = "mysql:host=" . $servername . ";dbname=" . $dbName;
    try{
        $conn = new PDO($dataSourceName, $username, $passowrd);
        return $conn;
    }
    catch(PDOException $e){
        echo $e->getMessage();
        return null;
    }
}

function closeConnection()
{
    $conn = null;
    $stmt = null;
}

connectToDB();

function login($data)
{
    $conn = connectToDB();
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->execute([
        $data["email"]
    ]);
    $user = $stmt->fetch();
    if ($user) // * Cek apakah email user ada atau tidak
    {
    //     $validated = password_verify($data["password"], $user["password"]);
    //     if ($validated) // * Cek apakah password user benar atau tidak
    //     {
    //         $_SESSION["login"] = true; //jk berhasil login, sesion tersimpan ke database
    //         if (isset($data["checkbox"])){
    //             setcookie("email", $data["email"], time() + 3600);
    //             // echo "ok!";
    //         }
    //         header('Location: index.php');
    //     }
    //     else{
    //         echo "<script>alert('Email or password is not valid!')</script>";
    //     }
    // }
    // else{
    //     echo "<script>alert('Email or password is not valid!')</script>";
    // }
    // closeConnection();

    $hashed_input_password = md5($data["password"]);

    if ($hashed_input_password == $user["password"]) // * Cek apakah password user benar atau tidak
    {
        $_SESSION["login"] = true; //jk berhasil login, sesion tersimpan ke database
        if (isset($data["checkbox"])){
            setcookie("email", $data["email"], time() + 3600);
            // echo "ok!";
        }
        header('Location: index.php');
        exit;
    }
        else{
            echo "<script>alert('Email or password is not valid!')</script>";
        }
    }
    else{
        echo "<script>alert('Email or password is not valid!')</script>";
    }
}




    // database untuk login admin 

?>


<!-- // function register($data)
// {
//     $conn = connectToDB();
//     $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
//     $stmt->execute([
//         $data["firstname"],
//         $data["lastname"],
//         $data["email"],
//         password_hash($data["password"], PASSWORD_DEFAULT)
//     ]);
//     closeConnection();
// }


// function getAllFoods()
// {
//     $conn = connectToDB();
//     $stmt = $conn->query("SELECT foods.id, foods.food_name, foods.price, foods.description, categories.category_name FROM foods INNER JOIN categories ON foods.category_id = categories.id");
//     $foods = [];
//     while($food = $stmt->fetch(PDO::FETCH_ASSOC)){
//         array_push($foods, $food);
//     }
//     return $foods;
//     closeConnection();
// }

// function getFoodById($data)
// {
//     $conn = connectToDB();
//     $stmt = $conn->prepare("SELECT * FROM foods WHERE id = ?");
//     $stmt->execute([
//         $data["id"]
//     ]);
//     $food = $stmt->fetch();
//     return $food;
//     closeConnection();
// }

// function createFood($data)
// {
//     $conn = connectToDB();
//     $stmt = $conn->prepare("INSERT INTO foods (category_id, food_name, price, description) VALUES (?, ?, ?, ?)");
//     $stmt->execute([
//         $data["category"],
//         $data["name"],
//         $data["price"],
//         $data["description"],
//     ]);
//     closeConnection();
// }


// function updateFood($data)
// {
//     $conn = connectToDB();
//     $stmt = $conn->prepare("UPDATE foods SET category_id = ?, food_name = ?, price = ?, description = ? WHERE id = ?");
//     $stmt->execute([
//         $data["category"],
//         $data["name"],
//         $data["price"],
//         $data["description"],
//         $data["id"],
//     ]);
//     closeConnection();
// }

// function deleteFood($data)
// {
//     $conn = connectToDB();
//     $stmt = $conn->prepare("DELETE FROM foods WHERE id = ?");
//     $stmt->execute([
//         $data["id"]
//     ]);
//     closeConnection();
// } -->