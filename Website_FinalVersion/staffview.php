<html> 
<head>
	<div class="h1"> 
        <title>Murray Motors</title>
        <link href="staffstyle.css" rel="stylesheet" type="text/css">   
            <div class="row">
                <ul class="main-nav">
					
		<?php
		include ("db.php");
		session_start();
		if (!isset($_SESSION['useremail']))
		{
		echo'		
					<form method = post>
						<input type="email" name="useremail" required placeholder="Enter Email Address">
						<input type="password" name="userpass" required placeholder="Enter Account Password">
						<input type="submit" name="login" value="Login">
					</form>';
					echo "<div class='Register'> ";
					echo '<form method = post><button name="Register">Register</form>';
					echo "</div>";
		}
		else
		{
			$sql = $pdo->prepare("SELECT first_name FROM userlistview WHERE email = :email");
			$sql->execute(array(':email' => $_SESSION['useremail']));
			$row = $sql->fetch(PDO::FETCH_ASSOC);
			$fname = $row['first_name'];
		echo "	<div class='phpgreetingstaff'> ";
			//greeting message
		echo '<p> Hello ' . $fname . '!</p>';
		echo " </div> ";
		
		  
			//logout button
			echo "<div class='phplogout'>";
			echo '<form method = post><button name="logout">Logout</form>';
			echo "</div>";
			
			if (isset($_SESSION['feedbackmessage']) && $_SESSION['feedbackmessage'] != "")
			{
				$message = $_SESSION['feedbackmessage'];
				echo "	<div class='feedbackmessage'>
						<p>$message</p>
						</div> ";
				$_SESSION['feedbackmessage'] = "";
			}
			else
			{
				echo "	<div class='feedbackmessage'>
						<p>Staff View</p>
						</div> ";
			}
		}
		?>
					
                </ul>         
			</div>
		</div>
	<div class="logo">
      <img src="Images/Murraymotors.png">
	</div>

</head>

<div class="Butbar">		
		<form method = "post">
			<ul class="button-group">
			<li><button class="large button" type = "submit" name = "personalview">Personal Info</button></li>
			<br>
			<li><button class="large button" type = "submit" name = "carview">Car Stock</button></li>
			<br>
			<li><button class="large button" type = "submit" name = "leaseview">Leases</button></li>
			<br>
			<li><button class="large button" type = "submit" name = "customerview">Customers</button></li>
			<br>
			<li><button class="large button" type = "submit" name = "supplierview">Suppliers</button></li>
			<br>
			<li><button class="large button" type = "submit" name = "repairview">Repair</button></li>
			<br>
			<li><button class="large button" type = "submit" name = "valetview">Valet</button></li>		
			<br>
			<li><button class="large button" type = "submit" name = "advertview">Advert</button></li>					
		</ul>
		
	</form>
	</div> 
<body> 
<?php 
		ob_start();
		include "db.php"; 
		$useremail = $_SESSION['useremail'];
		$querystring = "SELECT BranchNumber FROM staff WHERE email = '" . $useremail . "'";
		$sql = $pdo->prepare($querystring);
		$sql->execute();
		$row = $sql->fetch(PDO::FETCH_ASSOC);
		$_SESSION['branchno'] = $row['BranchNumber'];
		
		if ($_SESSION['userview'] != "staff")
		{
			header("Location: index.php");
			exit;
		}
		
		if (isset($_SESSION['currview']))
		{
			switch($_SESSION['currview'])
			{
				case "personal":
						staffviewSwitch();
						break;
						
				case "car":
						carviewSwitch();
						break;
						
				case "leases":
						leaseviewSwitch();
						break;
	
				case "customers":
						customerviewSwitch();
						break;

				case "suppliers":
						supplierviewSwitch();
						break;
	
				case "repair":
						repairviewSwitch();
						break;
	
				case "valet":
						valetviewSwitch();
						break;
				
				case "advert":
						advertviewSwitch();
						break;	
			}
		}
		else
		{
			staffviewSwitch();
		}
		if (isset($_POST["personalview"]))
		{
			$_SESSION['currview'] = "personal";
			
			header("Refresh:0");
			exit;
		}
		else if (isset($_POST["staffview"]))
		{
			$_SESSION['currview'] = "staff";
			
			header("Refresh:0");
			exit;
		}
		else if (isset($_POST["carview"]))
		{
			$_SESSION['currview'] = "car";
			
			header("Refresh:0");
			exit;
		}
		else if (isset($_POST["leaseview"]))
		{
			$_SESSION['currview'] = "leases";
			
			header("Refresh:0");
			exit;
		}
		else if (isset($_POST["customerview"]))
		{
			$_SESSION['currview'] = "customers";
			
			header("Refresh:0");
			exit;
		}
		else if (isset($_POST["supplierview"]))
		{
			$_SESSION['currview'] = "suppliers";
			
			header("Refresh:0");
			exit;
		}
		else if (isset($_POST["valetview"]))
		{
			$_SESSION['currview'] = "valet";
			
			header("Refresh:0");
			exit;
		}
		else if (isset($_POST["repairview"]))
		{
			$_SESSION['currview'] = "repair";
			
			header("Refresh:0");
			exit;
		}
		else if (isset($_POST["advertview"]))
		{
			$_SESSION['currview'] = "advert";
			
			header("Refresh:0");
			exit;
		}
		else if (isset($_POST["logout"]))
		{
			session_unset();
			header("Location: index.php");
			exit;
		}
		if (isset($_POST['personaledit']))
		{
			if (!isset($_SESSION['editprofile']) || $_SESSION['editprofile'] == False)
			{
				$_SESSION['editprofile'] = True;
			}
			else
			{
				$_SESSION['editprofile'] = False;
			}
			header("Refresh:0");
			exit;
		}
		else if (isset($_POST["editpersonal"]))
		{
			$sql = $pdo->prepare("SELECT email FROM userlistview WHERE email = :email");
				$sql->execute(array(':email' => $_POST['email']));
				$row = $sql->fetch(PDO::FETCH_ASSOC);
			
				if($row['email'] == $_POST['email'] && $row['email'] != $_SESSION['useremail'])
				{
					$_SESSION['feedbackmessage'] = "Email is already in use";
				}
			else
			{
				$curremail = $_SESSION['useremail'];
				$sql = $pdo->prepare("UPDATE staff SET first_name = :fname, last_name = :lname, email= :email, phone_number = :phoneno WHERE email = :curremail");
				$updated = $sql->execute(array(':fname' => $_POST['fname'], ':lname' => $_POST['lname'], ':email' => $_POST['email'], ':phoneno' => $_POST['phoneno'], ':curremail' => $curremail));
				if ($updated)
				{
					$_SESSION['feedbackmessage'] = "Record updated";
					unset($_POST['edit']);
					$_SESSION['useremail'] = $_POST['email'];
				}
				else
				{
					$_SESSION['feedbackmessage'] = "Invalid input";
				}
			}
			header("Refresh:0");
			exit;
		}
		else if (isset($_POST["editaddress"]))
		{
			$curremail = $_SESSION['useremail'];
			$sql = $pdo->prepare("SELECT AddressID FROM staff WHERE email = :email");
			$sql->execute(array(':email' => $curremail));
			$row = $sql->fetch(PDO::FETCH_ASSOC);
			
			$addressid = $row['AddressID'];
			$sql = $pdo->prepare("UPDATE address SET property_number = :propertyno, street = :street, city = :city, postcode = :postcode WHERE address_id = :addressid");
			$updated = $sql->execute(array(':propertyno' => $_POST['propertyno'], ':street' => $_POST['street'], ':city' => $_POST['city'], ':postcode' => $_POST['postcode'], ':addressid' => $addressid));
			if ($updated)
			{
				$_SESSION['feedbackmessage'] = "Record updated";
				unset($_POST['edit']);
			}
			else
			{
				$_SESSION['feedbackmessage'] = "Invalid input";
			}
			
			header("Refresh:0");
			exit;
		}
		
		function staffviewSwitch()
		{
			include "db.php";
			$querystring = "SELECT * FROM staffview WHERE email = '" . $_SESSION['useremail'] . "'";
			$sql = $pdo->prepare($querystring);
			$sql->execute();
			echo "<table>
			<tr><th>Staff ID</th><th>First Name</th><th>Last Name</th><th>Sex</th><th>Address</th><th>Email</th><th>Phone Number</th><th>Role</th><th>Salary</th><th>National Insurance Number</th>";
			while ($row = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$staffno = $row['staff_number'];
				$fname = $row['first_name'];
				$lname = $row['last_name'];
				$sex = $row['sex'];
				$address = $row['property_number'] . " " . $row['street'] . " " . $row['city'] . " " . $row['postcode'];
				$email = $row['email'];
				$phone = $row['phone_number'];
				$role = $row['role'];
				$salary = $row['salary'];
				$nin = $row['national_insurance_number'];
				
				echo "<tr><td>$staffno</td><td>$fname</td><td>$lname</td><td>$sex</td><td>$address</td><td>$email</td><td>$phone</td><td>$role</td><td>£$salary</td><td>$nin</td><td><form method = post><button name='personaledit'>Edit</button></form></td>";
			}
		echo "</table>";
		
		if (isset($_SESSION['editprofile']))
		{
			$editprofile = $_SESSION['editprofile'];
		}
		else
		{
			$editprofile = False;
		}
		
		if ($editprofile == True)
		{
			echo "	    <div class='table'>
						<table id='edit'>
						<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone Number</th>
						<form method = \"post\">
						<tr>
						<td><input type=\"text\" required name=\"fname\"></td>
						<td><input type=\"text\" required name=\"lname\"></td>
						<td><input type=\"email\" required name=\"email\"></td>
						<td><input type=\"text\" required name=\"phoneno\"></td>
						<td><button type = \"submit\" name = \"editpersonal\">Confirm</button></td>
						</form>
						</table>
						<table id='editad'>
						<tr><th>Property Number</th><th>Street</th><th>City</th><th>Postcode</th>
						<form method = \"post\">
						<tr>
						<td><input type=\"text\" required name=\"propertyno\"></td>
						<td><input type=\"text\" required name=\"street\"></td>
						<td><input type=\"text\" required name=\"city\"></td>
						<td><input type=\"text\" required name=\"postcode\"></td>
						<td><button type = \"submit\" name = \"editaddress\">Confirm</button></td>
						</form>
						</table>
						</div>";
		}
		}
		
		function carviewSwitch()
		{
			include "db.php";
			if (isset($_SESSION['makepref']))
		{
			$makepref = $_SESSION['makepref'];
		}
		else
		{
			$makepref = "none";
		}
		if (isset($_SESSION['typepref']))
		{
			$typepref = $_SESSION['typepref'];
		}
		else
		{
			$typepref = "none";
		}
		if (isset($_SESSION['transpref']))
		{
			$transpref = $_SESSION['transpref'];
		}
		else
		{
			$transpref = "none";
		}
		if (isset($_SESSION['availability']))
		{
			$availability = $_SESSION['availability'];
			if ($availability == "Yes")
			{
				$availability = 1;
			}
			else if ($availability == "No")
			{
				$availability = 0;
			}
			else
			{
				$availability = 2;
			}
		}
		else
		{
			$availability = 2;
		}
		if (isset($_SESSION['branchno']))
		{
			$branchno = $_SESSION['branchno'];
		}
		else
		{
			$branchno = "";
		}
		
		if (isset($_POST["carsearch"]))
		{
			$_SESSION['makepref'] = $_POST["make"];
			$_SESSION['typepref'] = $_POST["type"];
			$_SESSION['transpref'] = $_POST["transmission"];
			$_SESSION['availability'] = $_POST["availability"];
			
			header("Refresh:0");
			exit;
		}
		$querystring = "SELECT * FROM carstockview";
		$whereadded = False;
		if ($makepref != "none")
		{
			$whereadded = True;
			$querystring = $querystring . " WHERE make = '" . $makepref . "'";
		}
		if ($typepref != "none")
		{
			if ($whereadded == False)
			{
				$querystring = $querystring . " WHERE type = '" . $typepref . "'";
				$whereadded = True;
			}
			else
			{
				$querystring = $querystring . " and type = '" . $typepref . "'";
			}
		}
		if ($transpref != "none")
		{
			if ($whereadded == False)
			{
				$querystring = $querystring . " WHERE transmission = '" . $transpref . "'";
				$whereadded = True;
			}
			else
			{
				$querystring = $querystring . " and transmission = '" . $transpref . "'";
			}
		}
		if ($availability != 2)
		{
			if ($whereadded == False)
			{
				$querystring = $querystring . " WHERE availability = " . $availability;
				$whereadded = True;
			}
			else
			{
				$querystring = $querystring . " and availability = " . $availability;
			}
		}
		if ($branchno != "")
		{
			if ($whereadded == False)
			{
				$querystring = $querystring . " WHERE BranchNumber = '" . $branchno . "'";
				$whereadded = True;
			}
			else
			{
				$querystring = $querystring . " and BranchNumber = '" . $branchno . "'";
			}
		}
		$sql = $pdo->prepare($querystring);
		echo "<table>
		<tr><th>Supplier Name</th><th>Insurance Number</th><th>Vehicle Identification Number</th><th>Make</th><th>Model</th><th>Type</th><th>Transmission</th><th>Rent</th><th>Colour</th><th>Available</th><th>Leased</th><th>Advertised</th><th>Last Checkup</th>";
		$sql->execute();
			while ($row = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$insuranceno = $row['InsuranceNumber'];
				$suppliername = $row['company_name'];
				$vin = $row['VIN'];
				$make = $row['make'];
				$model = $row['model'];
				$type = $row['type'];
				$trans = $row['transmission'];
				$rent = $row['rent_per_day'];
				$availability = $row['available'];
				$lastcheck = $row['last_checkup'];
				$colour = $row['colour'];
				$leased = $row['leased'];
				$advertised = $row['advertised'];
				
				echo "<tr><td>$suppliername</td><td>$insuranceno</td><td>$vin</td><td>$make</td><td>$model</td><td>$type</td><td>$trans</td><td>£$rent</td><td>$colour</td><td>$availability</td><td>$leased</td><td>$advertised</td><td>$lastcheck</td>";
			}
		echo "</table>";
		echo "<div class='sidesearch'> ";
		echo "<form method = \"post\">
			Make<br>
			<select type = \"radio\" name=\"make\">
				<option value=\"none\">Any</option>
				<option value=\"Audi\">Audi</option>
				<option value=\"BMW\">BMW</option>
				<option value=\"Ford\">Ford</option>
				<option value=\"Honda\">Honda</option>
				<option value=\"Kia\">Kia</option>
				<option value=\"Range Rover\">Range Rover</option>
				<option value=\"Rolls Royce\">Rolls Royce</option>
				<option value=\"Tesla\">Tesla</option>
				<option value=\"Volvo\">Volvo</option>
				<option value=\"VW\">VW</option>				
			</select>
			<br>
			Type<br>
			<select type = \"radio\" name=\"type\">
				<option value=\"none\">Any</option>
				<option value=\"Hatchback\">Hatchback</option>
				<option value=\"Sedan\">Sedan</option>
				<option value=\"SUV\">SUV</option>
				<option value=\"Luxury\">Luxury</option>
			</select>
			<br>
			Transmission<br>
			<input type = \"radio\" name = \"transmission\" value = \"none\" checked>Any<br>
			<input type = \"radio\" name = \"transmission\" value = \"Auto\">Auto<br>
			<input type = \"radio\" name = \"transmission\" value = \"Manual\">Manual<br>
			<br>
			Available<br>
			<input type = \"radio\" name = \"availability\" value = \"none\" checked>Either<br>
			<input type = \"radio\" name = \"availability\" value = \"Yes\">Yes<br>
			<input type = \"radio\" name = \"availability\" value = \"No\">No<br>
			
			<button type = \"submit\" name = \"carsearch\" >Search</button>
				</form>";
		echo "</div>";
	
		
		}
		
		function leaseviewSwitch()
		{
			include "db.php";
			
			$querystring = "SELECT * FROM leaseview WHERE BranchNumber = '" . $_SESSION['branchno'] . "'";
			$sql = $pdo->prepare($querystring);
			$sql->execute();
			
			echo "<table>
			<tr><th>Lease Number</th><th>Customer Number</th><th>Vehicle Identification Number</th><th>Start Date</th><th>End Date</th><th>Total Rent</th>";
			while ($row = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$leaseno = $row['lease_number'];
				$customerno = $row['CustomerNumber'];
				$carvin = $row['VIN'];
				$startdate = $row['start_date'];
				$enddate = $row['end_date'];
				$totalrent = $row['total_rent'];
				
				echo "<tr><td>$leaseno</td><td>$customerno</td><td>$carvin</td><td>$startdate</td><td>$enddate</td><td>£$totalrent</td>";
			}
		echo "</table>";
		}
		
		function customerviewSwitch()
		{
		include "db.php";
		if (isset($_SESSION['custno']))
		{
			$custno = $_SESSION['custno'];
		}
		else
		{
			$custno = "";
		}
		if (isset($_SESSION['custfname']))
		{
			$fname = $_SESSION['custfname'];
		}
		else
		{
			$fname = "";
		}
		if (isset($_SESSION['custlname']))
		{
			$lname = $_SESSION['custlname'];
		}
		else
		{
			$lname = "";
		}
		
		if (isset($_POST["custsearch"]))
		{
			$_SESSION['custno'] = $_POST["custno"];
			$_SESSION['custfname'] = $_POST["fname"];
			$_SESSION['custlname'] = $_POST["lname"];
			
			header("Refresh:0");
			exit;
		}
		$querystring = "SELECT * FROM customerview";
		if ($custno != "")
		{
			$querystring = $querystring . " WHERE customer_number LIKE '%" . $custno . "%'";
		}
		if ($fname != "")
		{
			$querystring = $querystring . " WHERE first_name LIKE '%" . $fname . "%'";
		}
		if ($lname != "")
		{
			$querystring = $querystring . " WHERE last_name LIKE '%" . $lname . "%'";
		}
		$sql = $pdo->prepare($querystring);
		$sql->execute();
		
		echo "<table>
		<tr><th>Customer Number</th><th>Address</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone Number</th><th>Membership</th><th>Preferred Type</th><th>Preferred Make</th><th>Preferred Model</th><th>Preferred Transmission</th><th>Has Lease</th>";
			while ($row = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$custno = $row['customer_number'];
				$address = $row['property_number'] . " " . $row['street'] . " " .  $row['city'] . " " .  $row['postcode'];
				$fname = $row['first_name'];
				$lname = $row['last_name'];
				$email = $row['email'];
				$phoneno = $row['phone_number'];
				$membership = $row['membership'];
				$type = $row['type'];
				$make = $row['make'];
				$model = $row['model'];
				$trans = $row['transmission'];		
				$leased = $row['lease'];				
				
				echo "<tr><td>$custno</td><td>$address</td><td>$fname</td><td>$lname</td><td>$email</td><td>$phoneno</td><td>$membership</td><td>$type</td><td>$make</td><td>$model</td><td>$trans</td><td>$leased</td>";
			}
		echo "</table>";
		echo "<div class='sidesearch'> ";
		echo "<form method = \"post\">
						Customer Number<br>
						<input type=\"text\" name=\"custno\"><br>
						First name<br>
						<input type=\"text\" name=\"fname\"><br>
						Last name<br>
						<input type=\"text\" name=\"lname\"><br>
						<button type = \"submit\" name = \"custsearch\">Search</button>
					</form>";
		echo "</div>";
		}
		
		function supplierviewSwitch()
		{
			include "db.php";
			$querystring = "SELECT * FROM supplierview";
			$sql = $pdo->prepare($querystring);
			$sql->execute();
			
			echo "<table>
			<tr><th>Company Number</th><th>Address</th><th>Contract Number</th><th>Phone Number</th><th>Company Name</th>";
			while ($row = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$companyno = $row['company_number'];
				$address = $row['property_number'] . " " . $row['street'] . " " .  $row['city'] . " " .  $row['postcode'];
				$contractno = $row['contract_number'];
				$phoneno = $row['phone_number'];
				$companyname = $row['company_name'];
				
				echo "<tr><td>$companyno</td><td>$address</td><td>$contractno</td><td>$phoneno</td><td>$companyname</td>";
			}
		echo "</table>";
		}
		
		function repairviewSwitch()
		{
			include "db.php";
			$querystring = "SELECT * FROM repairview WHERE Branch_Number = '" . $_SESSION['branchno'] . "'";
			$sql = $pdo->prepare($querystring);
			$sql->execute();
			
			echo "<table>
			<tr><th>Company Number</th><th>Address</th><th>Phone Number</th><th>Company Name</th>";
			while ($row = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$companyno = $row['company_number'];
				$address = $row['property_number'] . " " . $row['street'] . " " .  $row['city'] . " " .  $row['postcode'];
				$phonenno = $row['phone_number'];
				$companyname = $row['company_name'];
				
				echo "<tr><td>$companyno</td><td>$address</td><td>$phonenno</td><td>$companyname</td>";
			}
		echo "</table>";
		}
		
		function valetviewSwitch()
		{
			include "db.php";
			$querystring = "SELECT * FROM valetview WHERE BranchNumber = '" . $_SESSION['branchno'] . "'";
			$sql = $pdo->prepare($querystring);
			$sql->execute();
			
			echo "<table>
			<tr><th>Company Number</th><th>Address</th><th>Phone Number</th><th>Company Name</th>";
			while ($row = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$companyno = $row['company_number'];
				$address = $row['property_number'] . " " . $row['street'] . " " .  $row['city'] . " " .  $row['postcode'];
				$phonenno = $row['phone_number'];
				$companyname = $row['company_name'];
				
				echo "<tr><td>$companyno</td><td>$address</td><td>$phonenno</td><td>$companyname</td>";
			}
		echo "</table>";
		}
		
		function advertviewSwitch()
		{
			include "db.php";
			$querystring = "SELECT * FROM adverts";
			$sql = $pdo->prepare($querystring);
			$sql->execute();
			
			echo "<table>
			<tr><th>Advert Number</th><th>Car Vehicle Identification Number</th><th>Date Published</th><th>Media Type</th>";
			while ($row = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$advertno = $row['advert_number'];
				$vin = $row['CarVIN'];
				$published = $row['date_published'];
				$mediatype = $row['media_type'];
				
				echo "<tr><td>$advertno</td><td>$vin</td><td>$published</td><td>$mediatype</td>";
			}
		echo "</table>";
		}
		?> 
</body>
</html>