<?php
//ESTABLISH CONNECTION
require('db.php');

session_start();

//for auth purposes
if(!isset($_SESSION['ID'])){
    header("Location: signup.php");
    exit();
}
//for easier access
$id=$_SESSION['ID'];

//GET P R E V I O U S  D A T A
$select = mysqli_query($con, "SELECT * FROM user WHERE u_id='$id'");
if(mysqli_num_rows($select) > 0){
                    while($row = mysqli_fetch_assoc($select)){
                            $fname = $row["u_fname"];
                            $lname = $row["u_lname"];
                            $bio= $row["u_bio"];
                            $forte = $row["u_forte"];
                            $soc1 = $row["u_smedia1"];
                            $soc2 = $row["u_smedia2"];
                            $username = $row["u_name"];
                            $email = $row["u_email"];
                                }
                            }

$select = mysqli_query($con, "SELECT * FROM profpic WHERE u_user='$id'");
if(mysqli_num_rows($select) > 0){
                    while($row = mysqli_fetch_assoc($select)){
                            $pic = $row["u_photo"];
                            $val=1;
                                }
                            }
else{
    $val=0;
}





if(isset($_POST['submit'])){
            //pass data
                {
                if($_FILES["fileToUpload"]["name"]!=null){

                $target_dir = "uploads/propic/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
               
                $image=$_FILES["fileToUpload"]["tmp_name"];
                $image1=$_FILES["fileToUpload"]["name"];
                $imageSize=$_FILES["fileToUpload"]["size"];
                 
                if($check !== false) {
                    //echo "File is an image - " . $check["mime"] . ".<br>";
                    $uploadOk = 1;
                } else {
                   // echo "File is not an image.";
                    $uploadOk = 0;
                }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" && $imageFileType != "JPG" 
            && $imageFileType != "PNG" && $imageFileType != "JPEG" && $imageFileType != "GIF") {
                echo $imageFileType."<br>";
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "<script type='text/javascript'>alert('Sorry. Your file was not uploaded.');</script>";
                // if everything is ok, try to upload file
                    } else {
                        if($val)//there is prev prof pic
                        {
                            $query = "DELETE FROM profpic WHERE u_user='$id'";
                            $result1=mysqli_query($con,$query) OR die(mysqli_error($con));

                            if($result1){
                                //DELETED PREVIOUS PICTURE
                                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                            //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                                        $result = mysqli_query($con, "INSERT INTO profpic (u_user, u_photo) VALUES ('$id', '$image1');")OR die(mysqli_error($con));
                                        if($result){
                                                        $fname = $_POST["fname"];
                                                        $lname = $_POST["lname"];
                                                        $bio = stripslashes($_REQUEST['bio']);
                                                            //escapes special characters in a string
                                                        $bio = mysqli_real_escape_string($con,$bio);
                                                        $forte = $_POST["forte"];
                                                        $soc1 = $_POST["soc1"];
                                                        $soc2 = $_POST["soc2"];

                                                        $username = $_POST["uname"];
                                                        $pass = $_POST["pass"];
                                                        $email = $_POST["email"];
                                                        

                                                        $query ="UPDATE `user` SET ";
                                                        $query .="u_lname ='{$lname}', ";
                                                        $query .="u_fname ='{$fname}', ";
                                                        $query .="u_name ='{$username}', ";
                                                        $query .="u_email ='{$email}', ";
                                                        $query .="u_bio ='{$bio}', ";
                                                        $query .="u_forte ='{$forte}', "; //change
                                                        $query .="u_smedia1 ='{$soc1}', ";
                                                        $query .="u_smedia2 ='{$soc2}' ";
                                                        $query .="WHERE u_id ='{$id}' AND u_pass ='{$pass}'";
                                                        

                                                        $result = mysqli_query($con,$query)OR die(mysqli_error($con));
                                                        
                                                        //HOWWWWWWWWWWWWWWWW
                                                        if($result && mysqli_affected_rows($con)>0){
                                                                
                                                            echo "<script>alert('Profile updated!');</script>";
                                                            $page = $_SERVER['PHP_SELF'];
                                                            $sec = "0";
                                                            header("Refresh: $sec; url=$page");
                                                            } else {
                                                            echo "<script>alert('Update failed!');</script>";
                                                            }

                                }

                            } else {
                                echo "<script type='text/javascript'>alert('Sorry there was an error uploading your file.');</script>";


                            }
                            }
                            else{
                                "<script type='text/javascript'>alert('Cant delete file.');</script>";
                            }
                        }
                        else{
                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                            //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                            $result =   mysqli_query($con, "INSERT INTO profpic (u_user, u_photo) 
                                                      VALUES ('$id', '$image1');")OR die(mysqli_error($con));
                                if($result){
                                                $fname = $_POST["fname"];
                                                $lname = $_POST["lname"];
                                                $bio = stripslashes($_REQUEST['bio']);
                                                    //escapes special characters in a string
                                                $bio = mysqli_real_escape_string($con,$bio);
                                                $forte = $_POST["forte"];
                                                $soc1 = $_POST["soc1"];
                                                $soc2 = $_POST["soc2"];

                                                $username = $_POST["uname"];
                                                $pass = $_POST["pass"];
                                                $email = $_POST["email"];
                                                

                                                $query ="UPDATE `user` SET ";
                                                $query .="u_lname ='{$lname}', ";
                                                $query .="u_fname ='{$fname}', ";
                                                $query .="u_name ='{$username}', ";
                                                $query .="u_email ='{$email}', ";
                                                $query .="u_bio ='{$bio}', ";
                                                $query .="u_forte ='{$forte}', "; //change
                                                $query .="u_smedia1 ='{$soc1}', ";
                                                $query .="u_smedia2 ='{$soc2}' ";
                                                $query .="WHERE u_id ='{$id}' AND u_pass ='{$pass}'";
                                                

                                                $result = mysqli_query($con,$query)OR die(mysqli_error($con));
                                                
                                                //HOWWWWWWWWWWWWWWWW
                                                if($result && mysqli_affected_rows($con)>0){
                                                        
                                                    echo "<script>alert('Profile updated!');</script>";
                                                    $page = $_SERVER['PHP_SELF'];
                                                    $sec = "0";
                                                    header("Refresh: $sec; url=$page");
                                                    } else {
                                                    echo "<script>alert('Update failed!');</script>";
                                                    }

                                }

                            } else {
                                echo "<script type='text/javascript'>alert('Sorry there was an error uploading your file. Make sure you have the correct password.');</script>";


                            }
                        }

                    }
                    }
					else{
						$fname = $_POST["fname"];
                                                $lname = $_POST["lname"];
                                                $bio = stripslashes($_REQUEST['bio']);
                                                    //escapes special characters in a string
                                                $bio = mysqli_real_escape_string($con,$bio);
                                                $forte = $_POST["forte"];
                                                $soc1 = $_POST["soc1"];
                                                $soc2 = $_POST["soc2"];

                                                $username = $_POST["uname"];
                                                $pass = $_POST["pass"];
                                                $email = $_POST["email"];
                                                

                                                $query ="UPDATE `user` SET ";
                                                $query .="u_lname ='{$lname}', ";
                                                $query .="u_fname ='{$fname}', ";
                                                $query .="u_name ='{$username}', ";
                                                $query .="u_email ='{$email}', ";
                                                $query .="u_bio ='{$bio}', ";
                                                $query .="u_forte ='{$forte}', "; 
                                                $query .="u_smedia1 ='{$soc1}', ";
                                                $query .="u_smedia2 ='{$soc2}' ";
                                                $query .="WHERE u_id ='{$id}' AND u_pass ='{$pass}'";
                                                

                                                $result = mysqli_query($con,$query)OR die(mysqli_error($con));
                                                
                                                //HOWWWWWWWWWWWWWWWW
                                                if($result && mysqli_affected_rows($con)>0){
                                                        
                                                    echo "<script>alert('Profile updated!');</script>";
                                                    $page = $_SERVER['PHP_SELF'];
                                                    $sec = "0";
                                                    header("Refresh: $sec; url=$page");
                                                    } else {
                                                    echo "<script>alert('Update failed! Enter the correct password.');</script>";
                                                    }
					}
						
					
					}


            }




?>

<html>
    <head>
    <title>Edit Profile</title>
    <!-- R E S P O N S I V E  X  B O O T S T R A P -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- R E F E R E N C E  X  F O N T S -->
    <link rel="stylesheet" type="text/css" href="style-edit-profile.css">
    
    <link rel="stylesheet" type="text/css" href="http://csshake.surge.sh/csshake.min.css">   
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
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="album.php">Albums</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
      
       <div class="container profile-edit-form" enctype="multipart/form-data">
           <h1>Edit <?php echo htmlspecialchars($username)?>'s Profile</h1>
           <p class="form-desc-p">You can edit your profile information in this form</p>
           <form class="form-horizontal" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="text" class="form-control no-border" id="profile_name_1" name="fname" value="<?php echo htmlspecialchars($fname)?>" placeholder="Your First Name">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="text" class="form-control no-border" id="profile_name_1" name="lname" value="<?php echo htmlspecialchars($lname)?>" placeholder="Your Last Name">
                </div>
            </div>
            <div class="form-group">
             <div class="col-sm-10">
                    <textarea class="form-control no-border" rows="5" id="profile_bio_1" name="bio" placeholder="Say something about yourself"> <?php echo htmlspecialchars($bio)?> </textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="text" class="form-control no-border" id="photo_forte_1" name="forte" value="<?php echo htmlspecialchars($forte)?>"  placeholder="What kind of pictures do you take?">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="text" class="form-control no-border" id="profile_1_link_1" name="soc1" value="<?php echo htmlspecialchars($soc1)?>"  placeholder="One of your social media accounts">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="text" class="form-control no-border" id="profile_1_link_2" name="soc2" value="<?php echo htmlspecialchars($soc2)?>"  placeholder="Another one of your social media accounts">
                </div>
            </div>

        <h1 id="account-h1">Edit Account</h1>
        <p class="form-desc-p">You can edit your account information in this form</p>
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="text" class="form-control no-border" name="uname" id="user_1" value="<?php echo htmlspecialchars($username)?>"  placeholder="Your Username" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="password" class="form-control no-border" id="pwd_1"  name="pass" placeholder="Your Password" required>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="email" class="form-control no-border" id="email_1" name="email" value="<?php echo htmlspecialchars($email)?>" placeholder="Your E-mail" required>
                </div>
            </div>

            <!-- UPLOAD !!! -->
                <div class="col-sm-6">
                <?php
                if(!$val){
                    echo '<center><img src="images/default-dp.jpg" id="blah" class="img-circle" width="150px" height="150px"></center>';
                }else{
                    echo '<center><img src="uploads/propic/'.$pic.'" id="blah" class="img-circle" width="150px" height="150px"></center>';
                }

                ?>
                    



                </div>
                <div class="col-sm-6">
                    <p>Choose your profile picture.</p>
                     <input type="file" name="fileToUpload" onchange="readURL(this);">

                                <script type="text/javascript">
                                    function readURL(input) {
                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();

                                            reader.onload = function (e) {
                                                $('#blah').attr('src', e.target.result);
                                            }

                                            reader.readAsDataURL(input.files[0]);
                                        }
                                    }
                                </script>
                </div>
            </div>
            <!-- UPLOAD !!! -->

            <p class = "tpbutton btn-toolbar text-center pull-right">
             <input class = "btn navbar-btn btn-primary" type="submit" name="submit" value="Submit">
             <input class = "btn navbar-btn btn-secondary" type="reset" name="reset" value="Reset">
            </p>
            
        </form>
       </div>
     
    </body>
</html>