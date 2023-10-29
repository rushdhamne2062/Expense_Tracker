<?php
// session_start();
include 'condb.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
	.container{
		width: 500px;
		height: 520px;
		margin-top: 80px;
		position: relative;
	}
	#headingName{
		margin: 30px 0px 0px 180px;
/*		background-color: black;*/
		position: absolute;
	}
	#regis_form{
		position: absolute;
		margin-top: 50px;
	}
	.div1{
		margin: 50px 0px 0px 130px;
	}
	.form-label1{
		margin: 0px 0px 10px -130px;
	}
	.form-label2{
		margin: 0px 0px 10px -130px;
	}
	.form-label3{
		margin: 0px 0px 10px -70px;
	}
	.btn{
		margin: 20px 0px 0px 150px;
	}
	#anchor{
		margin: 0px 0px 0px 150px;
	}
</style>
<body>
<center>
<div class="container  rounded-5 shadow-lg">
	
		<h2 id="headingName">Sign Up</h2>
		<form method="post" id="regis_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<div class="div1">
		    	<label class="form-label1">Office No:</label>
		    	<input type="number" class="form-control" id="_officeno" placeholder="Enter Office No" name="office_No">
		  	</div>
		  	<div class="div1">
    			<label  class="form-label2">Password:</label>
   				<input type="password" class="form-control" id="pass" placeholder="Enter Password" name="_Pass">
  			</div>
			<div class="div1">
    			<label  class="form-label3">Confirm Password:</label>
    			<input type="password" class="form-control" id="confirmpass" placeholder="Enter Confirm Password" name="confirm_Pass">
  			</div>
  			<button type="submit" class="btn btn-primary" name="submit">Submit</button><br><a href="ExpenceLogin.php" id="anchor">OR Sign In</a>
		</form>	
</div>
</center>
</body>
</html>
<?php

$officeno=isset($_POST['office_No'])?$_POST['office_No']:null;
$pass=isset($_POST['_Pass'])?$_POST['_Pass']:null;
$encryptpass=md5($pass);
$confirmpass=isset($_POST['confirm_Pass'])?$_POST['confirm_Pass']:null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($officeno)) {
    	echo "<script>alert('Office No is required!')</script>";
  	}elseif(empty($pass)) {
    	echo "<script>alert('Password is required!')</script>";
  	}elseif(empty($confirmpass)) {
    	echo "<script>alert('Confirm Password is required!')</script>";
  	}elseif($pass!=$confirmpass) {
    	echo "<script>alert('Confirm Password not Match!')</script>";
  	}else{
	  	if(isset($_POST['submit'])){

			$query="INSERT INTO `registertask2`(`OfficeNo`, `Password`) VALUES ('$officeno','$encryptpass')";
			$result2=mysqli_query($con,$query);

			if($result2){
			  		echo "<script>alert('Data insert Successfully!');
			  		window.location='ExpenceLogin.php';</script>";

			  	}else{
			  		echo "<script>alert('Data insert Unsuccessfully!')</script>";
			  	}
			}	
						
  		}  		
}

// if(isset($_SESSION['officeNumber'])?$_SESSION['officeNumber']:null){
// 	header("location:ExpenceTracker.php");
// }					
?>