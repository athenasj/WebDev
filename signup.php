<?php
require("db.php");
$message="";
session_start();
if(isset($_SESSION['ID'])){
    header('Location:profile.php');
}



if(isset($_POST['login']))     {
            $message="HERE1";
                //removes backslashes
            $user = stripslashes($_REQUEST['username']);
                //escapes special characters in a string
            $user = mysqli_real_escape_string($con,$user);
            $pass = stripslashes($_REQUEST['password']);
            $pass = mysqli_real_escape_string($con,$pass);
            //check if user is existing
            $query ="SELECT * FROM user WHERE u_name='$user' AND u_pass='$pass' ";
            
            $result = mysqli_query($con,$query) OR die(mysqli_error($con));
            $rows = mysqli_num_rows($result);

            if($rows){
                $message="LOGGED IN";                
                
                    while($row=mysqli_fetch_assoc($result)){
                        $_SESSION['name']=$row["u_name"];
                        $_SESSION['ID']=$row["u_id"];
                        echo  $_SESSION['name'];
                        echo $_SESSION['ID'];
                            }
                //go to index.php
                //if login go
                        
                header("Location: index.php");
            }else{
                echo "<script type='text/javascript'>alert('ERROR: Your Username and Password did not match!');</script>";
            }
        }
$user="";
$pass1="";
$pass2="";
$email="";


        //when signing up
if(isset($_POST['signup']))     {
                //removes backslashes
            $user = stripslashes($_REQUEST['username']);
                //escapes special characters in a string
            $user = mysqli_real_escape_string($con,$user);
            $pass1 = stripslashes($_REQUEST['pass1']);
            $pass1 = mysqli_real_escape_string($con,$pass1);
            $pass2 = stripslashes($_REQUEST['pass2']);
            $pass2 = mysqli_real_escape_string($con,$pass2);
            $email = stripslashes($_REQUEST['email']);
            $email = mysqli_real_escape_string($con,$email);
            //check if user is existing

            if($pass1===$pass2){
            $query = "INSERT INTO user (";
            $query .= "u_name, u_pass, u_email";
            $query .= ") VALUES (";
            $query .= " '{$user}', '{$pass1}', '{$email}'";
            $query .= ")";
            
            $result = mysqli_query($con,$query) OR die(mysqli_error($con));
            $result = mysqli_query($con, "SELECT * FROM user WHERE u_name='$user'") OR die(mysqli_error($con));
            

            
            $message="LOGGED IN";                
                
                while($row=mysqli_fetch_assoc($result)){
                        $_SESSION['name']=$row["u_name"];
                        $_SESSION['ID']=$row["u_id"];
                        }
                //go to index.php
                //if login go
                
                header("Location: index.php");
            
        }  else{
                echo "<script type='text/javascript'>alert('ERROR: Make sure that your password are the same.');</script>";
                //$_POST['submit']=null;
            }
        }      






        ?>




<html>
<head>
    <title>SnapShop - Sign Up</title>

    <!-- R E S P O N S I V E  X  B O O T S T R A P -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- R E F E R E N C E  X  F O N T S -->
    <link rel="stylesheet" type="text/css" href="stylesignup.css">

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
                    <li><a href="index.php">Home</a></li>
                    <li><a data-toggle="modal" data-target="#myModal" href="#">Log In</a></li>
                    <!--<li><a href="storage.php">Storage</a></li>-
                    <!--<li><a href="req\logout.php">Logout</a></li>-->
                </ul>
            </div>
        </div>
    </nav>
    <div class="container signup-form-box">
        <div class="row">
            <div class="col-md-6 hidden-xs hidden-sm">
                <img src="images/beside.png">
            </div>
            <div class="col-md-6">
               <h1>Sign up here</h1>
                <form class="form-horizontal" method="POST">
                    <div class="form-group">
                        <div class="col-sm-8">
                            <input type="text" class="form-control no-border" id="profile_name_1" name="username" placeholder="Username" value="<?php echo $user; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8">
                            <input type="password" class="form-control no-border" id="profile_pwd_1" name="pass1" placeholder="Password" value="<?php echo $pass1; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8">
                            <input type="password" class="form-control no-border" id="photo_pwdr_1" name="pass2" placeholder="Repeat Password" value="<?php echo $pass2; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8">
                            <input type="email" class="form-control no-border" id="profile_email_1" name="email" placeholder="E-mail" value="<?php echo $email; ?>" required>
                        </div>
                    </div>
                    
                    <p class="tpbutton btn-toolbar text-center pull-right">
                        <input class="btn navbar-btn btn-primary" name="signup" type="submit" value="Sign Up">
                        <input class="btn navbar-btn btn-secondary" name="reset" type="reset" value="Reset">
                    </p>

                </form>
            </div>
        </div>
    </div>
    <!-- Modal for Login -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content for Login-->
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form-horizontal" method="POST">
                      <button type="button" class="close" data-dismiss="modal" style="margin-right:10px">&times;</button>
                       <h4>Login</h4>
                        <div class="input-group col-sm-9" style="margin-bottom: 15px">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="login-username" type="text" class="form-control" name="username" value="" placeholder="Username">
                        </div>

                        <div class="input-group col-sm-9" style="margin-bottom: 25px">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="login-password" type="password" class="form-control" name="password" value="" placeholder="Password">          
                        </div>
                            <button type="submit" name="login" value="login" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <div class="container-fluid footer"> <!--FOOTER START -->
           <div class="row">
               <div class="col-sm-4 footer-left hidden-xs">
                   <p>Founded in March 2017</p>
                   <p>Credits to Sir Canlas</p>
               </div>
               <div class="col-sm-4 footer-mid">
                    <center><p>SnapShop</p></center> 
                    <div class="go-top"></div><!-- RETURN TO TOP-->
               </div>
               <div class="col-sm-3 footer-ryt hidden-xs">
                   <p>Creators of SnapShop</p>
                   <p>San Jose, Athena | Tanya, Mary Grace</p>
               </div>
           </div>
        </div> <!--FOOTER END -->
        
        <!-- J A V A  S C R I P T-->
        <script>
            $(function(){
              //Scroll event
              $(window).scroll(function(){
                var scrolled = $(window).scrollTop();
                if (scrolled > 50) $('.go-top').fadeIn('slow');
                if (scrolled < 50) $('.go-top').fadeOut('slow');
              });

              //Click event
              $('.go-top').click(function () {
                $("html, body").animate({ scrollTop: "0" },50);
              });

            });
        </script>
</body>

</html>