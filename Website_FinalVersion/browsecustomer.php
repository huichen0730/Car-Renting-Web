<html> 

        <link href="stylesheet.css" rel="stylesheet" type="text/css">  
	<head> 	
		<div class="h1"> 
        <title>Murray Motors</title> 
            <div class="row">
                <ul class="main-nav">
					<li class="active"><a href="index.php"> HOME </a></li>
	
					
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
			$sql = $pdo->prepare("SELECT first_name FROM customer WHERE email = :email");
			$sql->execute(array(':email' => $_SESSION['useremail']));
			$row = $sql->fetch(PDO::FETCH_ASSOC);
			$fname = $row['first_name'];
		
			//greeting message
		echo "	<div class='phpgreeting'> ";
		echo '<p> Hello ' . $fname . '!</p>';
		echo " </div> ";
		
		  
			//logout button
			echo "<div class='phplogout'>";
			echo '<form method = post><button name="logout">Logout</form>';
			echo "</div>";
			
			//profile button
			echo "<div class='phpprofile'>";
			echo '<form method = post><button name="profile">Profile</form>';
			echo "</div>";
		}
		
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
						<p>Cheap rentals are just a click away!</p>
						</div> ";
			}
		?>
		
			
		
                </ul>         
			</div>
		</div>
	
	                <div class="logo">
                    <img src="Images/Murraymotors.png">
					</div>
	</head> 
	<body> 

		
		<div class="butbar">		
			<form method = "post">
				<br>Make<br>
				<select type = "radio" name="make">
					<option value="none">No preference</option>
					<option value="Audi">Audi</option>
					<option value="BMW">BMW</option>
					<option value="Ford">Ford</option>
					<option value="Honda">Honda</option>
					<option value="Kia">Kia</option>
					<option value="Range Rover">Range Rover</option>
					<option value="Rolls Royce">Rolls Royce</option>
					<option value="Tesla">Tesla</option>
					<option value="Volvo">Volvo</option>
					<option value="VW">VW</option>				
				</select>
				
				<br><br>Location<br>
				<select type = "radio" name="BranchNumber">
					<option value="Dundee">Dundee</option>
					<option value="Edinburgh">Edinburgh</option>
					<option value="Manchester">Manchester</option>
					<option value="Belfast">Belfast</option>
					<option value="London">London</option>
				</select>
				
				<br><br>Car Type<br>
				<select type = "radio" name="type">
					<option value="none">No preference</option>
					<option value="Hatchback">Hatchback</option>
					<option value="Sedan">Sedan</option>
					<option value="SUV">SUV</option>
					<option value="Luxury">Luxury</option>
				</select>
				
				<br><br>Transmission<br>
				<input type = "radio" name = "transmission" value = "none" checked>No preference<br>
				<input type = "radio" name = "transmission" value = "Auto">Automatic<br>
				<input type = "radio" name = "transmission" value = "Manual">Manual<br>
				
				<br>Order by<br>
				<input type = "radio" name = "priceorder" value = "asc" checked>Ascending Price<br>
				<input type = "radio" name = "priceorder" value = "desc">Descending Price<br>
				
				<br>Pickup Dates<br>
				Rent from:<br>
				<input type = "date" name = "startdate"><br>
				Until:<br>
				<input type = "date" name = "enddate">
				<br><br>
				
				<button type = "submit" name = "carsearch" >Search</button>		
				<br><br>

		
			</form>
		</div>
		
		<div id = "data">
		<?php  
		include "db.php"; 
		
		if (!isset($_SESSION['startdate']) && !isset($_SESSION['enddate']))
		{
			header("Location: index.php");
			exit;
		}
		
		$startdate = $_SESSION['startdate'];
		$enddate = $_SESSION['enddate'];
		
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
		if (isset($_SESSION['locpref']))
		{
			$locpref = $_SESSION['locpref'];
		}
		else
		{
			$locpref = "none";
		}
		if (isset($_SESSION['orderpref']))
		{
			$orderpref = $_SESSION['orderpref'];
		}
		else
		{
			$orderpref = "asc";
		}			
		if (isset($_SESSION['daysrent']))
		{
			$daysrent = $_SESSION['daysrent'];
		}
		else
		{
			$daysrent = 1;
		}	
		
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
	else if (isset($_POST['Register']))
	{
		$_SESSION['redirect'] = "browse";
		Header("Location: registerpage.php");
		exit;
	}
		else if (isset($_POST["logout"]))
		{
			unset($_SESSION['useremail']);
			header("Refresh:0");
			exit;
		}
		else if (isset($_POST['profile']))
		{
			Header("Location: profile.php");
			exit;
		}
		else if (isset($_POST["carsearch"]))
		{
			$_SESSION['makepref'] = $_POST["make"];
			$_SESSION['typepref'] = $_POST["type"];
			$_SESSION['transpref'] = $_POST["transmission"];
			$_SESSION['locpref'] = $_POST["BranchNumber"];
			$_SESSION['orderpref'] = $_POST["priceorder"];
			
			$today = date("Y-m-d");
			if (!empty($_POST["startdate"]) and !empty($_POST["enddate"]) and ($_POST["startdate"]) <= ($_POST["enddate"]) and ($_POST["startdate"]) >= $today)
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
			}
			else
			{
				$_SESSION['feedbackmessage'] = "Invalid date, displaying cars available between " . $_SESSION['startdate']->format('d M') . " and " . $_SESSION['enddate']->format('d M');
			}
			
			header("Location: browsecustomer.php");
			exit;
		}
		else if (isset($_POST["rentcar"]))
		{
			$_SESSION['rentvin'] = $_POST["rentcar"];
			
			header("Location: purchase.php");
			exit;
		}
		$querystring = "SELECT * FROM carbrowseview WHERE availability = True";
		if ($makepref != "none")
		{
			$querystring = $querystring . " and make = '" . $makepref . "'";
		}
		if ($typepref != "none")
		{
			$querystring = $querystring . " and type = '" . $typepref . "'";
		}
		if ($transpref != "none")
		{
			$querystring = $querystring . " and transmission = '" . $transpref . "'";
		}		
		if ($locpref != "none")
		{
			$querystring = $querystring . " and city LIKE '%" . $locpref . "%'";
		}
		if ($orderpref == "asc")
		{
			$querystring = $querystring . " ORDER BY rent_per_day ASC";
		}
		else
		{
			$querystring = $querystring . " ORDER BY rent_per_day DESC";
		}
		$sql = $pdo->prepare($querystring);
		echo "<table>";
		$sql->execute();
		if ($sql->rowCount() > 0)
		{
			while ($row = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$vin = $row['VIN'];
				$make = $row['make'];
				$model = $row['model'];
				$type = $row['type'];
				$transmission = $row['transmission'];
				$rent = $row['rent_per_day'] * $daysrent;
				echo "<table id='cars'><tr><td>
					<ul id='info'>
						<li><b>Make:</b> &nbsp $make</li>
						<li><br><b>Model:</b> &nbsp $model</li>
						<li><br><b>Type:</b> &nbsp $type</li>
						<li><br><b>Transmission:</b> &nbsp $transmission</li>
						<li><br><b>Rent price:</b> &nbsp £$rent</li>
						<li><br><p align='right'><form id='rent' method = \"post\"><button type = \"submit\" value = \"$vin\" name = \"rentcar\">Rent Now!</button></form></p></li>
					</ul></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
					<td><p><img id='carimage' src='Cars/$model.jpg' alt='Picture of a $model'</p></td></tr>";
			}
		}
		else
		{
			echo "No cars found. Please try a broader search!";
		}
		echo "</table>";
		?> 
		</div>
	</body>
</html>