<?php
require('db.php');
session_start();
$userID=$_SESSION['ID'];


if(isset($_POST["albumup"])) {
	$album=$_POST['album'];
	$desc=$_POST['desc'];
$result =   mysqli_query($con, "INSERT INTO album (a_user, p_album, a_desc) 
                                  VALUES ('$userID', '$album', '$desc')")OR die(mysqli_error($con));
        	if($result){

        		echo "well done!";
        	}

    } else {
        //echo "Sorry, there was an error uploading your file.";
    }






// Check if image file is a actual image or fake image
if(isset($_POST["imageup"])) {
	echo $_POST["imageup"];
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
   
    $image=$_FILES["fileToUpload"]["tmp_name"];
    $image1=$_FILES["fileToUpload"]["name"];
    $imageSize=$_FILES["fileToUpload"]["size"];
    $imageAlbum=$_POST["album"];



    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".<br>";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }


// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
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
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        $result =   mysqli_query($con, "INSERT INTO photo (p_user, p_photo, p_size, p_album, p_type) 
                                  VALUES ('$userID', '$image1', '$imageSize', '$imageAlbum', '$imageFileType');")OR die(mysqli_error($con));
        	if($result){

        		echo "well done!";
        	}

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
}
?>











<!DOCTYPE html>
<html>
<body>

<form method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="text" name="album" id="album" placeholder="Album Name">
    <input type="submit" value="Upload Image" name="imageup">
</form>
<br>
<form method="post" >
    Create album
    
    <input type="text" name="album" id="album" placeholder="Album Name">
    <textarea class="form-control" rows="3" id="up_desc_1" placeholder="Short desciption about photo" name="desc" required></textarea>
    <input type="submit" value="Create new album"name="albumup">
</form>
<?php
$sql = "SELECT * FROM photo WHERE p_user = $userID";
$sth = $con->query($sql);
$result=mysqli_fetch_assoc($sth) OR die(mysqli_error($con));

$photo=$result['p_photo'];
echo $photo;
echo '<img src="uploads/'.$result['p_photo'].'"/>';
?>


</body>
</html>