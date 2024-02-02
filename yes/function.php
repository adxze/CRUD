<?php
    session_start();
    //membuat koneksi ke database
    $conn = mysqli_connect("localhost", "root", "", "attendance_system");

    //menambah user baru
    // if(isset($_POST['register']))
    // {
    //     $firstName = $_POST['firstName'];
    //     $lastName = $_POST['lastName'];
    //     $email = $_POST['email'];
    //     $password = md5($_POST['password']);
    //     $bio = $_POST['bio'];

    //     $addtotabel = mysqli_query($conn, "INSERT INTO user (firstName, lastName, email, password, bio) VALUES ('$firstName', '$lastName', '$email', '$password', '$bio')");
    //     if($addtotabel)
    //     {
    //         header('location: index.php');
    //     }
    //     else
    //     {
    //         echo 'gagal';
    //         header('location: index.php');
    //     }
    // }



    // function - untuk index && login && database 
?>
