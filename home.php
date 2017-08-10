<?php
require("db.php");
session_start();
$message="";
if(!isset($_SESSION['ID'])){
    header('Location:admin.php');
}
if($_SESSION['name']!='admin'){
    header('Location:admin.php');
}
//find out number of users
$query="SELECT * FROM user";
$result = mysqli_query($con, $query) OR die(mysqli_error($con));
$numRes = mysqli_num_rows($result);//num of users

$query="SELECT * FROM photo";
$result = mysqli_query($con, $query) OR die(mysqli_error($con));
$numPhoto = mysqli_num_rows($result);//num of photo

$query="SELECT * FROM album";
$result = mysqli_query($con, $query) OR die(mysqli_error($con));
$numAlbum = mysqli_num_rows($result);//num of albums

$numOfPages=ceil($numRes/5); //number of pages

if(!isset($_GET['page'])){
    $page=1;
}else{
    $page=$_GET['page'];
}

        if(isset($_POST['addus'])){
            $user = stripslashes($_REQUEST['username']);
                //escapes special characters in a string
            $user = mysqli_real_escape_string($con,$user);
            $pass = stripslashes($_REQUEST['pass']);
            $pass = mysqli_real_escape_string($con,$pass);
            $email = stripslashes($_REQUEST['email']);
            $email = mysqli_real_escape_string($con,$email);

            $query = "INSERT INTO user (";
            $query .= "u_name, u_pass, u_email";
            $query .= ") VALUES (";
            $query .= " '{$user}', '{$pass}', '{$email}'";
            $query .= ")";
            
            $result = mysqli_query($con,$query) OR die(mysqli_error($con));
            $result = mysqli_query($con, "SELECT * FROM user WHERE u_name='$user'") OR die(mysqli_error($con));

            if($result){
                echo "<script type='text/javascript'>alert('User ".$user." has been added!');</script>";
            }
        }





?>


<html>

<head>
    <title>Edit Page for Admin</title>

    <!-- R E S P O N S I V E  X  B O O T S T R A P -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- R E F E R E N C E  X  F O N T S -->
    <link rel="stylesheet" type="text/css" href="style-edit-admin.css">

    <link rel="stylesheet" type="text/css" href="http://csshake.surge.sh/csshake.min.css">

    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand shake-slow" href="#"><img src="images/logo.png" width="40px"></a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#segment-pl">Profile List</a></li>
                    <li><a href="#segment-add">Add User</a></li>
                    <li><a href="#segment-prog">Progress</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container top-header">
        <h1>Admin Page</h1>
        <p>Howdy Admin! This is the page where you could manage user profiles</p>
        <a href="index.php" class="btn btn-fourth">Visit Landing Page</a>
    </div>

    <div class="container profile-list" id="segment-pl">
        <h2>Profile List</h2>
        <form action="" method="post" name="listdown">
        <div class="list-p">
        <!--SAMPLE
            <li><a data-toggle="modal" data-target="#adminModal">Profile 1</a></li>
                -->
            <?php

            $pageResult=($page-1)*5;
            $query="SELECT * FROM user LIMIT ". $pageResult.", 5";
            $result= mysqli_query($con,$query) OR die(mysqli_error($con));
            while($row= mysqli_fetch_assoc($result))
            {   echo "<input type='radio' name='num' value='".$row['u_id']."' required>";
                echo '<a href="adminmanage.php?id='.$row['u_id'].'"> '.$row['u_fname']." '".$row['u_name']."' ".$row['u_lname']."</a><br><br><br>";
            }

            if (isset($_POST['num'])){
            $id=$_POST['num'];
            
            $query = "DELETE FROM user WHERE u_id='$id'";
            $result1=mysqli_query($con,$query) OR die(mysqli_error($con));

            if($result1){
                echo "<script type='text/javascript'>alert('You have deleted user ".$id.".');</script>";
            }

                }
            ?>
            </div>
            <input type="submit" value="Delete User" class="btn btn-third btn-add" onclick="return confirm('Are you sure?')"/>
        </form>
        

        <ul class="pagination">
            <?php
            for($page=1; $page<=$numOfPages; $page++){
                echo '<li><a href="home.php?page='.$page.'">'.$page.'</a></li>';
            }
           ?>
            <!--SAMPLE
            <li class="active"><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>-->
        </ul>
    </div>
    
    <div class="container new-acct" id="segment-add">
       <h2>Add New Account</h2>
       
       <form class="form-horizontal" method="post">
                    <div class="form-group">
                        <div class="col-sm-8">
                            <input type="text" class="form-control no-border" id="profile_name_1" name="username" placeholder="Username" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8">
                            <input type="text" class="form-control no-border" id="profile_pwd_1" name="pass" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8">
                            <input type="email" class="form-control no-border" id="profile_email_1" name="email" placeholder="Email" required>
                        </div>
                    </div>
                    <p class="text-center">
                        <input type="submit" name="addus" value="Add User" class="btn btn-third btn-add">
                    </p>

                </form>
        
    </div>
    <?php
            $query="SELECT * FROM sold WHERE s_price>0";
            $result = mysqli_query($con, $query) OR die(mysqli_error($con));
            $soldImg = mysqli_num_rows($result);//num of albums

            $query="SELECT * FROM sold WHERE s_price>0";
            $result= mysqli_query($con,$query) OR die(mysqli_error($con));
            $total=0;
            while($row= mysqli_fetch_assoc($result)){
                $total+=$row['s_price'];
            }





    ?>
    <div class="container progress" id="segment-prog">
        <h2>Progress</h2>
        <p>Number of current users:<span class="ans"><?php echo " ".$numRes?></span></p>
        <p>Number of photos:<span class="ans"><?php echo " ".$numPhoto?></span></p>
        <p>Number of albums:<span class="ans"><?php echo " ".$numAlbum?></span></p><br>
        <p>Number of purchased pictures:<span class="ans"> <?php echo " ".$soldImg?></span></p>
        <p>Total amount gathered:<span class="ans"> Php <?php echo " ".$total?></span></p>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="adminModal" role="dialog">
        <div class="modal-dialog admin-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button><br />
                    <div class="row">
                    <div class="col-sm-2">
                        <center><img src="images/logo.png" width="80px"></center>
                    </div>
                    <div class="col-sm-10">
                        <h3>Manage Profile</h3>
                        <input type="button" class="btn btn-alert" value="Delete Account">
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post">
                        <div class="row">
                            <div class="col-sm-6">
                                <h4>Edit User Profile</h4>
                                <p class="form-desc-p">Edit contents of the profile of this user</p>

                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control no-border" id="profile_name_1" placeholder="User's Current Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <textarea class="form-control no-border" rows="3" id="profile_bio_1" placeholder="User's Current Desciption"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control no-border" id="photo_forte_1" placeholder="User's Current Forte">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control no-border" id="profile_1_link_1" placeholder="User's Current Social Media 1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control no-border" id="profile_1_link_2" placeholder="User's Current Social Media 2">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <h4>Edit User Account</h4>
                                <p class="form-desc-p">Edit account of this user</p>
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control no-border" id="user_1" placeholder="User's Current Username">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control no-border" id="pwd_1" placeholder="User's Current Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control no-border" id="email_1" placeholder="User's Current email">
                                    </div>
                                </div>
                                
                              </div>
                                <p class="tpbutton btn-toolbar text-center pull-right">
                                   <input type="submit" class="btn btn-primary">
                                   <input type="reset" class="btn btn-secondary">
                                </p>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>



    
</body>

</html>