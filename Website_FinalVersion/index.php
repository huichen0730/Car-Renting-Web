<html>
<body>
      <head>			 
	<div class="h1"> 
        <title>Murray Motors</title>
        <link href="stylesheet.css" rel="stylesheet" type="text/css">   
            <div class="row">
                <ul class="main-nav">
	
					
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
				echo " <div class='feedbackmessage'>
						<p>$message</p>	
						</div>"	;
				$_SESSION['feedbackmessage'] = "";
			}
			else
			{
				echo " <div class='feedbackmessage'>
						<p>Welcome to Murray Motors!</p>
						</div>" ;
			
			}
		?>
		
			
		
                </ul>         
			</div>
		</div>
	<div class="logo">
      <img src="Images/Murraymotors.png">
	</div>
	</head>
		<div class = "booking-page">
				<img src="Images/hirecar.jpg" class="hire-cars">
					<h1>Cheap Car Rentals Are Just a Click Away!</h1><br>
					<form method = "post">
						<p>Pick-up/Return Location <br></p>
						<select name="city">
						  <option value="Dundee">Dundee</option>
						  <option value="Edinburgh">Edinburgh</option>
						  <option value="Belfast">Belfast</option>
						  <option value="Manchester">Manchester</option>
						  <option value="London">London</option>
						</select>
						<p><br>Pick-up Date</p>
						<input type="date" name="startdate" required placeholder="Enter the Date for Pick-up"><br>
						<p>Return Date</p>
						<input type="date" name="enddate" required placeholder="Enter the Date for Pick-up"><br>
						<input type="submit" name="searchcars" value="Search Now">
						<input type="reset" name="reset-button" value="Reset">	
					</form>
			</div>	
			
			<div class = "paragraphs">
			<p><br> 
			Murray Motors is a car rental company that <br> operates throughout the UK and Ireland, <br>
			with a wide range of vehicles for customers to choose from.<br>
			Every car is insured and regularly maintained.<br>
			<br>
			The main branches are in Dundee, Edinburgh, Belfast, <br> Manchester and London,
			allowing customers to <br> rent out a vehicle from one of many branches <br> with ease and at an affordable cost.  <br>
			</p>
		
			</div>
	
	
			
		<?php
	include ("db.php");
	$useremail = "";
	$userpass = "";
	

	
	if (isset($_POST["login"]))
	{
		if (!empty($_POST["useremail"]))
		{
			$useremail = $_POST["useremail"];
		}
		
		if (!empty($_POST["userpass"]))
		{
			$userpass = $_POST["userpass"];
		}
		
		$sql = $pdo->prepare("SELECT * FROM userlistview WHERE email= :useremail");
		$sql->execute(array(':useremail' => $useremail));
		$row = $sql->fetch(PDO::FETCH_ASSOC);
		
		if (password_verify($userpass, $row['password']))
		{
			$_SESSION['useremail'] = $useremail;
			
			switch ($row['role'])
			{
			
				case "Sales":
				$_SESSION['userview'] = "staff";
				header("Location: staffview.php");
				exit;
				
				case "Branch Manager":
				$_SESSION['userview'] = "manager";
				header("Location: managerview.php");
				exit;
				
				case "Executive":
				$_SESSION['userview'] = "executive";
				header("Location: executiveview.php");
				exit;
				
				default:
				$_SESSION['userview'] = "customer";
				header("Refresh:0");
				exit;
			}
		}
		else
		{
			
			$_SESSION['feedbackmessage'] = "Username and/or password incorrect";
			header("Refresh:0");
			exit;
		}
	}
	else if (isset($_POST["logout"]))
	{
		session_unset();
		header("Refresh:0");
		exit;
	}
	else if (isset($_POST['searchcars']))
	{
			$today = date("Y-m-d");
			if (($_POST["startdate"]) <= ($_POST["enddate"]) and ($_POST["startdate"]) >= $today)
			{
				$startdate = new DateTime($_POST["startdate"]);
				$enddate = new DateTime($_POST["enddate"]);
				$daysrent = $startdate->diff($enddate)->format('%R%a days');
				$daysrent = ltrim($daysrent, '+');
				$daysrent = rtrim($daysrent, ' days');
				$daysrent = (int)$daysrent;
				$_SESSION['startdate'] = $startdate;
				$_SESSION['enddate'] = $enddate;
				$_SESSION['daysrent'] = $daysrent;
				$_SESSION['locpref'] = $_POST['city'];
				$_SESSION['userview'] = "customer";
				
				header("Location: browsecustomer.php");
				exit;
			}
			else
			{
				$_SESSION['feedbackmessage'] = "Invalid date range";
			}
	}
	else if (isset($_POST['Register']))
	{
		$_SESSION['redirect'] = "index";
		Header("Location: registerpage.php");
		exit;
	}
	
	else if (isset($_POST['profile']))
	{
		Header("Location: profile.php");
		exit;
	}
?> 
		</div>
		
		</body>


</html>

