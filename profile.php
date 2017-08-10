<?php
require("db.php");
session_start();

        if(isset($_GET['id'])){
            $ID=$_GET['id'];
                if(!isset($_SESSION['ID'])){
                    
                    $acct=$_GET['id'];  //when someone else wants to visit profile
                    if(!isset($_GET['id'])){
                        header('Location:signup.php');
                    }
                    $ID=$acct;
                }
        }
        else if(!isset($_SESSION['ID'])){
            header('Location:signup.php');

        }
        else{
                    
                    $ID=$_SESSION['ID'];   

                }
if(isset($_SESSION['name'])&&$_SESSION['name']=='admin'){
    header('Location:home.php');
}
//FOR PROFILE PICTURE CHANGE LATER
$sql = "SELECT * FROM photo WHERE p_user= '$ID' AND p_album='propic'"; //DO: CREATE AN ALBUM FOR PROFILE PICTURE
            $sth = mysqli_query($con,$sql);
            
            $result=mysqli_fetch_assoc($sth);
            $image_data=$result['p_photo'];
/* END FOR PROFILE PIC */

//FOR UPLOAD OF FILE
// Check if image file is a actual image or fake image
if(isset($_POST["imageup"])) {


if(!empty($_POST["album"]))
    {
    
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
   
    $image=$_FILES["fileToUpload"]["tmp_name"];
    $image1=$_FILES["fileToUpload"]["name"];
    $imageSize=$_FILES["fileToUpload"]["size"];
    $imageAlbum=$_POST["album"];
    $min=40;
    $max=110;
    
    $namep=$_POST["namep"];
    $desc = stripslashes($_REQUEST['desc']);
                //escapes special characters in a string
    $desc = mysqli_real_escape_string($con,$desc);
    



    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".<br>";
        $uploadOk = 1;
    } else {
       // echo "File is not an image.";
        $uploadOk = 0;

    }

if (file_exists($target_file)) {
    //echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
/*    
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}*/

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
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                $result =   mysqli_query($con, "INSERT INTO photo (p_user, p_photo, p_size, p_album, p_type, p_name, p_desc, p_min, p_max) 
                                          VALUES ('$ID', '$image1', '$imageSize', '$imageAlbum', '$imageFileType', '$namep', '$desc', '$min', '$max');")OR die(mysqli_error($con));
                    if($result){

                        echo "<script type='text/javascript'>alert('Photo uploaded!');</script>";
                        header("Refresh:0");

                    }

                } else {
                    echo "<script type='text/javascript'>alert('Sorry there was an error uploading your file.');</script>";
                }
        }
        }
        else{
            echo "<script type='text/javascript'>alert('Please select or create an album first!');</script>";
        }
        }

?>

<html>

<head>

    <!-- R E S P O N S I V E  X  B O O T S T R A P -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- R E F E R E N C E  X  F O N T S -->
    <link rel="stylesheet" type="text/css" href="styleprofile.css">
    
    <link rel="stylesheet" type="text/css" href="http://csshake.surge.sh/csshake.min.css">
    
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <title>
        Profile
    </title>
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
                    
                    <!--<li><a href="#">Storage</a></li>-->
                    
                    <?php
                    if(isset($_GET['id'])&&(isset($_SESSION['ID']))){
                        echo '<li><a href="profile.php">Profile</a></li>';
                        echo '<li><a href="album.php">Album</a></li>';
                        echo '<li><a href="logout.php">Logout</a></li>';
                    }
                    else if(isset($_SESSION['ID'])){
                        echo '<li><a href="profile.php">Profile</a></li>';
                        echo '<li><a href="album.php">Album</a></li>';
                        echo '<li><a href="logout.php">Logout</a></li>';
                    }
                    else{
                        echo '<li><a data-toggle="modal" data-target="#myModal" href="#">Login</a></li>
                        <li><a href="signup.php">Signup</a></li>';

                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container-fluid profile">
        <div class="container" id="profile-info-box">
        
    <?php
    $select = mysqli_query($con, "SELECT * FROM profpic WHERE u_user='$ID'");
        if(mysqli_num_rows($select) > 0){
                    while($row = mysqli_fetch_assoc($select)){
                            $pic = $row["u_photo"];
                            $val=1;
                                }
                            }
                    else{
                            $val=0;
        }
    ?>    







        <img src="<?php 
        if($val)
        {echo 'uploads/propic/'.$pic; }
        else{
            echo'images/default-dp.jpg';
        }
        ?>" id="profile_pic_1"width="150px" height="150px" class="img-circle">
        


        <h2 id="profile_name_1">
                            <?php
                            

                                            $result = mysqli_query($con, "SELECT * FROM user WHERE u_id='$ID'") OR die(mysqli_error($con));
                                            while($row= mysqli_fetch_array($result))
                                                {
                                                        $username=$row['u_name'];
                                                        $fname=$row['u_fname'];
                                                        $lname=$row['u_lname'];
                                                }
                                                if($fname==null)
                                                    {echo $username;}
                                                    else{
                                                        echo $fname." ".$lname;

                                                    }
                            ?>
        </h2>
        <p id="profile_info_1">
                                                <?php
                                            $result = mysqli_query($con, "SELECT u_bio FROM user WHERE u_id='$ID'") OR die(mysqli_error($con));
                                            while($row= mysqli_fetch_array($result))
                                                {
                                                    echo $row['u_bio'];
                                                }
                                            ?>
        </p>

        <p id="profile_forte_1">
                                                <?php
                                            $result = mysqli_query($con, "SELECT * FROM user WHERE u_id='$ID'") OR die(mysqli_error($con));
                                            while($row= mysqli_fetch_array($result))
                                                    {
                                                        echo $row['u_forte']."<br>";
                                                        echo "E-mail: ".$row['u_email'];
                                                        $fb=$row['u_smedia1'];
                                                        $insta=$row['u_smedia1'];
                                                    }
                                            ?>
        </p>

        <p>
        <?php
            if($fb !="")
            {
                echo '| <span><a href="#">Facebook </a></span>';

            }
            if($insta!=""){
                echo '| <span><a href="#">Instagram  </a></span>|';

            }
        ?>


        





        </p>
        
        <?php
        if(!isset($_GET['id'])){
                echo '<a data-toggle="modal" data-target="#itemModal" class = "btn navbar-btn btn-third" >Upload New Photo</a>';
                echo   '<a class = "btn navbar-btn btn-secondary" href = "edit-profile.php">Edit Profile/ Account</a>';
               
                echo '<a class = "btn navbar-btn btn-third" href = "album.php" target = "">Create New Album</a>';
                //href="uptry.php"

            }
        else if(isset($_GET['id'])&&isset($_SESSION['ID'])){
                            echo '<a class = "btn navbar-btn btn-secondary" href="profile.php">My Profile</a>';
        }
        else{
                    echo '<a class = "btn navbar-btn btn-secondary" href="signup.php">Signup</a>';}
        ?>


    </div>
    </div>

    <div class="container profile-images-box">
        <h3>Images</h3>
        
        <div class="item-box">

            <?php
                  
                     $result = mysqli_query($con, "SELECT * FROM photo WHERE p_user='$ID'") OR die(mysqli_error($con));
                                            while($row= mysqli_fetch_assoc($result))
                                                {
                                                    echo '<div class="item">';
                                                    if(!isset($_GET['id'])){
                                                    echo '<a data-toggle="modal" data-target="#itemView" href=""><img class="item-img" src="uploads/'.$row['p_photo'].'"/></a>';      
                                                    }else{
                                                    echo '<a href="purchase.php?image='.$row['p_id'].'"><img class="item-img" src="uploads/'.$row['p_photo'].'"/></a>';      
                                                    }

                                                    echo '</div>';
                                                }
                                                if(mysqli_num_rows($result)<=0){
                                                    echo '<p><center>No images uploaded yet.</center></p>';
                                                }
           ?>
           <script type="text/javascript">
                         $('.item-img').click(function() {
                            var src =$(this).attr('src');

                            $('.item-modal').attr('src', src);
                         });
            </script>
            
            
        </div>
    </div>


<!-- Modal for upload item-->
   <div class="modal fade" id="itemModal" role="dialog">
    <div class="modal-dialog item-dialog">
    
      <!-- Modal content upload item-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
           <div class="row modal-row">
            <div class="col-sm-8 upload-colm">
                <img src="images/items/product-2.jpg" id="blah" class="uploadpic-modal">
            </div>
            <div class="col-sm-4 upload-form">
               <h4>Upload Image</h4>
               <p class="note">You must have an existing album to upload this image.<span><a href="album.php" target="_blank"> No Album yet?</a></span></p>
                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="up_maxprice_1" placeholder="Photo Name" name="namep" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                     <div class="col-sm-12">
                     <textarea class="form-control" rows="3" id="up_desc_1" placeholder="Short desciption about photo" name="desc" required></textarea>
                        
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                         <label for="sel1">Select album: </label>
                          <select name="album" class="form-control">
                            <?php
                            $select = mysqli_query($con, "SELECT * FROM album WHERE a_user='$ID'");
                                        if(mysqli_num_rows($select) > 0){
                                            while($row = mysqli_fetch_assoc($select)){
                                                $palbum = $row["p_album"];
                                                echo '<option value="'.$palbum.'"">'.$palbum.'</option>';
                                                }
                            }
                                        else{
                                            echo '<option value="">NO ALBUM</option>';
                                        }
                            ?>
                          </select>
                    
                    <p class="note">Note: Prices depends on size. Maximum value is for the largest size available, minimum value is for the smallest size</p>
                    
                    <p class="tpbutton btn-toolbar text-center pull-right" >
                        <input type="file" name="fileToUpload" onchange="readURL(this);" required>

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

                        <input type="submit" name="imageup" class="btn navbar-btn btn-fourth" href="#" target="">
                    </p>
                </form>
                </div>
            </div>
          </div>
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
               <center><p>SnapShop <a class="fb-xfbml-parse-ignore hidden-lg hidden-md hidden-sm" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fsnap-shop.000webhostapp.com%2Findex.php%2F&amp;src=sdkpreparse"><img src="images/fb.png" width="30px"></a></p></center>
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

            <!-- -->
        </script>

<!-- Modal for upload item-->

<!--MODAL PER PICTURE-->
    <div class="modal fade" id="itemView" role="dialog">
    <div class="modal-dialog item-dialog">
    
      <!-- Modal content for each item-->
      <div class="modal-content">
        <div class="modal-body">
          <img src="" class="item-modal" style="text-align:center">
           
      </div>
      
    </div>
  </div>
  <!--MODAL PER PICTURE-->



</body>

</html>