<?php
    require 'function.php';

    //session_start();
    if(!isset($_SESSION["login"]) || $_SESSION["login"] !=true ){
    header("location: login.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">Attendance List</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                dashboard
                            </a>
                            <!-- masukin profile nya ke index.php -->
                            <a class="nav-link" href="user/profile.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Profile
                            </a>
                            <a class="nav-link" href="logout.php">
                                <i class="fas fa-sign-out-alt"></i> &nbsp; Logout
                            </a>
                            </div>
                            </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">User List</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Create User Button -->
                                    <a href="user/create.php" class="btn btn-primary" role="button"> 
                                        Create User
                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <!-- Search Form -->
                                    <!-- <form action="search.php" method="get">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="cari" placeholder="Search">
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary" type="submit">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form> -->
                                </div>
                            </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" width="100%" cellspacing="0" id="dataTable"> <!-- (id="dataTable") masukin buat sorting -->
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Photo</th>
                                                <th>Full Name</th>
                                                <th>Email</th>
                                                <th>Aksi</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $ambilsemuadatauser = mysqli_query($conn, "SELECT * FROM user");
                                                $i = 1;
                                                $prevData = null;
                                                while($data=mysqli_fetch_array($ambilsemuadatauser))
                                                {
                                                    if($prevData)
                                                    {
                                                        $nama = $prevData['firstName'] . ' ' . $prevData['lastName'];
                                                        $email = $prevData['email'];
                                                        ?>
                                                    <tr>
                                                        <td><?=$i++;?></td>
                                                        <td>
                                                            <?php
                                                            $imagePath = $prevData['images'];
                                                            if (empty($imagePath) || $imagePath == " ") {
                                                                echo "<em>No Photo</em>";
                                                            } else {
                                                                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath)) {
                                                                    echo '<img src="' . $imagePath . '" width="100px" >';
                                                                } else {
                                                                    echo "<t style='color: red;'>Error</t>";
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?=$nama;?></td>
                                                        <td><?=$email;?></td>
                                                        <td>
                                                        <div class = "btn-group" role="group" arial-label="Basic example">
                                                        <!-- masukin nanti file buat view, edit, delete nya ke index.php -->
                                                        <form action="user/view.php" method="post">
                                                            <input type="hidden" name="id" value="<?=$prevData['id'];?>">
                                                            <input type="submit" class="btn btn-primary mr-2" value="View">
                                                        </form>
                                                        <form action="user/update.php" method="POST">
                                                            <input type="hidden" name="id" value="<?=$prevData['id'];?>">
                                                            <input type="hidden" name="firstName" value="<?=$prevData['firstName'];?>">
                                                            <input type="hidden" name="lastName" value="<?=$prevData['lastName'];?>">
                                                            <input type="hidden" name="email" value="<?=$prevData['email'];?>">
                                                            <input type="hidden" name="bio" value="<?=$prevData['bio'];?>">
                                                            <input type="hidden" name="images" value="<?=$prevData['images'];?>">
                                                            <input type="submit" class="btn btn-warning mr-2" value="edit">
                                                        </form>
                                                        <div class = "btn-group" role="group" arial-label="Basic example">
                                                        <!-- <a href="user/update.php" class="btn btn-warning mr-2" role="button">
                                                            Edit
                                                        </a> -->
                                                        <div class = "btn-group" role="group" arial-label="Basic example">
                                                        <!-- delete button -->
                                                        <form action="user/delete.php" method="post" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                            <input type="hidden" name="id" value="<?=$prevData['id'];?>">
                                                            <input type="submit" class="btn btn-danger mr-2" value="Delete">
                                                        </form>
                                                        
                                                        </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    }
                                                    $prevData = $data;
                                                };
                                            ?>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <footer>
                            <strong>Made by team</strong> : @adzeiii, @raflyadha21, @gracebirgitta
                        </footer>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
     <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">User Baru</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form method="post">
            <div class="modal-body">
                <input type="text" name="firstName" placeholder="First Name" class="form-control" required><br>
                <input type="text" name="lastName" placeholder="Last Name" class="form-control" required><br>
                <input type="text" name="email" placeholder="Email" class="form-control" required><br>
                <input type="text" name="password" placeholder="Password" class="form-control" required><br>
                <input type="text" name="bio" placeholder="Bio" class="form-control" ><br>
                <button type="submit" name="register" class="btn btn-primary">Register</button>
            </div>
        </form>
        
        
      </div>
    </div>
  </div>
</html>
