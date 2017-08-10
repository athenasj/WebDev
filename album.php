<?php
require("db.php");
session_start(); 
		if(!isset($_SESSION['ID'])){
			    header('Location:signup.php');    
		}else{
			    $ID=$_SESSION['ID'];
			    $name=$_SESSION['name'];
			    $sql = "SELECT * FROM user WHERE u_id= '$ID' AND u_name='$name'"; //check whether user or admin
			            $sth = mysqli_query($con,$sql) OR die(mysqli_error($con));
			            $result=mysqli_fetch_assoc($sth);

			    	    if(!$result){
			    	    	header('Location:home.php'); //if not admin then go
			    	    }
			}


/*				FOR NEW ALBUM 					*/
			if(isset($_POST["albumup"])) {
					$album=$_POST['album'];
					
					$desc = stripslashes($_REQUEST['desc']);
                                                            //escapes special characters in a string
                    $desc = mysqli_real_escape_string($con,$desc);

					$sql = "SELECT * FROM album WHERE a_user= '$ID' AND p_album='$album'"; //check whether album has been created
			            $sth = mysqli_query($con,$sql) OR die(mysqli_error($con));
			            $result=mysqli_fetch_assoc($sth);

			    	    if($result>0){
			    	    	echo "<script type='text/javascript'>alert('ERROR!: That album has already been created!');</script>";
			    	    	header("Refresh: 0"); //refresh page;
			    	    }

			   	else{
					$result =   mysqli_query($con, "INSERT INTO album (a_user, p_album, a_desc) 
				                                  VALUES ('$ID', '$album', '$desc')")OR die(mysqli_error($con));
				        	if($result){

				        		echo "<script type='text/javascript'>alert('Your album has been created.');</script>";
				        		
				                header("Refresh: 0"); //refresh page;
				        	}
							else {
				        echo "<script type='text/javascript'>alert('There was an error. Please try again.');</script>";
				    }
				    }
				}
/*		END		FOR NEW ALBUM 					*/
$val=0;

if(isset($_POST['imageup'])){

								if(!empty($_POST["album"])){//HERE
	//HERE 							
									$imageAlbum=$_POST["album"];
									$val=1;
							}else{
									echo "<script type='text/javascript'>alert('Please create an album first!');</script>";
								}
								}else{
									$imageAlbum="Preview Album";
								}



?>








<html>
    <head>
        <title>Album Page</title>
        
        <!-- R E S P O N S I V E  X  B O O T S T R A P -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <!-- R E F E R E N C E  X  F O N T S -->
        <link rel="stylesheet" type="text/css" href="stylealbum.css">

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
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="album.php">Albums</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
     <!--END OF NAV BAR-->  
<!--START OF CREATE ALBUM-->  
    <div class="container create-album">
        <center><h1>Create an Album</h1></center>
        <form class="form-horizontal" method="post">
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="text" class="form-control no-border" name="album" id="album_name_1" placeholder="Album Title" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <textarea class="form-control no-border" name="desc" rows="3" id="album_desc_1" placeholder="Album Description" required></textarea>
                </div>
            </div>
            <center><input type="submit" name="albumup" class="btn btn-secondary"></center>
        </form>
    </div>
       <!--END OF CREATE ALBUM-->  
    <div class="container preview-album">



       <center><h1><?php echo $imageAlbum;?></h1></center>
       <form class="form-horizontal" method="post">
                <div class="form-group col-sm-11">
                                    <label>Select Album </label>
                                        <select name="album" class="form-control">
				                            <?php
				                            $select = mysqli_query($con, "SELECT * FROM album WHERE a_user='$ID'") OR die(mysqli_error($con));
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
                        </div>
               <center><input type="submit" name="imageup" class="btn btn-fourth" href="#" target=""></center>
       </form>

       

       <div class="item-box">
           	<?php
           		/*		START	FOR NEW ALBUM 					*/

				
									if($val==1){

									$imageAlbum=$_POST["album"];

									$result = mysqli_query($con, "SELECT * FROM photo WHERE p_user='$ID' AND p_album='$imageAlbum' ORDER BY p_id DESC" ) OR die(mysqli_error($con));

				                                          
				                                           
				                                while($row= mysqli_fetch_assoc($result))
                                                	{
	                                                    echo '<div class="item">';
	                                                    echo '<a data-toggle="modal" data-target="#itemView" href=""><img class="item-img" src="uploads/'.$row['p_photo'].'"/></a>';      
                                                    	echo '</div>';
                                                	}
				                                    if(mysqli_num_rows($result)<=0){
				                                	echo 'HERE';
                                                    echo '<p><center>No images uploaded yet.</center></p>';
                                                }
								}
							

				/*		END		FOR ALBUM PREVIEW 					*/	
           	?>
	       <!--SCRIPT FOR MODAL-->
	       <script type="text/javascript">
	                         $('.item-img').click(function() {
	                            var src =$(this).attr('src');

	                            $('.item-modal').attr('src', src);
	                         });
	        </script>
	        <!--SCRIPT FOR MODAL-->


            
        </div>
    </div>
        
    <!--MODAL PER PICTURE-->
    <div class="modal fade" id="itemView" role="dialog">
    <div class="modal-dialog item-dialog">
    
      <!-- Modal content for each item-->
      <div class="modal-content">
        <div class="modal-body">
          <img src="" class="item-modal" style="text-align:center">
           <div class="row modal-row">
            
        </div>
      </div>
      
    </div>
  </div>
  <!--MODAL PER PICTURE-->




    </body>
</html>