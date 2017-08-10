<?php
require("db.php");
$message="log in";
session_start();

            if(isset($_POST['submit']))    {
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
                                        }
                            //go to index.php
                            //if login go
                            header("Location: index.php");
                        }else{
                            echo "<script type='text/javascript'>alert('ERROR: Your Username and Password did not match!');</script>";
                        }
                    }
        
        ?>


<html>
    <head>
     <link rel="shortcut icon" href="images/favicon.ico" />

        <title>Snap Shop</title>
        
        <!-- R E S P O N S I V E  X  B O O T S T R A P -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <!-- R E F E R E N C E  X  F O N T S -->
        <link rel="stylesheet" type="text/css" href="style-index.css">

        <link rel="stylesheet" type="text/css" href="http://csshake.surge.sh/csshake.min.css">
        
        <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    </head>
    <body>

    <!--F A C E B O O K  A P I-->
    <div id="fb-root"></div>
                    <script>(function(d, s, id) {
                      var js, fjs = d.getElementsByTagName(s)[0];
                      if (d.getElementById(id)) return;
                      js = d.createElement(s); js.id = id;
                      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=132520503445218";
                      fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));
                    </script>
    <!--F A C E B O O K  A P I-->


       <div class="container-fluid heads">
        <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand shake-slow" href="#"><img src="images/logo.png" width="40px" style="margin-top:-.5em"></a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php">Home</a></li>
                    <?php
                    
                    if(isset($_SESSION['ID'])){
                    echo '<li><a href="profile.php">Profile</a></li>
                            <li><a href="album.php">Album</a></li>
                            <li><a href="logout.php">Logout</a></li>';
                    }
                    else{
                    echo '<li><a data-toggle="modal" data-target="#myModal" href="#">Log In</a></li>
                    <li><a href="signup.php">Signup</a></li>';}
                    ?>







                </ul>
            </div>
        </div>
    </nav>
        <h1>Snap Shop</h1>
        <p id="caption"> Our website lets you easily share your images around the world, explore others photograph that you could buy.<br /> Life's happier because of captured moments.</p>
        <a class = "btn navbar-btn btn-secondary hidden-xs " href = "signup.php" target = "">Join us and explore</a>
    
        
        <!--FACEBOOK LINK--><br>
        <div class="fb-share-button hidden-xs" data-href="https://snap-shop.000webhostapp.com/" data-layout="button_count" data-size="large" data-mobile-iframe="true">
        <a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fsnap-shop.000webhostapp.com%2Findex.php%2F&amp;src=sdkpreparse">Share</a>
        </div>
        <!--FACEBOOK LINK-->

        </div>


     <div class="container index-images">
        <h3>Images</h3>  
        
        <div class="item-box">
           
                <?php
                   //SHOW ALL PHOTOS IN DATABASE      USE THIS:    ORDER BY p_id DESC
                     $result = mysqli_query($con, "SELECT * FROM photo ORDER BY p_id DESC") OR die(mysqli_error($con));
                        while($row= mysqli_fetch_assoc($result))
                            {
                                echo '<div class="item">';
                                echo '<a href="purchase.php?image='.$row['p_id'].'"  target="_blank"><img class="item-img" src="uploads/'.$row['p_photo'].'"/></a>';                               
                                echo '</div>';
                            }
           ?>
                

        
           
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
                            <button type="submit" value="submit" name="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal for each item-->
   <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content for each item-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<!--MODAL PER PICTURE-->
    <div class="modal fade" id="itemModal" role="dialog">
    <div class="modal-dialog item-dialog">
    
      <!-- Modal content for each item-->
      <div class="modal-content">
        <div class="modal-body">
          <img src="" class="item-modal">
           <div class="row modal-row">
            <div class="col-sm-2 item-mod-pic">
                <img src="images/profile_pic_1.png" id="profile_pic_1"width="80px" height="80px" class="img-circle">
            </div>
            <div class="col-sm-4 item-mod-desc">
                <p id="user">Photograph by: Zhang Yixing</p>
                <p id="maxp">Max Price: 12$</p>
                <p id="minp">Minimum Price: 3$</p>
                <p class="note">Note: Prices depends on size</p>
            </div>
            <div class="col-sm-6 item-mod-cap">
                <p id="desc">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit</p>
                <a type="button" class="btn btn-third" href="purchase.php">Purchase</a>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  <!--MODAL PER PICTURE-->

  <div id="dizzy-gillespie"></div>
  <div id="loader"></div>

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
        </script>

    </body>
</html>