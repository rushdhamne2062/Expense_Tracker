<?php
// session_start();
include 'condb.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Expence Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
	.container{
		width: 500px;
		height: 400px;
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
	
		<h2 id="headingName">Sign In</h2>
		<form method="post" id="regis_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<div class="div1">
		    	<label class="form-label1">Office No:</label>
		    	<input type="number" class="form-control" id="_officeno" placeholder="Enter Office No" name="office_No">
		  	</div>
		  	<div class="div1">
    			<label  class="form-label2">Password:</label>
   				<input type="password" class="form-control" id="pass" placeholder="Enter Password" name="_Pass">
  			</div>
  			<button type="submit" class="btn btn-primary" name="submit">Submit</button><br><a href="ExpenceRegister.php" id="anchor">or Sign Up</a>
		</form>	
</div>
</center>
</body>
</html>
<?php

$officeNo=isset($_POST['office_No'])?$_POST['office_No']:null;
$password=isset($_POST['_Pass'])?$_POST['_Pass']:null;
$decryptpass=md5($password);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($officeNo)) {
    	echo "<script>alert('Office No is required!')</script>";
  	}elseif(empty($password)) {
    	echo "<script>alert('Password is required!')</script>";
  	}else{
  		if(isset($_POST['submit'])){
	

	$query1="SELECT `OfficeNo`, `Password` FROM `registertask2` WHERE OfficeNo='$officeNo' OR Password='$decryptpass'";

	$result1=mysqli_query($con,$query1);
	$num=mysqli_num_rows($result1);
		if($num > 0){

		while ($row = mysqli_fetch_array($result1)) {
			
			$_SESSION['officeNumber'] = $row['OfficeNo'];
	        $_SESSION['pass'] = $row['Password'];
	    }
	}
	// $officeNumber=isset($_SESSION['officeNumber'])?$_SESSION['officeNumber']:null;
	// $pass=isset($_SESSION['pass'])?$_SESSION['pass']:null;
	// if ($officeNo == $officeNumber && $decryptpass == $pass) {
    //     echo '<script type="text/javascript">alert("Login Successful!");
    //     window.location="ExpenceTracker.php";
    //     </script>';

       
    // }else{
    //     echo '<script type="text/javascript">alert("Login Fail!");
    //     window.location="ExpenceLogin.php"</script>';
	// }

  	}
  }
}
if(isset($_SESSION['officeNumber'])?$_SESSION['officeNumber']:null OR isset($_SESSION['pass'])?$_SESSION['pass']:null){
	echo '<script type="text/javascript">alert("Login Successful!");
        window.location="ExpenceTracker.php";
        </script>';
}

?>