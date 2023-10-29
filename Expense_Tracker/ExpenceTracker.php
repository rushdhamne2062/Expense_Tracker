<?php
// session_start();
include 'condb.php';
// print_r(isset($_SESSION['officeNumber'])?$_SESSION['officeNumber']:null);
if(!$_SESSION['officeNumber']){
header("location:ExpenceLogin.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Expence Tracker</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>
<style>
	#Addbtn{
		margin: 15px 0px 0px 0px;
	}
		  .pagination {   
	        display: inline-block;   
	    }   
	    .pagination a {   
	        font-weight:bold;   
	        font-size:18px;   
	        color: black;   
	        float: left;   
	        padding: 8px 16px;   
	        text-decoration: none;
	        border-radius: 20px;   
	    }   
	    .pagination a.active {   
	            background-color: #0d6efd;
	            color: white;   
	    }   
	    .pagination a:hover:not(.active) {   
	        background-color: black;
	        color: white;  
	    }
	    #filterofficeno{
	    	margin-top: 17px;
	    }
	    #table1{
	    	width: 1000px;
	    }
	    #table{
	    	margin-right: 390px;
	    }
	    #table2{
	    	margin-top: 50px;
	    }
	    #logout{
	    	margin: 0px 0px 0px 450px;
	    	position: absolute;
	    }

</style>
<body>
<center>
	<h2 id="Addbtn">Expence Tracker</h2>
	<form method="post" action="logout.php">
	<input type="submit" class="btn btn-primary mt-3" name="logout" id="logout" value="Logout" >
	</form>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="Addbtn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
  <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z"/>
</svg>
  Add
</button>

<form method="post">
	<table id="table">
		<thead>
			<tr>
				<td><label>Starting Date:</label></td>
				<td><label>Ending Date:</label></td>
				<td><label>Office No:</label></td>
			</tr>
		<tr>
	    <td><input type="date" class="form-control mt-3" id="startdate" name="_start_date" value="<?php echo isset($_POST['_start_date'])?$_POST['_start_date']:null;?>"></td>
	    <td><input type="date" class="form-control mt-3" id="enddate" name="_end_date" value="<?php echo isset($_POST['_end_date'])?$_POST['_end_date']:null;?>"></td>
	    <td>
	    	<select class="form-select" name="_officeno" id="filterofficeno">
					<option value="" class="bg-primary" selected><?php echo  isset($_POST['_officeno'])?$_POST['_officeno']:null?></option>
					<option value="29">29</option>
					<option value="26">26</option>
				</select>
			</td>
	    <td><button type="submit" class="btn btn-primary mt-3" name="search" onclick="Filter()" id="search">Search</button></td>
  	</tr>
  </thead>
  </table>
<table class="table table-hover table-bordered" id="table1">

  <thead class="table-dark">
    <tr>
    <th scope="col">Sr No.</th>
    <th scope="col">Office No.</th>
    <th scope="col">Date</th>
    <th scope="col">Quantity</th>
    <th scope="col">Items</th>
    <th scope="col">Rate</th>
    <th scope="col">Total</th>
    </tr>
  </thead>
  <?php
$per_page_record = 4;
	 if (isset($_GET["page"])) {    
	            $page  = $_GET["page"];    
	        }    
	        else {    
	          $page=1;    
	        } 

	$start_from = ($page-1) * $per_page_record;
$start_Date=isset($_POST['_start_date'])?$_POST['_start_date']:null;
$end_Date=isset($_POST['_end_date'])?$_POST['_end_date']:null;
$office_No=isset($_POST['_officeno'])?$_POST['_officeno']:null;


if(isset($_POST['search'])){
	$query ="";
		if($start_Date &&  $end_Date && $office_No){
			$query .="WHERE Office_no='".$office_No."' AND _Date between '".$start_Date."' AND '".$end_Date."' ORDER BY _Date ASC";
		}
		elseif(!$start_Date &&  !$end_Date && !$office_No){
			$query .="";
		}
		elseif(!$start_Date &&  !$end_Date && $office_No) {  
			$query .="WHERE Office_no='".$office_No."'";
		} 
		elseif($start_Date &&  $end_Date && !$office_No) {
			$query .="WHERE _Date between '".$start_Date."' AND '".$end_Date."' ORDER BY _Date ASC";
		}	
		elseif($start_Date && !$end_Date && !$office_No) {
			$query .="WHERE _Date >= '".$start_Date."' ORDER BY _Date ASC";
		}	
		elseif(!$start_Date && $end_Date && !$office_No) {
			$query .="WHERE _Date <= '".$end_Date."' ORDER BY _Date DESC";
		} 
		else{
			return null;
		}

	$selQuery="SELECT * FROM `task2` $query LIMIT $start_from, $per_page_record";
}else{
	$selQuery="SELECT * FROM `task2` LIMIT $start_from, $per_page_record";
}

  $result=mysqli_query($con,$selQuery);
  $num=mysqli_num_rows($result);
  
 while($res=mysqli_fetch_array($result)){
	?>
  <tbody>
<tr>
  <th scope="row"><?php echo $res['id'];?></th><br>
  <td><span><?php echo $res['Office_no'];?></span></td>
  <td><span><?php echo $res['_Date'];?></span></td>
  <td><span><?php echo $res['Quantity'];?></span></td>
  <td><span><?php echo $res['Item'];?></span></td>
  <td><span><?php echo $res['Rate'];?></span></td>
  <td><span><?php echo $res['Total'];?></span></td>
</tr>
</tbody>
<?php
}


?>
<tfoot class="table-dark">
	<?php
	$Query=isset($query)?$query:null;
  $selQuery3="SELECT SUM(Quantity),SUM(Total) FROM `task2` $Query";
  $result4=mysqli_query($con,$selQuery3);
  $num2=mysqli_num_rows($result4);
  while($res1=mysqli_fetch_array($result4)){
 ?>
	<tr>
		<td>Month Total</td>
  		<td></td>
  		<td></td>
  		<td><?php echo $res1['SUM(Quantity)'];?></td>
  		<td></td>
  		<td></td>
  		<td><?php echo $res1['SUM(Total)'];?></td>
	</tr>
	<?php
     }
 ?>
</tfoot>
</table>
</form>
</table>
<div class="pagination">
        <?php
        $query1 = "SELECT COUNT(*) FROM `task2`";     
        $rs_result = mysqli_query($con, $query1);     
        $row = mysqli_fetch_row($rs_result);     
        $total_records = $row[0];

        echo "</br>"; 

        $total_pages = ceil($total_records / $per_page_record);     
        $pagLink = ""; 

         if($page>=2){   
            echo "<a href='ExpenceTracker.php?page=".($page-1)."'>  Prev </a>";   
        }

        for ($i=1; $i<=$total_pages; $i++) {   
          if ($i == $page) {   
              $pagLink .= "<a class = 'active' href='ExpenceTracker.php?page=".$i."'>".$i." </a>";   
          }               
          else  {   
              $pagLink .= "<a href='ExpenceTracker.php?page=".$i."'>".$i." </a>";     
          }   
        };     
        echo $pagLink;

         if($page<$total_pages){   
            echo "<a href='ExpenceTracker.php?page=".($page+1)."'>  Next </a>";   
        }
        ?>
      </div>
</center>





<!-- Modal -->
<div class="modal modal-xl" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title center" id="staticBackdropLabel">Expence</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" class="needs-validation">
      <div class="modal-body">
        <table class="table table-hover table-bordered">
        	<thead>
        		<tr>
        			<th>Office No</th>
        			<th>Date</th>
        			<th>Quantity</th>
        			<th>Items</th>
        			<th>Rate</th>
        			<th>Total</th>
        		</tr>
        	</thead>
        	<tbody>
        		<tr>
        			<td>
		        		<div class="mb-3 mt-3">
					    <select class="form-select" name="_officeno" required>
							  <option selected>Open this select menu</option>
							  <option value="29">29</option>
							  <option value="26">26</option>
							</select>
				  		</div>
			  		</td>
			  		<td>
		        		<div class="mb-3 mt-3">
					    <input type="date" class="form-control" id="date" name="_date" required>
				  		</div>
			  		</td>
			  		<td>
		        		<div class="mb-3 mt-3">
					    <input type="number" class="form-control" id="quantity" placeholder="Enter Quantity" name="_quantity" required>
				  		</div>
			  		</td>
			  		<td>
		        		<div class="mb-3 mt-3">
					    <input type="text" class="form-control" id="item" placeholder="Enter Item" name="_item" required>
				  		</div>
			  		</td>
			  		<td>
		        		<div class="mb-3 mt-3">
					    <input type="number" class="form-control" id="rate" placeholder="Enter Rate per Item" name="_rate" required>
				  		</div>
			  		</td>
			  		<td>
		        		<div class="mb-3 mt-3">
					    <input type="number" class="form-control" id="total" name="_total">
				  		</div>
			  		</td>
			  		<script>
			  				$(function() {
									    $("#quantity, #rate").on("keydown keyup", totalcost);
										function totalcost() {
										$("#total").val(Number($("#quantity").val()) * Number($("#rate").val()));
										}
									});
			  		</script>
			  	</tr>
        	</tbody>
        	
        </table>
      </div>
      <div class="modal-footer">
      	<button type="submit" class="btn btn-primary" data-bs-dismiss="modal" name="submit">Submit</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
<?php

if(isset($_POST['submit'])){
$officeno=isset($_POST['_officeno'])?$_POST['_officeno']:null;
$date=isset($_POST['_date'])?$_POST['_date']:null;
$quantity=isset($_POST['_quantity'])?$_POST['_quantity']:null;
$item=isset($_POST['_item'])?$_POST['_item']:null;
$rate=isset($_POST['_rate'])?$_POST['_rate']:null;
$total=isset($_POST['_total'])?$_POST['_total']:null;

	$Insquery="INSERT INTO `task2`(`Office_no`, `_Date`, `Quantity`, `Item`, `Rate`, `Total`) VALUES ('$officeno','$date','$quantity','$item','$rate','$total')";
	$result3=mysqli_query($con,$Insquery);

	if($result3){
		echo "<script>alert('Data insert Successfully!');
		window.location='ExpenceTracker.php';</script>";
	}else{
		echo "<script>alert('Data insert Unsuccessfully!')</script>";
	}
}
// print_r(isset($_SESSION['officeNumber'])?$_SESSION['officeNumber']:null);
?>
