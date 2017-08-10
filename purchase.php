<?php
        include('db.php');
        session_start();
        if(!isset($_GET['image'])){
            header('Location:signup.php');
        }
        if(isset($_SESSION['ID'])){
        $id=$_SESSION['ID']; //DONT USE ID FOR THIS PAGE AGAIN    
    }else{
        $id='none';
    }
        
        $itemid=$_GET['image']; //$row['p_photo']
        $result = mysqli_query($con, "SELECT * FROM photo WHERE p_id='$itemid'") OR die(mysqli_error($con));
                        while($row= mysqli_fetch_assoc($result))
                            {
                                $image=$row['p_photo'];
                                $user=$row['p_user'];
                                $imgName=$row['p_name'];
                                $imgDesc=$row['p_desc'];
                                $imgAlbum=$row['p_album'];
                                $imgMin=$row['p_min'];
                                $imgMax=$row['p_max'];
                            }
    $val=0;

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
                                header("Refresh:0");
                            }else{
                                echo "<script type='text/javascript'>alert('ERROR: Your Username and Password did not match!');</script>";
                            }
                        }

                            /*PURCHASE*/
                                    if(isset($_POST['purchase'])){
                                        $cc1=$_POST['cc1'];
                                        $cc2=$_POST['cc2'];
                                        $cc3=$_POST['cc3'];
                                        $cc4=$_POST['cc4'];
                                        $cvv=$_POST['cvv'];
                                        $card=$_POST['card'];
                                        $size=$_POST['size'];
                                        //$itemid is image id
                                        //


                                        $query = "INSERT INTO creditc (";
                                        $query .= "c_cc1, c_cc2, c_cc3, c_cc4, c_cvv, c_user, c_card";
                                        $query .= ") VALUES (";
                                        $query .= " '{$cc1}', '{$cc2}', '{$cc3}',  '{$cc4}',  '{$cvv}',  '{$id}',  '{$card}'";
                                        $query .= ")";
                                        
                                        $result = mysqli_query($con,$query) OR die(mysqli_error($con));
                                        
                                        if($result>0){
                                                    $query = "INSERT INTO sold (";
                                                    $query .= "s_user, s_item, s_size";
                                                    $query .= ") VALUES (";
                                                    $query .= " '{$id}', '{$itemid}', '{$size}'";
                                                    $query .= ")";

                                                    
                                                    $result = mysqli_query($con,$query) OR die(mysqli_error($con));
                                                    
                                                        $_SESSION['imgID']=mysqli_insert_id($con) OR die(mysqli_error($con));
                                                            
                                            header("Location: receipt.php");

                                        }else{
                                            echo "<script type='text/javascript'>alert('Sorry. There was an error with your transaction. Please try again.');</script>";
                                        }                                    
                                                    }
                                    /*PURCHASE*/
                                    



?>




<html>

<head>
    <title>Purchase</title>

    <!-- R E S P O N S I V E  X  B O O T S T R A P -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- R E F E R E N C E  X  F O N T S -->
    <link rel="stylesheet" type="text/css" href="style-purchase.css">

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
                   <?php
                        if(isset($_SESSION['ID'])){
                        echo '<li><a href="profile.php">Profile</a></li>
                                <li><a href="album.php">Album</a></li>
                                <li><a href="logout.php">Logout</a></li>';
                        }
                        else{
                        echo '<li><a data-toggle="modal" data-target="#myModal" href="#">Log In</a></li>
                        <li><a href="signup.php">Signup</a></li>';
                        }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container purchase-box">
        <img src="uploads/<?php echo $image;?>" class="purchase-img">
         <div class="row purchase-row">
            <div class="col-sm-4 purchase-left">

            <?php
                    /*     FOR PROFPIC      */

                        $select = mysqli_query($con, "SELECT * FROM profpic WHERE u_user='$user'");
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
            <center><img src="<?php
            if($val)
                {echo 'uploads/propic/'.$pic; }
                else{
                    echo'images/default-dp.jpg';
                }
            ?>" id="profile_pic_1"width="150px" height="150px" class="img-circle"></center>


            <h6>Photography by:</h6><span class="answerm">
                <?php
                /*     FOR USERNAME      */
                
                $result = mysqli_query($con, "SELECT * FROM user WHERE u_id='$user'") OR die(mysqli_error($con));
                        while($row= mysqli_fetch_assoc($result))
                            {
                                $fname=$row['u_fname'];
                                $lname=$row['u_lname'];
                                $name=$row['u_name'];
                                echo $fname.' ';
                                if($user==$id){
                                    echo '<a href="profile.php" target="_blank">\''.$name.'\' </a>';
                                }else{
                                echo '<a href="profile.php?id='.$user.'"target="_blank">\''.$name.'\' </a>';
                                }
                                echo $lname;
                                
                            }

                ?>




            


            </span>
            <p>Maximum value: <span class="answer" id="max"> P <?php echo $imgMax;?>.00</span></p>
            <p>Minimum value: <span class="answer" id="min"> P <?php echo $imgMin;?>.00</span> </p>
            <p class="note">Note: Price varies on size selected</p>
            <p>Title: <?php echo $imgName;?></p>
                <p>Album: <?php echo $imgAlbum;?></p>
                <p>Description: <?php echo $imgDesc; ?></p>
                <p id="price">Price: Php 40</p>
            </div>
            <div class="col-sm-8 purchase-right">
          
                
            
                       
                       <?php 
                       if($user==$id){
                            echo '<h4>Purchase</h4>
                                <p>This is your photo</p>
                                <a href="album.php" class="btn btn-fourth">Visit Album</a>';
                                

                        }

                       else if(isset($_SESSION['ID'])){
                       echo '<h4>Purchase</h4>
                       <form class="form-horizontal method-post" method="POST">
                       <p>To have this photograph, please fill up this form</p>
                       <div class="form-group col-sm-11">
                                    <label for="sel1">Select size </label>
                                    <select class="form-control" name="size" id="paperSize" onchange="changeFunc()"required>
                                        <option>Wallet Size</option>
                                        <option>3R</option>
                                        <option>4R</option>
                                        <option>Half Letter Size</option>
                                        <option>Full Letter Size</option>
                                    </select>
                        </div>
                        <div class="input-group col-sm-10" style="margin-bottom: 15px">
                        <label class="input-inline">Enter your Card number and CVV</label> <br>
                            <div class="row">
                                <div class="col-sm-3">
                                    <input id="credit-card" title="0-9 only" type="text" class="form-control form-control-inline" maxlength="4" name="cc1" pattern="[0-9]{4}"placeholder="XXXX" required>
                                </div>
                                <div class="col-sm-3">
                                    <input id="credit-card"  title="0-9 only" type="text" class="form-control form-control-inline" maxlength="4" name="cc2" pattern="[0-9]{4}"placeholder="XXXX" required>
                                </div>
                                <div class="col-sm-3">
                                    <input id="credit-card" title="0-9 only" type="text" class="form-control form-control-inline" maxlength="4" name="cc3" pattern="[0-9]{4}"placeholder="XXXX" required>
                                </div>
                                <div class="col-sm-3">
                                    <input id="credit-card" title="0-9 only" type="text" class="form-control form-control-inline" maxlength="4" name="cc4" pattern="[0-9]{4}"placeholder="XXXX" required><br>
                                </div>
                                <div class="col-sm-3">
                                    <input id="credit-card" title="0-9 only" type="text" class="form-control form-control-inline" maxlength="3" name="cvv" pattern="[0-9]{3}"placeholder="XXX" required>
                                </div>
                            </div>
                        <label>Select your Card </label> <br>
                            <input type="radio" name="card" value="JCB"> <img src="images/jcb.png" width="55px" class="cc"/>
                            <input type="radio" name="card" value="VISA"> <img src="images/visa.png" width="55px" class="cc"/>
                            <input type="radio" name="card" value="Master Card"> <img src="images/mc.png" width="55px" class="cc"/> <br>
                        </div>


                            <input type="submit" class="btn btn-fourth" name="purchase" onclick="return confirm_send()" value="Purchase">
                            </form>';
                        }
                        
                        else{
                            echo '<h4>Purchase</h4>
                            <p>You must be logged in in order to purchase the photo.</p>
                                <a href="signup.php" class="btn btn-fourth">Sign Up</a>
                                <a data-toggle="modal" data-target="#myModal" class="btn btn-fourth">Log In</a>';
                        }
                    /*  END FOR PURCHASE  */
                         ?>

                         <!-- SCRIPT FOR PRICE CHANGE ALSO MAKE PHP FOR PRICE -->
                         <script type="text/javascript">


                            function changeFunc () {
                                    var value=0;
                                        var x = document.getElementById("paperSize").value;
                                        if(x=="3R"){
                                            value=50;
                                        } else if(x=="4R"){
                                            value=70;
                                        } else if(x=="Half Letter Size"){
                                            value=90;
                                        } else if(x=="Full Letter Size"){
                                            value=110;
                                        } else{
                                            value=40;
                                        }

                                        document.getElementById("price").innerHTML = "Price: Php " + value;


                                    
                                };
                        function confirm_send() {
                            val=document.getElementById("price").innerHTML;
                        return confirm('The price is ' + val+'. Are you sure you want to purchase the image?');
                        }


                         </script>
                            
                    
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
                            <button type="submit" value="submit" name="submit" class="btn btn-primary">Log In</button>
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