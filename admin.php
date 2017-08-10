<?php
require("db.php");
session_start();
$message="";
if(isset($_SESSION['ID'])){
    header('Location:profile.php');
}

if(isset($_POST['submit']))    {
            $message="HERE1";
                //removes backslashes
            $adname = stripslashes($_REQUEST['adname']);
                //escapes special characters in a string
            $adname = mysqli_real_escape_string($con,$adname);
            $adpass = stripslashes($_REQUEST['adpass']);
            $adpass = mysqli_real_escape_string($con,$adpass);
            //check if user is existing
            $query ="SELECT * FROM admin WHERE adname='$adname' AND adpass='$adpass' ";
            
            $result = mysqli_query($con,$query) OR die(mysqli_error($con));
            $rows = mysqli_num_rows($result);

            if($rows){
                $message="LOGGED IN";
                
                    while($row=mysqli_fetch_assoc($result)){
                        $_SESSION['name']=$row["adname"];
                        $_SESSION['ID']=$row["id"];
                            }
                //go to index.php
                //if login go
			//H E R E  I S  T H E  H E A D E R                            
                header("Location: home.php");
            }else{
                $message='Wrong information. Kindly fill up again';
            }
        }
?>

<html>
    <head>
        <title>Login - Admin</title>
        
        <!-- R E S P O N S I V E  X  B O O T S T R A P -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <!-- R E F E R E N C E  X  F O N T S -->
        <link rel="stylesheet" type="text/css" href="style-admin.css">

        <link rel="stylesheet" type="text/css" href="http://csshake.surge.sh/csshake.min.css">
        
        <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">       
    </head>
    <body>
            <div class="container signup-form-box">
              <img src="images/logo.png" id="logo">
               <h1>Login - Admin</h1>
               <p>Howdy Admin! Welcome to SnapShop!</p>
               <?php echo '<p>'.$message.'</p>';?>
                <form class="form-horizontal" method="POST">
                    <div class="form-group">
                        <div class="col-sm-8">
                            <input type="text" class="form-control no-border" id="profile_name_1" name="adname" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8">
                            <input type="password" class="form-control no-border" id="profile_pwd_1" name="adpass" placeholder="Password">
                        </div>
                    </div>
                    <p class="tpbutton btn-toolbar text-center pull-right">
                        <input type="submit" class="btn navbar-btn btn-primary" name="submit">
                        <a class="btn navbar-btn btn-secondary" href="index.php">Return to Home</a>
                    </p>

                </form>
            </div>

    </body>
</html>