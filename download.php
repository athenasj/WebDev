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
				header("Content-Disposition: attachment; filename=\"" . basename($imgName).basename($ext) . "\""); 
				header("Expires: 0"); 
				header("Cache-Control: no-cache, must-revalidate"); 
				header("Pragma: no-cache"); 
				readfile('thumb_'.$basename); 
				unlink('thumb_'.$basename);
				imagedestroy($image_p); //free some memory
				
							

						
		}
?>


<html>
<header>
	<title>Receipt</title>

</header>
<body>
<p>Receipt</p>
<form method="post">
<input type="submit" name="download" value="Save File">
</form>

<img src="<?php echo $filename;?>">


</body>
</html>