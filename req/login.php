<?php
	require('db.php');
	session_start();
	$title='Student';
	$whologs='students';
	$message ='Please log in.';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Login - <?php echo $title;?>
		</title>
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<?php
			//form is submitted
		if(isset($_POST['submit']))		{
				//removes backslashes
			$user = stripslashes($_REQUEST['idnum']);
				//escapes special characters in a string
			$user = mysqli_real_escape_string($con,$user);
			$pass = stripslashes($_REQUEST['pass']);
			$pass = mysqli_real_escape_string($con,$pass);
			//check if user is existing
			$query ="SELECT * FROM `$whologs` WHERE s_no='$user' AND s_pass='$pass' ";
			
			$result = mysqli_query($con,$query) OR die(mysqli_error($con));
			$rows = mysqli_num_rows($result);

			if($rows){
					while($row=mysqli_fetch_assoc($result)){
						$_SESSION['fname']=$row["s_fname"];
						$_SESSION['ID']=$row["s_no"];
						$_SESSION['type']='Student';
						$_SESSION['whologs']='student';
							}
				//go to index.php
				//if login go
				header("Location: index.php");
			}else{
				$message='There are errors. <br>Try again.';
			}
		}
		else{
			$user='';
			$pass='';
		}
		?>
			<div class="form">
			<h1>Log In - <?php echo $title;?></h1>
		<form action="" method="post" name="login">
			<input type="text" name="idnum" value="<?php echo htmlspecialchars($user)?>" placeholder="User ID" required />
			<input type="password" name="pass" placeholder="Password" required />
			<input name="submit" type="submit" value="Login" />
		</form>
			<?php echo '<br><p class="form">'.$message.'</p><br>'; ?>
			<p>Not registered yet? <a href='signup.php'>Register Here</a></p>
			<p>(For students only.)</p><br><br>
			
			<p>For Faculty members: <a href='faculty.php'>Log In Here</a></p>
			<p>AD <a href='admin.php'> Here</a></p>
	</div>
			



	</body>
</html>