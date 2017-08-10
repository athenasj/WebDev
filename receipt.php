<?php
		include('db.php');
		session_start();
		/* FOR TESTING
		$photo = 'product-7.jpg';//$photo
		
		$imgName = 'Camera';//$photo
		$ext = '.jpg';
		$item=12;

		*/
		//starttttt
		//VALIDATION FOR USER
		if(isset($_SESSION['imgID']))
		{
			$imageid=$_SESSION['imgID']; //pass imageid
			
			if(isset($_SESSION['ID'])){
				$userID=$_SESSION['ID'];
			}
			else{
				header('Location:signup.php');
			}


			}
	else{
			header('Location:index.php');
		}

		//RETURN IMAGE PRICE
		$query ="SELECT * FROM sold WHERE s_user='$userID' AND s_id='$imageid'";
		$result=mysqli_query($con,$query);
                    while($row=mysqli_fetch_assoc($result)){
                        $size=$row["s_size"];  //paper size                              
                    	$item=$row["s_item"]; //kung ano binili
                  }
        								if($size=="3R"){
                                            $value=50;
                                            $wid=480;
                                            $hei=336;
                                        } else if($size=="4R"){
                                            $value=70;
                                            $wid=576;
                                            $hei=384;
                                        } else if($size=="Half Letter Size"){
                                            $value=90;
                                            $wid=816;
                                            $hei=528;
                                        } else if($size=="Full Letter Size"){
                                            $value=110;
                                            $wid=1056;
                                            $hei=816;
                                        } else{
                                            $value=40;
                                            $wid=384;
                                            $hei=288;
                                        }
                     //UPDATE PRICE
            $query ="UPDATE sold SET ";
            $query .="s_price ='{$value}' ";            
            $query .="WHERE s_user='$userID' AND s_id='$imageid'";
            
            $result=mysqli_query($con,$query) OR die(mysqli_error($con));
        	
        	/*if($result && mysqli_affected_rows($con)>0){
                                                                
        		echo "price updated";
                } else {
                echo "check again";
                }*/

		//endddd


		$query ="SELECT * FROM photo WHERE p_id='$item'";
			$result=mysqli_query($con,$query) OR die(mysqli_error($con));
                    while($row=mysqli_fetch_assoc($result)){
                        $photo=$row["p_photo"];
                        $imgName=$row["p_name"];
                        $ext=".".$row["p_type"];
                  }
		$filename = 'uploads/';                                                    
		$filename .= $photo;
		if(isset($_POST['download'])){
				$psize=$size;			
				$basename = basename($filename);		
			
				// Content type
				header('Content-Type: image/jpeg');

				// Get new dimensions
				list($width, $height) = getimagesize($filename);
				$new_width = $wid;
				$new_height = $hei;

				// Resample
				$image_p = imagecreatetruecolor($new_width, $new_height);
				$image = imagecreatefromjpeg($filename);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

				// Output
				//imagejpeg($image_p, null, 100);
				$img = imagejpeg($image_p, 'thumb_'.$basename, 100);
				$size = filesize($filename); 
				header("Content-Type: application/force-download; name=\"" . basename($filename). "\""); 
				header("Content-Transfer-Encoding: binary"); 
				header("Content-Length:". $size); 
				header("Content-Disposition: attachment; filename=\"" . basename($imgName).' ('.$psize.') '.basename($ext) . "\""); 
				header("Expires: 0"); 
				header("Cache-Control: no-cache, must-revalidate"); 
				header("Pragma: no-cache"); 
				readfile('thumb_'.$basename); 
				unlink('thumb_'.$basename);
				imagedestroy($image_p); //free some memory
				
							

						
		}
?>


<html>
    <head>
    	<title>Receipt</title>
        <!-- R E S P O N S I V E  X  B O O T S T R A P -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <!-- R E F E R E N C E  X  F O N T S -->
        <link rel="stylesheet" type="text/css" href="style-receipt.css">

        <link rel="stylesheet" type="text/css" href="http://csshake.surge.sh/csshake.min.css">
        
        <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    </head>
    <body>
    
    <div class="wrap">
        <nav class="navbar navbar-default navbar-fixed-top">
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
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Profile</a></li>
                    <li><a href="#">Albums</a></li>
                    <li><a href="#">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="main">
        <form class="form-horizontal" method="post">
        <div class="container-fluid receipt-top">
            <div class="container receipt-top-box">
               <div class="row">
                <div class="col-sm-2">
                    <center><img src="images/profile_pic_1.png" class="img-circle" width="100px"></center>
                </div>
                <div class="col-sm-6">
                    <center><h1><span class="receipt-Hi">Hi</span> <span class="receipt-name">
                    <?php
                            

                                            $result = mysqli_query($con, "SELECT * FROM user WHERE u_id='$userID'") OR die(mysqli_error($con));
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
                            !</span></h1></center>
                </div>
                <div class="col-sm-4">
                    <center>
                    
                    <form method="post">
                    <input class="btn btn-fourth" type="submit" name="download" class="btn btn-third" value="Purchase Image/ Download">
                    </form>
                    </center>

                </div>
              </div>
                
            </div>
        </div>
        <div class="container-fluid receipt-bottom">
            <div class="container receipt-bottom-box">
                <div class="row">
            <div class="col-sm-6">
                <center><img src="<?php echo $filename;?>" class="receipt-product"></center>
            </div>
            <div class="col-sm-6">
                <h2>Thanks for ordering!</h2>
                <p>For confirmation, here are the following details you entered:</p>
                <p>Image Title: <span class="answer"> <?php echo $imgName;?></span></p>
                <p>Photograph by: <span class="answer">
                	<?php
                /*     FOR USERNAME      */
                
                $result = mysqli_query($con, "SELECT * FROM user WHERE u_id='$userID'") OR die(mysqli_error($con));
                        while($row= mysqli_fetch_assoc($result))
                            {
                                $fname=$row['u_fname'];
                                $lname=$row['u_lname'];
                                $name=$row['u_name'];
                                echo $fname.' ';                                
                                echo '<a href="profile.php?id='.$userID.'"target="_blank">\''.$name.'\' </a>';                                
                                echo $lname;
                                
                            }

                ?>
                </span></p>
                <p>Size Chosen: <span class="answer"> <?php echo $size;?></span></p><br />
                <p>Total Amount: <span class="answer"> Php <?php echo $value;?>.00</span></p>
                <center>
                <a class="btn btn-fourth" href="index.php">Back to home page</a>
                </center>

            </div>
          </div>
            </div>
        </div>
    </form>
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