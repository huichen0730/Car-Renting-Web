<html>
<body>
      <head>			 
	<div class="h1"> 
        <title>Murray Motors</title>
        <link href="ooftprofile.css" rel="stylesheet" type="text/css">   
            <div class="row">
                <ul class="main-nav">
					<li class="active"><a href="index.php"> HOME </a></li>
	
					
		<?php
		include ("db.php");
		session_start();
		if (!isset($_SESSION['useremail']))
		{
					echo
					'<form method = post>
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
			$sql = $pdo->prepare("SELECT first_name, role FROM userlistview WHERE email = :email");
			$sql->execute(array(':email' => $_SESSION['useremail']));
			$row = $sql->fetch(PDO::FETCH_ASSOC);
			$fname = $row['first_name'];
			
			switch ($row['role'])
			{
				case "Sales":
				header("Location: staffview.php");
				break;
				
				case "Branch Manager":
				header("Location: managerview.php");
				break;
				
				case "Executive":
				header("Location: executiveview.php");
				break;
			}
		
			//greeting message
		echo "	<div class='phpgreeting'> ";
		echo '<p> Hello ' . $fname . '!</p>';
		echo " </div> ";
		
		  
			//logout button
			echo "<div class='phplogout'>";
			echo '<form method = post><button name="logout">Logout</form>';
			echo "</div>";
			
			//profile button
			echo "<div class='phpprofiles'>";
			echo '<form method = post><button name="profile">Profile</form>';
			echo "</div>";
		}
		
			if (isset($_SESSION['feedbackmessage']) && $_SESSION['feedbackmessage'] != "")
			{
				$message = $_SESSION['feedbackmessage'];
				echo "  <div class='feedbackmessage'>
						<p>$message</p>	
						</div>"	;
				$_SESSION['feedbackmessage'] = "";
			}
			else
			{
				echo " <div class='feedbackmessage'>
						<p>Profile Page</p>
						</div>" ;
			
			}
		?>
		
			
		
                </ul>         
			</div>
		</div>
			<div class="logo">
      <img src="Images/Murraymotors.png">
	</div>
		
		<?php
		ob_start();
		
		if ($_SESSION['userview'] != "customer")
		{
			header("Location: index.php");
			exit;
		}
		
		customerprofile();
		
		function customerprofile()
		{
			include "db.php";
			echo "<div class='personal_profile'>";
			echo "</div>";
			
			$querystring = "SELECT * FROM customerview WHERE email = '" . $_SESSION['useremail'] . "'";
			$sql = $pdo->prepare($querystring);
			$sql->execute();
			echo "<table>
			<tr><th>First Name</th><th>Last Name</th><th>Address</th><th>Email</th><th>Phone Number</th><th>Membership</th><th>License Number</th>";
			while ($row = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$fname = $row['first_name'];
				$lname = $row['last_name'];
				$address = $row['property_number'] . " " . $row['street'] . " " . $row['city'] . " " . $row['postcode'];
				$email = $row['email'];
				$phone = $row['phone_number'];
				$membership = $row['membership'];
				$licenseno = $row['license_number'];
				$make = $row['make'];
				$model = $row['model'];
				$type = $row['type'];
				$transmission = $row['transmission'];
				
				echo "<tr><td>$fname</td><td>$lname</td><td>$address</td><td>$email</td><td>$phone</td><td>$membership</td><td>$licenseno</td> <tr>
				<th>Preferred Make</th><th>Preferred Model</th><th>Preferred Type</th><th>Preferred Transmission</th> <tr> <td>$make</td><td>$model</td><td>$type</td><td>$transmission</td>
				<td><form method = post><button name='edit'>Edit</button></form></td>";
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
						<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone Number</th><th>License Number</th>
						<form method = \"post\">
						<tr>
						<td><input type=\"text\" required name=\"fname\"></td>
						<td><input type=\"text\" required name=\"lname\"></td>
						<td><input type=\"email\" required name=\"email\"></td>
						<td><input type=\"text\" required name=\"phoneno\"></td>
						<td><input type=\"text\" required name=\"licenseno\"></td>
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
						<table id='editpref'>
						<tr><th>Preferred Make</th><th>Preferred Model</th><th>Preferred Type</th><th>Preferred Transmission</th>
						<form method = \"post\">
						<tr>
						<td><input type=\"text\"  name=\"make\"></td>
						<td><input type=\"text\"  name=\"model\"></td>
						<td><input type=\"text\"  name=\"type\"></td>
						<td><input type=\"text\"  name=\"transmission\"></td>
						<td><button type = \"submit\" name = \"editpreferences\">Confirm</button></td>
						</form>
						</table>
						";
		}
		}
				
		?>
		
	
		
		<?php
			//when the user log out, redirect to home page before sign in
			if (isset($_POST["logout"]))
			{
				session_unset();
				header("Location:index.php");
				exit;
			}
			
			if (isset($_POST['edit']))
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
			
			//update record
			if (isset($_POST["editpersonal"]))
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
					$sql = $pdo->prepare("UPDATE customer SET  first_name = :fname, last_name = :lname, email= :email, phone_number = :phoneno, license_number= :licenseno WHERE email = :curremail");
					$updated = $sql->execute(array(':fname' => $_POST['fname'], ':lname' => $_POST['lname'], ':email' => $_POST['email'], ':phoneno' => $_POST['phoneno'], ':licenseno' => $_POST['licenseno'], ':curremail' => $curremail));
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
			//update customer address
			if (isset($_POST["editaddress"]))
			{
				$curremail = $_SESSION['useremail'];
				$sql = $pdo->prepare("SELECT Address_ID FROM userlistview WHERE email = :email");
				$sql->execute(array(':email' => $curremail));
				$row = $sql->fetch(PDO::FETCH_ASSOC);
				
				$addressid = $row['Address_ID'];
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
			//update preferences
			if (isset($_POST["editpreferences"]))
			{
				$curremail = $_SESSION['useremail'];
				$sql = $pdo->prepare("SELECT customer_number FROM userlistview WHERE email = :email");
				$sql->execute(array(':email' => $curremail));
				$row = $sql->fetch(PDO::FETCH_ASSOC);
				
				$customerno = $row['customer_number'];
				$sql = $pdo->prepare("UPDATE preferences SET make = :make, model = :model, type = :type, transmission = :transmission WHERE customer_number = :customerno");
				$updated = $sql->execute(array(':make' => $_POST['make'], ':model' => $_POST['model'], ':type' => $_POST['type'], ':transmission' => $_POST['transmission'], ':customerno' => $customerno));
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
	
?> 
		
		
		
		
		</body>


</html>
