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
						<p>Executive View</p>
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


<div class="Butbar">		
		<form method = "post">
			<ul class="button-group">
			<li><button class="large button" type = "submit" name = "personalview">Personal Info</button></li>
			
			<li><button class="large button" type = "submit" name = "branchview">Company Branches</button></li>
			
			<li><button class="large button" type = "submit" name = "payrollview">Payroll</button></li>
			
			<li><button class="large button" type = "submit" name = "staffview">Company Staff</button></li>
			
			<li><button class="large button" type = "submit" name = "carview">Car Stock</button></li>
			
			<li><button class="large button" type = "submit" name = "leaseview">Leases</button></li>
			
			<li><button class="large button" type = "submit" name = "customerview">Customers</button></li>
			
			<li><button class="large button" type = "submit" name = "supplierview">Suppliers</button></li>
			
			<li><button class="large button" type = "submit" name = "repairview">Repair</button></li>
			
			<li><button class="large button" type = "submit" name = "valetview">Valet</button></li>	

			<li><button class="large button" type = "submit" name = "advertview">Adverts</button></li>				
			
			<li><button class="large button" type = "submit" name = "insertview">Add/Update Records</button></li>
			
		</ul>
		
	</form>
</div>
</head> 
<body> 
<?php 
		ob_start();
		include "db.php"; 
		$useremail = $_SESSION['useremail'];
		
		if ($_SESSION['userview'] != "executive")
		{
			header("Location: index.php");
			exit;
		}
		
		if (isset($_SESSION['currview']))
		{
			switch($_SESSION['currview'])
			{
				case "branch":
						branchviewSwitch();
						break;
						
				case "payroll":
						payrollviewSwitch();
						break;
				
				case "personal":
						personalviewSwitch();
						break;
				
				case "staff":
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

				case "insert":
						insertviewSwitch();
						break;									
			}
		}
		else
		{
			personalviewSwitch();
		}
		if (isset($_POST["personalview"]))
		{
			$_SESSION['editprofile'] = False;
			$_SESSION['currview'] = "personal";
			
			header("Refresh:0");
			exit;
		}
		else if (isset($_POST["branchview"]))
		{
			$_SESSION['currview'] = "branch";
			
			header("Refresh:0");
			exit;
		}
		else if (isset($_POST["payrollview"]))
		{
			$_SESSION['currview'] = "payroll";
			
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
		else if (isset($_POST["insertview"]))
		{
			$_SESSION['currview'] = "insert";
			
			header("Refresh:0");
			exit;
		}
		else if (isset($_POST["logout"]))
		{
			session_unset();
			header("Location: index.php");
			exit;
		}
		
		else if (isset($_POST["deleterecord"]))
		{
			echo "<div class=execdeletebut>";
			$_SESSION['pkdelete'] = $_POST["deleterecord"];
			echo "Confirm deletion of ID " . $_POST["deleterecord"] . ".";
			echo "<form method = \"post\"><button type = \"submit\" name = \"confirmdeleterecord\">Confirm Delete</button></form>";
		}
		else if (isset($_POST["confirmdeleterecord"]))
		{
			$_SESSION['feedbackmessage'] = "Record deleted";
			echo "</div>";
			$pkdelete = $_SESSION['pkdelete'];
			
			switch($_SESSION['currview'])
				{
					case "branch":
						$querystring = "SELECT AddressID FROM branch WHERE branch_number = '" . $pkdelete . "'";
						$sql = $pdo->prepare($querystring);
						$sql->execute();
						$row = $sql->fetch(PDO::FETCH_ASSOC);
						$addressid = $row['AddressID'];
						
						$querystring = "DELETE FROM address WHERE address_id = '" . $addressid . "'";
						$sql = $pdo->prepare($querystring);
						$sql->execute();
						
						$querystring = "DELETE FROM branch WHERE branch_number = '" . $pkdelete . "'";
						$sql = $pdo->prepare($querystring);
						$sql->execute();
						
						header("Refresh:0");
						break;
					
					case "staff":
						$querystring = "SELECT AddressID FROM staff WHERE staff_number = '" . $pkdelete . "'";
						$sql = $pdo->prepare($querystring);
						$sql->execute();
						$row = $sql->fetch(PDO::FETCH_ASSOC);
						$addressid = $row['AddressID'];
						
						$querystring = "DELETE FROM address WHERE address_id = '" . $addressid . "'";
						$sql = $pdo->prepare($querystring);
						$sql->execute();
						
						$querystring = "DELETE FROM staff WHERE staff_number = '" . $pkdelete . "'";
						$sql = $pdo->prepare($querystring);
						$sql->execute();
						
						header("Refresh:0");
						break;
							
					case "car":						
						$querystring = "DELETE FROM car WHERE VIN = '" . $pkdelete . "'";
						$sql = $pdo->prepare($querystring);
						$sql->execute();
						
						header("Refresh:0");
						break;
							
					case "leases":						
						$querystring = "DELETE FROM lease WHERE lease_number = '" . $pkdelete . "'";
						$sql = $pdo->prepare($querystring);
						$sql->execute();
						
						header("Refresh:0");
						break;
		
					case "customers":
						$querystring = "SELECT AddressID FROM customer WHERE cusomter_number = '" . $pkdelete . "'";
						$sql = $pdo->prepare($querystring);
						$sql->execute();
						$row = $sql->fetch(PDO::FETCH_ASSOC);
						$addressid = $row['AddressID'];
						
						$querystring = "DELETE FROM address WHERE address_id = '" . $addressid . "'";
						$sql = $pdo->prepare($querystring);
						$sql->execute();
						
						$querystring = "DELETE FROM customer WHERE customer_number = '" . $pkdelete . "'";
						$sql = $pdo->prepare($querystring);
						$sql->execute();
						
						header("Refresh:0");
						break;
		
					case "repair":
						$querystring = "SELECT AddressID FROM repair WHERE company_number = '" . $pkdelete . "'";
						$sql = $pdo->prepare($querystring);
						$sql->execute();
						$row = $sql->fetch(PDO::FETCH_ASSOC);
						$addressid = $row['AddressID'];
						
						$querystring = "DELETE FROM address WHERE address_id = '" . $addressid . "'";
						$sql = $pdo->prepare($querystring);
						$sql->execute();
						
						$querystring = "DELETE FROM repair WHERE company_number = '" . $pkdelete . "'";
						$sql = $pdo->prepare($querystring);
						$sql->execute();
						
						header("Refresh:0");
						break;
		
					case "valet":
						$querystring = "SELECT AddressID FROM valet WHERE company_number = '" . $pkdelete . "'";
						$sql = $pdo->prepare($querystring);
						$sql->execute();
						$row = $sql->fetch(PDO::FETCH_ASSOC);
						$addressid = $row['AddressID'];
						
						$querystring = "DELETE FROM address WHERE address_id = '" . $addressid . "'";
						$sql = $pdo->prepare($querystring);
						$sql->execute();
						
						$querystring = "DELETE FROM valet WHERE company_number = '" . $pkdelete . "'";
						$sql = $pdo->prepare($querystring);
						$sql->execute();
						
						header("Refresh:0");
						break;		
								
					case "advert":
						$querystring = "DELETE FROM adverts WHERE advert_number = '" . $pkdelete . "'";
						$sql = $pdo->prepare($querystring);
						$sql->execute();
						
						header("Refresh:0");
						break;		
				}
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
		
		
		function branchviewSwitch()
		{			
			include "db.php";
			$querystring = "SELECT * FROM branchview";
			$sql = $pdo->prepare($querystring);
			$sql->execute();
			echo "<table>
			<tr><th>Branch Number</th><th>Address</th><th>Staff</th><th>Cars</th><th>Leases</th><th>Total Salary</th>";
			while ($row = $sql->fetch(PDO::FETCH_ASSOC))
			{
				
				$branchno = $row['branch_number'];
				$address = $row['property_number'] . " " . $row['street'] . " " . $row['city'] . " " . $row['postcode'];
				$staff = $row['staff'];
				$cars = $row['cars'];
				$leases = $row['leases'];
				$salary = $row['salary'];
				
				echo "<tr><td>$branchno</td><td>$address</td><td>$staff</td><td>$cars</td><td>$leases</td><td>£$salary</td></td>";
				echo "<td><form method = \"post\"><button type = \"submit\" value = \"$branchno\" name = \"deleterecord\">Delete</button></form></td>";
			}
		echo "</table>";
		}
		
		function payrollviewSwitch()
		{
			include "db.php";
			
			if (isset($_SESSION['paynin']))
			{
				$nin = $_SESSION['paynin'];
			}
			else
			{
				$nin = "";
			}
			if (isset($_SESSION['payfname']))
			{
				$fname = $_SESSION['payfname'];
			}
			else
			{
				$fname = "";
			}
			if (isset($_SESSION['paylname']))
			{
				$lname = $_SESSION['paylname'];
			}
			else
			{
				$lname = "";
			}
			if (isset($_SESSION['paysalary']))
			{
				$salary = $_SESSION['paysalary'];
			}
			else
			{
				$salary = 0;
			}
		
			if (isset($_SESSION['payrange']))
			{
				$range = $_SESSION['payrange'];
			}
			else
			{
				$range = "greater";
			}
			
			
			if (isset($_POST["payrollsearch"]))
			{
				$_SESSION['paynin'] = $_POST["nin"];
				$_SESSION['paysalary'] = $_POST["salary"];
				$_SESSION['payfname'] = $_POST["fname"];
				$_SESSION['paylname'] = $_POST["lname"];
				$_SESSION['payrange'] = $_POST['salaryrange'];
				
				header("Refresh:0");
				exit;
			}
			
			$querystring = "SELECT * FROM payrollview WHERE nin LIKE ? and first_name LIKE ? and last_name LIKE ?";
			
			if ($salary != 0)
			{
				if ($range == "greater")
				{
					$querystring = $querystring . " and Monthly_Salary >= ?";
				}
				else
				{
					$querystring = $querystring . " and Monthly_Salary <= ?";
				}
			}
			else
			{
				$querystring = $querystring . " and Monthly_Salary >= ?";
			}
			
			$params = array("%$nin%", "%$fname%", "%$lname%", "$salary");
			
			$sql = $pdo->prepare($querystring);
			$sql->execute($params);
			echo "<table>
			<tr><th>Branch Number</th><th>Staff Number</th><th>First Name</th><th>Last Name</th><th>Sex</th><th>Address</th><th>Email</th><th>Phone Number</th><th>Role</th><th>Monthly Salary</th><th>National Insurance Number</th>";
			while ($row = $sql->fetch(PDO::FETCH_ASSOC))
			{
				
				$branchno = $row['BranchNumber'];
				$address = $row['property_number'] . " " . $row['street'] . " " . $row['city'] . " " . $row['postcode'];
				$staffno = $row['staff_number'];
				$fname = $row['first_name'];
				$lname = $row['last_name'];
				$sex = $row['sex'];
				$email = $row['email'];
				$phoneno = $row['phone_number'];
				$role = $row['role'];
				$nin = $row['nin'];
				$msalary = $row['Monthly_Salary'];
				
				echo "<tr><td>$branchno</td><td>$staffno</td><td>$fname</td><td>$lname</td><td>$sex</td><td>$address</td><td>$email</td><td>$phoneno</td><td>$role</td><td>£$msalary</td><td>$nin</td></td>";
			}
		echo "</table>";
		echo "<div class='sidesearchexec'> ";
		echo "<form method = \"post\">
						First name<br>
						<input type=\"text\" name=\"fname\"><br>
						Last name<br>
						<input type=\"text\" name=\"lname\"><br>
						NIN<br>
						<input type=\"text\" name=\"nin\"><br>
						Salary<br>
						<input type=\"radio\" name=\"salaryrange\" value=\"greater\" checked>Greater than<br>
						<input type=\"radio\" name=\"salaryrange\" value=\"less\">Less than<br>
						<input type=\"text\" name=\"salary\"><br>
						<button type = \"submit\" name = \"payrollsearch\">Search</button>
					</form>";
		echo "</div>";
		}
		
		function personalviewSwitch()
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
			echo "		<table id='edit'>
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
						";
		}
		}
		
		function staffviewSwitch()
		{
			include "db.php";
			
			if (isset($_SESSION['staffrole']))
			{
				$role = $_SESSION['staffrole'];
			}
			else
			{
				$role = "";
			}
			
			if (isset($_SESSION['staffbranch']))
			{
				$branchno = $_SESSION['staffbranch'];
			}
			else
			{
				$branchno = "";
			}
			
			if (isset($_SESSION['payfname']))
			{
				$fname = $_SESSION['payfname'];
			}
			else
			{
				$fname = "";
			}
			if (isset($_SESSION['paylname']))
			{
				$lname = $_SESSION['paylname'];
			}
			else
			{
				$lname = "";
			}
			
			if (isset($_POST["staffsearch"]))
			{
				$_SESSION['staffrole'] = $_POST["role"];
				$_SESSION['staffbranch'] = $_POST["branchno"];
				$_SESSION['payfname'] = $_POST["fname"];
				$_SESSION['paylname'] = $_POST["lname"];
				
				header("Refresh:0");
				exit;
			}
			
			$querystring = "SELECT * FROM staffview WHERE role LIKE ? and first_name LIKE ? and last_name LIKE ? and BranchNumber LIKE ?";
			$params = array("%$role%", "%$fname%", "%$lname%", "%$branchno%");
			
			$sql = $pdo->prepare($querystring);
			$sql->execute($params);
			echo "<table>
			<tr><th>Staff ID</th><th>Branch Number</th><th>First Name</th><th>Last Name</th><th>Sex</th><th>Address</th><th>Email</th><th>Phone Number</th><th>Role</th><th>Salary</th><th>National Insurance Number</th>";
			while ($row = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$staffno = $row['staff_number'];
				$branchno = $row['BranchNumber'];
				$fname = $row['first_name'];
				$lname = $row['last_name'];
				$sex = $row['sex'];
				$address = $row['property_number'] . " " . $row['street'] . " " . $row['city'] . " " . $row['postcode'];
				$email = $row['email'];
				$phone = $row['phone_number'];
				$role = $row['role'];
				$salary = $row['salary'];
				$nin = $row['national_insurance_number'];
				
				echo "<tr><td>$staffno</td><td>$branchno</td><td>$fname</td><td>$lname</td><td>$sex</td><td>$address</td><td>$email</td><td>$phone</td><td>$role</td><td>£$salary</td><td>$nin</td>";
				if ($role != "Executive") {echo "<td><form method = \"post\"><button type = \"submit\" value = \"$staffno\" name = \"deleterecord\">Delete</button></form></td>";}
			}
		echo "</table>";
				echo "<div class='sidesearchexec'> ";
		echo "<form method = \"post\">
						First name<br>
						<input type=\"text\" name=\"fname\"><br>
						Last name<br>
						<input type=\"text\" name=\"lname\"><br>
						Branch Number<br>
						<input type=\"radio\" name=\"branchno\" value=\"\" checked>None<br>
						<input type=\"radio\" name=\"branchno\" value=\"B000000001\">B000000001<br>
						<input type=\"radio\" name=\"branchno\" value=\"B000000002\">B000000002<br>
						<input type=\"radio\" name=\"branchno\" value=\"B000000003\">B000000003<br>
						<input type=\"radio\" name=\"branchno\" value=\"B000000004\">B000000004<br>
						<input type=\"radio\" name=\"branchno\" value=\"B000000005\">B000000005<br>
						Role<br>
						<input type=\"radio\" name=\"role\" value=\"\" checked>None<br>
						<input type=\"radio\" name=\"role\" value=\"Sales\">Sales<br>
						<input type=\"radio\" name=\"role\" value=\"Branch Manager\">Branch Manager<br>
						<input type=\"radio\" name=\"role\" value=\"Executive\">Executive<br>
						<button type = \"submit\" name = \"staffsearch\">Search</button>
					</form>";
		echo "</div>";
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
				$makepref = "";
			}
			if (isset($_SESSION['typepref']))
			{
				$typepref = $_SESSION['typepref'];
			}
			else
			{
				$typepref = "";
			}
			if (isset($_SESSION['transpref']))
			{
				$transpref = $_SESSION['transpref'];
			}
			else
			{
				$transpref = "";
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
			$_SESSION['branchno'] = $_POST["branchno"];
			
			header("Refresh:0");
			exit;
		}		
		
		if ($availability == 1)
		{
			$querystring = "SELECT * FROM carstockview WHERE make LIKE ? and type LIKE ? and transmission LIKE ? and BranchNumber LIKE ? and availability = 1";
			$params = array("%$makepref%", "%$typepref%", "%$transpref%", "%$branchno%");
		}
		else if ($availability == 0)
		{
			$querystring = "SELECT * FROM carstockview WHERE make LIKE ? and type LIKE ? and transmission LIKE ? and BranchNumber LIKE ? and availability = 0";
			$params = array("%$makepref%", "%$typepref%", "%$transpref%", "%$branchno%");
		}
		else
		{
			$querystring = "SELECT * FROM carstockview WHERE make LIKE ? and type LIKE ? and transmission LIKE ? and BranchNumber LIKE ?";
			$params = array("%$makepref%", "%$typepref%", "%$transpref%", "%$branchno%");
		}
		$sql = $pdo->prepare($querystring);
		$sql->execute($params);
		
		echo "<table>
		<tr><th>Branch Number</th><th>Supplier Name</th><th>Insurance Number</th><th>Vehicle Identification Number</th><th>Make</th><th>Model</th><th>Type</th><th>Transmission</th><th>Rent</th><th>Colour</th><th>Available</th><th>Leased</th><th>Advertised</th><th>Last Checkup</th>";
		
			while ($row = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$branchno = $row['BranchNumber'];
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
				
				echo "<tr><td>$branchno</td><td>$suppliername</td><td>$insuranceno</td><td>$vin</td><td>$make</td><td>$model</td><td>$type</td><td>$trans</td><td>£$rent</td><td>$colour</td><td>$availability</td><td>$leased</td><td>$advertised</td><td>$lastcheck</td>";
				echo "<td><form method = \"post\"><button type = \"submit\" value = \"$vin\" name = \"deleterecord\">Delete</button></form></td>";
			}
		echo "</table>";
				echo "<div class='sidesearchexec'> ";
		echo "<form method = \"post\">
			Make<br>
			<select type = \"radio\" name=\"make\">
				<option value=\"\">Any</option>
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
				<option value=\"\">Any</option>
				<option value=\"Hatchback\">Hatchback</option>
				<option value=\"Sedan\">Sedan</option>
				<option value=\"SUV\">SUV</option>
				<option value=\"Luxury\">Luxury</option>
			</select>
			<br>
			Transmission<br>
			<input type = \"radio\" name = \"transmission\" value = \"\" checked>Any<br>
			<input type = \"radio\" name = \"transmission\" value = \"Auto\">Auto<br>
			<input type = \"radio\" name = \"transmission\" value = \"Manual\">Manual<br>
			
			Available<br>
			<input type = \"radio\" name = \"availability\" value = \"\" checked>Either<br>
			<input type = \"radio\" name = \"availability\" value = \"Yes\">Yes<br>
			<input type = \"radio\" name = \"availability\" value = \"No\">No<br>
			
			Branch Number<br>
			<input type=\"text\" name=\"branchno\"><br>
			
			<button type = \"submit\" name = \"carsearch\" >Search</button>
			
		</form>";
		echo "</div>";
		}
		
		function leaseviewSwitch()
		{
			include "db.php";
			if (isset($_SESSION['date']) && $_SESSION['date'] != "")
			{
				$date = $_SESSION['date'];
				
				$querystring = "SELECT * FROM leaseview WHERE ? BETWEEN start_date AND end_date";
				$params = array("$date");
			}
			else
			{
				$querystring = "SELECT * FROM leaseview";
				$params = array("");
			}
			
			if (isset($_POST["leasesearch"]))
			{
				$_SESSION['date'] = $_POST["date"];
				
				header("Refresh:0");
				exit;
			}
		
			$sql = $pdo->prepare($querystring);
			$sql->execute($params);
		
			echo "<table>
			<tr><th>Lease Number</th><th>Customer Number</th><th>Vehicle Identification Number</th><th>Start Date</th><th>End Date</th><th>Total Rent</th>";
			while ($row = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$branchno = $row['BranchNumber'];
				$leaseno = $row['lease_number'];
				$customerno = $row['CustomerNumber'];
				$carvin = $row['VIN'];
				$startdate = $row['start_date'];
				$enddate = $row['end_date'];
				$totalrent = $row['total_rent'];
				
				echo "<tr><td>$leaseno</td><td>$customerno</td><td>$carvin</td><td>$startdate</td><td>$enddate</td><td>£$totalrent</td>";
				echo "<td><form method = \"post\"><button type = \"submit\" value = \"$leaseno\" name = \"deleterecord\">Delete</button></form></td>";
			}
		echo "</table>";
				echo "<div class='sidesearchexec'> ";
		echo "<form method = \"post\">
						Active On<br>
						<input type=\"date\" name=\"date\"><br>
						<button type = \"submit\" name = \"leasesearch\">Search</button>
					</form>";
				echo"</div>";
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
		
		$querystring = "SELECT * FROM customerview WHERE first_name LIKE ? and last_name LIKE ? and customer_number LIKE ?";
		$params = array("%$fname%", "%$lname%", "%$custno%");
		
		$sql = $pdo->prepare($querystring);
		$sql->execute($params);
		
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
				echo "<td><form method = \"post\"><button type = \"submit\" value = \"$custno\" name = \"deleterecord\">Delete</button></form></td>";
			}
		echo "</table>";
				echo "<div class='sidesearchexec'> ";
		echo "<form method = \"post\">
						Customer Number<br>
						<input type=\"text\" name=\"custno\"><br>
						First name<br>
						<input type=\"text\" name=\"fname\"><br>
						Last name<br>
						<input type=\"text\" name=\"lname\"><br>
						<button type = \"submit\" name = \"custsearch\">Search</button>
					</form>";
				echo"</div>";
		}
		
		function supplierviewSwitch()
		{
			include "db.php";
			$querystring = "SELECT * FROM supplierview";
			$sql = $pdo->prepare($querystring);
			$sql->execute();
			
			echo "<table>
			<tr><th>Company Name</th><th>Address</th><th>Phone Number</th><th>Company Number</th><th>Contract Number</th>";
			while ($row = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$companyno = $row['company_number'];
				$address = $row['property_number'] . " " . $row['street'] . " " .  $row['city'] . " " .  $row['postcode'];
				$contractno = $row['contract_number'];
				$phoneno = $row['phone_number'];
				$companyname = $row['company_name'];
				
				echo "<tr><td>$companyname</td><td>$address</td><td>$phoneno</td><td>$companyno</td><td>$contractno</td>";
			}
		echo "</table>";
		}
		
		function repairviewSwitch()
		{
			include "db.php";
			$querystring = "SELECT * FROM repairview";
			$sql = $pdo->prepare($querystring);
			$sql->execute();
			
			echo "<table>
			<tr><th>Company Name</th><th>Address</th><th>Phone Number</th><th>Company Number</th>";
			while ($row = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$companyno = $row['company_number'];
				$address = $row['property_number'] . " " . $row['street'] . " " .  $row['city'] . " " .  $row['postcode'];
				$branchno = $row['Branch_Number'];
				$phonenno = $row['phone_number'];
				$companyname = $row['company_name'];
				
				echo "<tr><td>$companyname</td><td>$address</td><td>$phonenno</td><td>$companyno</td>";
				echo "<td><form method = \"post\"><button type = \"submit\" value = \"$companyno\" name = \"deleterecord\">Delete</button></form></td>";
			}
		echo "</table>";
		}
		
		function valetviewSwitch()
		{
			include "db.php";
			$querystring = "SELECT * FROM valetview";
			$sql = $pdo->prepare($querystring);
			$sql->execute();
			
			echo "<table>
			<tr><th>Company Name</th><th>Address</th><th>Phone Number</th><th>Company Number</th>";
			while ($row = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$companyno = $row['company_number'];
				$address = $row['property_number'] . " " . $row['street'] . " " .  $row['city'] . " " .  $row['postcode'];
				$branchno = $row['BranchNumber'];
				$phonenno = $row['phone_number'];
				$companyname = $row['company_name'];
				
				echo "<tr><td>$companyname</td><td>$address</td><td>$phonenno</td><td>$companyno</td>";
				echo "<td><form method = \"post\"><button type = \"submit\" value = \"$companyno\" name = \"deleterecord\">Delete</button></form></td>";
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
				echo "<td><form method = \"post\"><button type = \"submit\" value = \"$advertno\" name = \"deleterecord\">Delete</button></form></td>";
			}
		echo "</table>";
		}
		
		function insertviewSwitch()
		{
			include "db.php";
			if(isset($_POST['settable']))
			{
				$_SESSION['addview'] = $_POST["settable"];
			
				header("Refresh:0");
				exit;
			}
			
			if (isset($_SESSION['addview']))
			{
				$addview = $_SESSION['addview'];
			}
			else
			{
				$addview = "adverts";
			}
			
			if(isset($_POST['setedit']))
			{
				switch($addview)
				{
					case "adverts":
					$sql = $pdo->prepare("SELECT advert_number FROM adverts WHERE advert_number = :advertno");
					$sql->execute(array(':advertno' => $_POST['advertno']));
					$succeed = False;
					while ($row = $sql->fetch(PDO::FETCH_ASSOC))
					{
						$succeed = True;
					}
					
					if ($succeed)
					{
						$sql = $pdo->prepare("UPDATE adverts SET CarVIN = :carvin, date_published = :datepublished, media_type = :mediatype WHERE advert_number = :advertno");
						$updated = $sql->execute(array(':carvin' => $_POST['carvin'], ':datepublished' => $_POST['datepublished'], ':mediatype' => $_POST['mediatype'], ':advertno' => $_POST['advertno']));
						if ($updated)
						{
							$_SESSION['feedbackmessage'] = "Record updated/added";
						}
						else
						{
							$_SESSION['feedbackmessage'] = "Invalid input";
						}
					}
					else
					{
						$sql = $pdo->prepare("INSERT INTO adverts (advert_number, CarVIN, date_published, media_type) VALUES (:advertno, :carvin, :datepublished, :mediatype)");
						$updated = $sql->execute(array(':advertno' => $_POST['advertno'], ':carvin' => $_POST['carvin'], ':datepublished' => $_POST['datepublished'], ':mediatype' => $_POST['mediatype']));
						if ($updated)
						{
							$_SESSION['feedbackmessage'] = "Record updated/added";
						}
						else
						{
							$_SESSION['feedbackmessage'] = "Invalid input";
						}
					}
					header("Refresh:0");
					exit;
					break;
					
					case "branch":
					
					$sql = $pdo->prepare("SELECT branch_number FROM branch WHERE branch_number = :branchno");
					$sql->execute(array(':branchno' => $_POST['branchno']));
					$succeed = False;
					while ($row = $sql->fetch(PDO::FETCH_ASSOC))
					{
						$succeed = True;
					}
					if ($succeed)
					{
						$sql = $pdo->prepare("UPDATE branch SET Manager_StaffNumber = :managerid WHERE branch_number = :branchno");
						$updated = $sql->execute(array(':managerid' => $_POST['managerid'], ':branchno' => $_POST['branchno']));
						
						$sql = $pdo->prepare("SELECT AddressID From Branch WHERE branch_number = :branchno");
						$sql->execute(array(':branchno' => $_POST['branchno']));
						$row = $sql->fetch(PDO::FETCH_ASSOC);
						$addressid = $row['AddressID'];
						
						$updated2 = updateaddress($addressid);
						
						if ($updated && $updated2)
						{
							$_SESSION['feedbackmessage'] = "Record updated/added";
						}
						else
						{
							$_SESSION['feedbackmessage'] = "Invalid input";
						}
					}
					else
					{					
						$updated = insertaddress();
						
						if($updated)
						{
							$sql = $pdo->prepare("INSERT INTO branch (branch_number, AddressID, Manager_StaffNumber) VALUES (:branchno, :addressid, :managerid)");
							$updated2 = $sql->execute(array(':branchno' => $_POST['branchno'], ':addressid' => $_SESSION['lastestaddressid'], ':managerid' => $_POST['managerid']));
							
							if ($updated2 == False)
							{
								deletelatestaddress();
							}
						}
						
						if ($updated && $updated2)
						{
							$_SESSION['feedbackmessage'] = "Record updated/added";
						}
						else
						{
							$_SESSION['feedbackmessage'] = "Invalid input";
						}
					}
					header("Refresh:0");
					exit;
					break;		

					case "car":
					if(isset($_POST['availability'])) 
					{ 
						$availability = 1;
					} 
					else
					{
						$availability = 0;
					}
					$sql = $pdo->prepare("SELECT VIN FROM car WHERE VIN = :vin");
					$sql->execute(array(':vin' => $_POST['vin']));
					$succeed = False;
					while ($row = $sql->fetch(PDO::FETCH_ASSOC))
					{
						$succeed = True;
					}
					
					if ($succeed)
					{
						$sql = $pdo->prepare("UPDATE car SET BranchNumber = ?, InsuranceNumber = ?, Supplier_CompanyNumber = ?, make = ?, model = ?, type = ?, transmission = ?, rent_per_day = ?, availability = b?, last_checkup = ?, colour = ?, registration_plate = ? WHERE VIN = ?");
						$updated = $sql->execute(array($_POST['branchno'], $_POST['insuranceno'], $_POST['supplierno'], $_POST['make'], $_POST['model'], $_POST['type'], $_POST['transmission'], $_POST['rent'], $availability, $_POST['lastcheckup'], $_POST['colour'], $_POST['regplate'], $_POST['vin']));
						if ($updated)
						{
							$_SESSION['feedbackmessage'] = "Record updated/added";
						}
						else
						{
							$_SESSION['feedbackmessage'] = "Invalid input";
						}
					}
					else
					{
						$sql = $pdo->prepare("INSERT INTO car (VIN, BranchNumber, InsuranceNumber, Supplier_CompanyNumber, make, model, type, transmission, rent_per_day, availability, last_checkup, colour, registration_plate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, b?, ?, ?, ?)");
						$updated = $sql->execute(array($_POST['vin'], $_POST['branchno'], $_POST['insuranceno'], $_POST['supplierno'], $_POST['make'], $_POST['model'], $_POST['type'], $_POST['transmission'], $_POST['rent'], $availability, $_POST['lastcheckup'], $_POST['colour'], $_POST['regplate']));
						if ($updated)
						{
							$_SESSION['feedbackmessage'] = "Record updated/added";
						}
						else
						{
							$_SESSION['feedbackmessage'] = "Invalid input";
						}
					}
					header("Refresh:0");
					exit;
					break;
					
					case "insurance":
					
					$sql = $pdo->prepare("SELECT insurance_number FROM insurance WHERE insurance_number = :insuranceno");
					$sql->execute(array(':insuranceno' => $_POST['insuranceno']));
					$succeed = False;
					while ($row = $sql->fetch(PDO::FETCH_ASSOC))
					{
						$succeed = True;
					}
					
					if ($succeed)
					{
						$sql = $pdo->prepare("UPDATE insurance SET provider = :insuranceprovider, insurance_type = :insurancetype WHERE insurance_number = :insuranceno");
						$updated = $sql->execute(array(':insuranceprovider' => $_POST['insuranceprovider'], ':insurancetype' => $_POST['insurancetype'], ':insuranceno' => $_POST['insuranceno']));
						if ($updated)
						{
							$_SESSION['feedbackmessage'] = "Record updated/added";
						}
						else
						{
							$_SESSION['feedbackmessage'] = "Invalid input";
						}
					}
					else
					{
						$sql = $pdo->prepare("INSERT INTO insurance (insurance_number, provider, insurance_type) VALUES (:insuranceno, :insuranceprovider, :insurancetype)");
						$updated = $sql->execute(array(':insuranceno' => $_POST['insuranceno'], ':insuranceprovider' => $_POST['insuranceprovider'], ':insurancetype' => $_POST['insurancetype']));
						if ($updated)
						{
							$_SESSION['feedbackmessage'] = "Record updated/added";
						}
						else
						{
							$_SESSION['feedbackmessage'] = "Invalid input";
						}
					}
					header("Refresh:0");
					exit;
					break;
					
					case "repair":
					$sql = $pdo->prepare("SELECT company_number FROM repair WHERE company_number = :companyno");
					$sql->execute(array(':companyno' => $_POST['companyno']));
					$succeed = False;
					while ($row = $sql->fetch(PDO::FETCH_ASSOC))
					{
						$succeed = True;
					}
					if ($succeed)
					{
						$sql = $pdo->prepare("UPDATE repair SET Branch_Number = :branchno, phone_number = :phoneno, company_name = :companyname WHERE company_number = :companyno");
						$updated = $sql->execute(array(':branchno' => $_POST['branchno'], ':phoneno' => $_POST['phoneno'], ':companyname' => $_POST['companyname'], ':companyno' => $_POST['companyno']));
						
						$sql = $pdo->prepare("SELECT Address_ID From repair WHERE company_number = :companyno");
						$sql->execute(array(':companyno' => $_POST['companyno']));
						$row = $sql->fetch(PDO::FETCH_ASSOC);
						$addressid = $row['Address_ID'];
						
						$updated2 = updateaddress($addressid);
						
						if ($updated && $updated2)
						{
							$_SESSION['feedbackmessage'] = "Record updated/added";
						}
						else
						{
							$_SESSION['feedbackmessage'] = "Invalid input";
						}
					}
					else
					{
						$updated = insertaddress();
						
						if($updated)
						{
							$sql = $pdo->prepare("INSERT INTO repair (Branch_Number, company_number, Address_ID, phone_number, company_name) VALUES (:branchno, :companyno, :addressid, :phoneno, :companyname)");
							$updated2 = $sql->execute(array(':branchno' => $_POST['branchno'], ':companyno' => $_POST['companyno'], ':addressid' => $_SESSION['lastestaddressid'], ':phoneno' => $_POST['phoneno'], ':companyname' => $_POST['companyname']));
							
							if ($updated2 == False)
							{
								deletelatestaddress();
							}
						}
						
						if ($updated && $updated2)
						{
							$_SESSION['feedbackmessage'] = "Record updated/added";
						}
						else
						{
							$_SESSION['feedbackmessage'] = "Invalid input";
						}
					}
					header("Refresh:0");
					exit;
					break;	
					
					case "staff":
					$sql = $pdo->prepare("SELECT email FROM userlistview WHERE email = :email");
					$sql->execute(array(':email' => $_POST['email']));
					$row = $sql->fetch(PDO::FETCH_ASSOC);
				
					if($row['email'] == $_POST['email'])
					{
						$_SESSION['feedbackmessage'] = "Email is already in use";
					}
					else
					{
						$sql = $pdo->prepare("SELECT staff_number FROM staff WHERE staff_number = :staffno");
						$sql->execute(array(':staffno' => $_POST['staffno']));
						$succeed = False;
						while ($row = $sql->fetch(PDO::FETCH_ASSOC))
						{
							$succeed = True;
						}
						if ($succeed)
						{
							$sql = $pdo->prepare("UPDATE staff SET BranchNumber = :branchno, first_name = :fname, last_name = :lname, sex = :sex, email = :email, phone_number = :phoneno, role = :role, salary = :salary, national_insurance_number = :nin WHERE staff_number = :staffno");
							$updated = $sql->execute(array(':branchno' => $_POST['branchno'], ':fname' => $_POST['fname'], ':lname' => $_POST['lname'], ':sex' => $_POST['sex'], ':email' => $_POST['email'], ':phoneno' => $_POST['phoneno'], ':role' => $_POST['role'], ':salary' => $_POST['salary'], ':nin' => $_POST['nin'], ':staffno' => $_POST['staffno']));
							
							$sql = $pdo->prepare("SELECT AddressID From staff WHERE staff_number = :staffno");
							$sql->execute(array(':staffno' => $_POST['staffno']));
							$row = $sql->fetch(PDO::FETCH_ASSOC);
							$addressid = $row['AddressID'];
							
							$updated2 = updateaddress($addressid);
							
							if ($updated && $updated2)
							{
								$_SESSION['feedbackmessage'] = "Record updated/added";
							}
							else
							{
								$_SESSION['feedbackmessage'] = "Invalid input";
							}
						}
						else
						{
							$updated = insertaddress();
							
							if($updated)
							{
								$sql = $pdo->prepare("INSERT INTO staff (staff_number, BranchNumber, AddressID, first_name, last_name, sex, email, phone_number, role, salary, national_insurance_number) VALUES (:staffno, :branchno, :addressid, :fname, :lname, :sex, :email, :phoneno, :role, :salary, :nin)");
								$updated2 = $sql->execute(array(':staffno' => $_POST['staffno'], ':branchno' => $_POST['branchno'], ':addressid' => $_SESSION['lastestaddressid'], ':fname' => $_POST['fname'], ':lname' => $_POST['lname'], ':sex' => $_POST['sex'], ':email' => $_POST['email'], ':phoneno' => $_POST['phoneno'], ':role' => $_POST['role'], ':salary' => $_POST['salary'], ':nin' => $_POST['nin']));
								
								if ($updated2 == False)
								{
									deletelatestaddress();
								}
							}
							
							if ($updated && $updated2)
							{
								$_SESSION['feedbackmessage'] = "Record updated/added";
							}
							else
							{
								$_SESSION['feedbackmessage'] = "Invalid input";
							}
						}
					}
					header("Refresh:0");
					exit;
					break;
					
					case "supplier":
					$sql = $pdo->prepare("SELECT company_number FROM supplier WHERE company_number = :companyno");
					$sql->execute(array(':companyno' => $_POST['companyno']));
					$succeed = False;
					while ($row = $sql->fetch(PDO::FETCH_ASSOC))
					{
						$succeed = True;
					}
					if ($succeed)
					{
						$sql = $pdo->prepare("UPDATE supplier SET phone_number = :phoneno, company_name = :companyname, contract_number = :contractno WHERE company_number = :companyno");
						$updated = $sql->execute(array(':phoneno' => $_POST['phoneno'], ':companyname' => $_POST['companyname'], ':contractno' => $_POST['contractno'], ':companyno' => $_POST['companyno']));
						
						$sql = $pdo->prepare("SELECT AddressID From supplier WHERE company_number = :companyno");
						$sql->execute(array(':companyno' => $_POST['companyno']));
						$row = $sql->fetch(PDO::FETCH_ASSOC);
						$addressid = $row['AddressID'];
						
						$updated2 = updateaddress($addressid);
						
						if ($updated && $updated2)
						{
							$_SESSION['feedbackmessage'] = "Record updated/added";
						}
						else
						{
							$_SESSION['feedbackmessage'] = "Invalid input";
						}
					}
					else
					{					
						$updated = insertaddress();
						
						if($updated)
						{
							$sql = $pdo->prepare("INSERT INTO supplier (company_number, AddressID, phone_number, company_name, contract_number) VALUES (:companyno, :addressid, :phoneno, :companyname, :contractno)");
							$updated2 = $sql->execute(array(':companyno' => $_POST['companyno'], ':addressid' => $_SESSION['lastestaddressid'], ':phoneno' => $_POST['phoneno'], ':companyname' => $_POST['companyname'], ':contractno' => $_POST['contractno']));
							
							if ($updated2 == False)
							{
								deletelatestaddress();
							}
						}
						
						if ($updated && $updated2)
						{
							$_SESSION['feedbackmessage'] = "Record updated/added";
						}
						else
						{
							$_SESSION['feedbackmessage'] = "Invalid input";
						}
					}
					header("Refresh:0");
					exit;
					break;
					
					case "valet":
					$sql = $pdo->prepare("SELECT company_number FROM valet WHERE company_number = :companyno");
					$sql->execute(array(':companyno' => $_POST['companyno']));
					$succeed = False;
					while ($row = $sql->fetch(PDO::FETCH_ASSOC))
					{
						$succeed = True;
					}
					if ($succeed)
					{
						$sql = $pdo->prepare("UPDATE valet SET BranchNumber = :branchno, phone_number = :phoneno, company_name = :companyname WHERE company_number = :companyno");
						$updated = $sql->execute(array(':branchno' => $_POST['branchno'], ':phoneno' => $_POST['phoneno'], ':companyname' => $_POST['companyname'], ':companyno' => $_POST['companyno']));
						
						$sql = $pdo->prepare("SELECT Address_ID From valet WHERE company_number = :companyno");
						$sql->execute(array(':companyno' => $_POST['companyno']));
						$row = $sql->fetch(PDO::FETCH_ASSOC);
						$addressid = $row['Address_ID'];
						
						$updated2 = updateaddress($addressid);
						
						if ($updated && $updated2)
						{
							$_SESSION['feedbackmessage'] = "Record updated/added";
						}
						else
						{
							$_SESSION['feedbackmessage'] = "Invalid input";
						}
					}
					else
					{
						$updated = insertaddress();
						
						if($updated)
						{
							$sql = $pdo->prepare("INSERT INTO valet (BranchNumber, company_number, Address_ID, phone_number, company_name) VALUES (:branchno, :companyno, :addressid, :phoneno, :companyname)");
							
							$updated2 = $sql->execute(array(':branchno' => $_POST['branchno'], ':companyno' => $_POST['companyno'], ':addressid' => $_SESSION['lastestaddressid'], ':phoneno' => $_POST['phoneno'], ':companyname' => $_POST['companyname']));
							
							if ($updated2 == False)
							{
								deletelatestaddress();
							}
						}
						
						if ($updated && $updated2)
						{
							$_SESSION['feedbackmessage'] = "Record updated/added";
						}
						else
						{
							$_SESSION['feedbackmessage'] = "Invalid input";
						}
					}
					header("Refresh:0");
					exit;
					break;	
				}
			}
			
			switch($addview)
			{
				case "adverts":
						echo "	<table>
							<tr><td>Advert Number</td><td>Car VIN</td><td>Date Published</td><td>Media Type</td>
							<form method = \"post\">
								<tr>
								<td><input type=\"text\" required name=\"advertno\"></td>
								<td><input type=\"text\" required name=\"carvin\"></td>
								<td><input type=\"date\" required name=\"datepublished\"></td>
								<td><input type=\"text\" required name=\"mediatype\"></td>
								<td><button type = \"submit\" name = \"setedit\">Confirm</button></td>
							</form>
						</table>";
				
						break;			
				case "branch":
						echo "	<table>
							<tr><td>Branch Number</td><td>Property Number</td><td>Street</td><td>City</td><td>Postcode</td><td>Manager Number</td>
							<form method = \"post\">
								<tr>
								<td><input type=\"text\" required name=\"branchno\"></td>
								<td><input type=\"text\" required name=\"propertyno\"></td>
								<td><input type=\"text\" required name=\"street\"></td>
								<td><input type=\"text\" required name=\"city\"></td>
								<td><input type=\"text\" required name=\"postcode\"></td>
								<td><input type=\"text\" required name=\"managerid\"></td>
								<td><button type = \"submit\" name = \"setedit\">Confirm</button></td>
							</form>
						</table>";
				
						break;	
				case "car":
						echo "	<table>
							<tr><td>Vehicle Identification Number</td><td>Branch Number</td><td>Insurance Number</td><td>Supplier Number</td><td>Make</td><td>Model</td><td>Type</td><td>Transmission</td><td>Daily Rent</td>
							<form method = \"post\">
								<tr>
								<td><input type=\"text\" required name=\"vin\"></td>
								<td><input type=\"text\" required name=\"branchno\"></td>
								<td><input type=\"text\" required name=\"insuranceno\"></td>
								<td><input type=\"text\" required name=\"supplierno\"></td>
								<td><input type=\"text\" required name=\"make\"></td>
								<td><input type=\"text\" required name=\"model\"></td>
								<td><input type=\"text\" required name=\"type\"></td>
								<td><input type=\"text\" required name=\"transmission\"></td>
								<td><input type=\"text\" required name=\"rent\"></td>
								<tr>
								<td>Available</td><td>Last Checkup</td><td>Colour</td><td>Registration Plate</td>
								<tr>
								<td><input type=\"checkbox\" name=\"availability\"></td>
								<td><input type=\"date\" name=\"lastcheckup\"></td>
								<td><input type=\"text\" name=\"colour\"></td>
								<td><input type=\"text\" name=\"regplate\"></td>
								<td><button type = \"submit\" name = \"setedit\">Confirm</button></td>
							</form>
						</table>";
				
						break;		
				case "insurance":
						echo "	<table>
							<tr><td>Insurance Number</td><td>Insurance Provider</td><td>Insurance Type</td>
							<form method = \"post\">
								<tr>
								<td><input type=\"text\" name=\"insuranceno\"></td>
								<td><input type=\"text\" name=\"insuranceprovider\"></td>
								<td><input type=\"text\" name=\"insurancetype\"></td>
								<td><button type = \"submit\" name = \"setedit\">Confirm</button></td>
							</form>
						</table>";
				
						break;		
				case "repair":
						echo "	<table>
							<tr><td>Company Number</td><td>Property Number</td><td>Street</td><td>City</td><td>Postcode</td><td>Branch Number</td><td>Phone Number</td><td>Company Name</td>
							<form method = \"post\">
								<tr>
								<td><input type=\"text\" name=\"companyno\"></td>
								<td><input type=\"text\" name=\"propertyno\"></td>
								<td><input type=\"text\" name=\"street\"></td>
								<td><input type=\"text\" name=\"city\"></td>
								<td><input type=\"text\" name=\"postcode\"></td>
								<td><input type=\"text\" name=\"branchno\"></td>
								<td><input type=\"text\" name=\"phoneno\"></td>
								<td><input type=\"text\" name=\"companyname\"></td>
								<td><button type = \"submit\" name = \"setedit\">Confirm</button></td>
							</form>
						</table>";
				
						break;	
				case "staff":
						echo "	<table>
							<tr><td>Staff Number</td><td>Branch Number</td><td>Property Number</td><td>Street</td><td>City</td><td>Postcode</td><td>First Name</td><td>Last Name</td><td>Sex</td>
							<form method = \"post\">
								<tr>
								<td><input type=\"text\" name=\"staffno\"></td>
								<td><input type=\"text\" name=\"branchno\"></td>
								<td><input type=\"text\" name=\"propertyno\"></td>
								<td><input type=\"text\" name=\"street\"></td>
								<td><input type=\"text\" name=\"city\"></td>
								<td><input type=\"text\" name=\"postcode\"></td>
								<td><input type=\"text\" name=\"fname\"></td>
								<td><input type=\"text\" name=\"lname\"></td>
								<td><input type=\"text\" name=\"sex\"></td>
								<tr>
								<td>Email</td><td>Phone Number</td><td>Role</td><td>Salary</td><td>National Insurance Number</td>
								<tr>
								<td><input type=\"email\" name=\"email\"></td>
								<td><input type=\"text\" name=\"phoneno\"></td>
								<td><input type=\"text\" name=\"role\"></td>
								<td><input type=\"text\" name=\"salary\"></td>
								<td><input type=\"text\" name=\"nin\"></td>
								<td><button type = \"submit\" name = \"setedit\">Confirm</button></td>
							</form>
						</table>";
				
						break;	
				case "supplier":
						echo "	<table>
							<tr><td>Company Number</td><td>Property Number</td><td>Street</td><td>City</td><td>Postcode</td><td>Phone Number</td><td>Company Name</td><td>Contract Number</td>
							<form method = \"post\">
								<tr>
								<td><input type=\"text\" name=\"companyno\"></td>
								<td><input type=\"text\" name=\"propertyno\"></td>
								<td><input type=\"text\" name=\"street\"></td>
								<td><input type=\"text\" name=\"city\"></td>
								<td><input type=\"text\" name=\"postcode\"></td>
								<td><input type=\"text\" name=\"phoneno\"></td>
								<td><input type=\"text\" name=\"companyname\"></td>
								<td><input type=\"text\" name=\"contractno\"></td>
								<td><button type = \"submit\" name = \"setedit\">Confirm</button></td>
							</form>
						</table>";
				
						break;	
	
				case "valet":		
						echo "	<table>
							<tr><td>Company Number</td><td>Property Number</td><td>Street</td><td>City</td><td>Postcode</td><td>Branch Number</td><td>Phone Number</td><td>Company Name</td>
							<form method = \"post\">
								<tr>
								<td><input type=\"text\" name=\"companyno\"></td>
								<td><input type=\"text\" name=\"propertyno\"></td>
								<td><input type=\"text\" name=\"street\"></td>
								<td><input type=\"text\" name=\"city\"></td>
								<td><input type=\"text\" name=\"postcode\"></td>
								<td><input type=\"text\" name=\"branchno\"></td>
								<td><input type=\"text\" name=\"phoneno\"></td>
								<td><input type=\"text\" name=\"companyname\"></td>
								<td><button type = \"submit\" name = \"setedit\">Confirm</button></td>
							</form>
						</table>";
				
						break;								
			}
						echo "<div class='sidesearchexec'> ";
			echo "	<form method = \"post\">
					<select name=\"settable\">
					<option value=\"adverts\">Advert</option>
					<option value=\"branch\">Branch</option>
					<option value=\"car\">Car</option>
					<option value=\"insurance\">Insurance</option>
					<option value=\"repair\">Repair</option>
					<option value=\"staff\">Staff</option>
					<option value=\"supplier\">Supplier</option>
					<option value=\"valet\">Valet</option>
					</select>
					<input type=\"submit\" name=\"submit\" value=\"Change record\" />					
					</form>";
					echo"</div>";
		}
		
		function getnextaddressid()
		{
			include "db.php";
			$querystring = "SELECT address_id FROM address order by address_id DESC"; 
			$sql = $pdo->prepare($querystring);
			$sql->execute();
			$row = $sql->fetch(PDO::FETCH_ASSOC);
			$latest = $row['address_id'];
			$latest = ltrim($latest, "A");
			$latest = $latest + 1;
			$latest = "A" . sprintf("%09d", $latest);
			$_SESSION['lastestaddressid'] = $latest;
			return $latest;
		}
		
		function updateaddress($addressid)
		{
			include "db.php";
			$sql = $pdo->prepare("UPDATE address SET property_number = :propertyno, street = :street, city = :city, postcode = :postcode WHERE address_id = :addressid");
			$updated = $sql->execute(array(':propertyno' => $_POST['propertyno'], ':street' => $_POST['street'], ':city' => $_POST['city'], ':postcode' => $_POST['postcode'], ':addressid' => $addressid));
			return $updated;
		}
		
		function insertaddress()
		{
			include "db.php";
			$addressid = getnextaddressid();
			$sql = $pdo->prepare("INSERT INTO address (address_id, property_number, street, city, postcode) VALUES (:addressid, :propertyno, :street, :city, :postcode)");
			$updated = $sql->execute(array(':addressid' => $addressid, ':propertyno' => $_POST['propertyno'], ':street' => $_POST['street'], ':city' => $_POST['city'], ':postcode' => $_POST['postcode']));
			return $updated;
		}
		
		function deletelatestaddress()
		{
			include "db.php";
			$sql = $pdo->prepare("DELETE FROM address WHERE address_id = :addressid");
			$sql->execute(array(':addressid' => $_SESSION['lastestaddressid']));
		}
		?> 
</body>
</html>