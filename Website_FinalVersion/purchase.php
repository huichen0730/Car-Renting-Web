<html>
     <head>			 
	<div class="h1"> 
        <title>Murray Motors</title>
        <link href="stylesheet2.css" rel="stylesheet" type="text/css"> 
            <div class="row">
                <ul class="main-nav">
				<div class="topbut">
                    <li><a href="index.php"> HOME </a></li>
				</div>
					
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
		echo "	<div class='phpgreeting'> ";
			//greeting message
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
				echo "  <div class='feedbackmessagep'>
						<p>$message</p>	
						</div>"	;
				$_SESSION['feedbackmessage'] = "";
			}
			else
			{
				echo " <div class='feedbackmessagep'>
						<p>Just one more step!</p>
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
	<body>
		<div class="Form">
		
		   
</div>
			
			
	<?php
		ob_start();
		include "db.php"; 
		
		if (isset($_SESSION['rentvin']))
		{
			$vin = $_SESSION['rentvin'];
			
			if (!isset($_SESSION['useremail']))
			{
				header("Location: logincreate.php");
				exit;
			}
		}
		else
		{
			header("Location: index.php");
			exit;
		}
		
		if(isset($_SESSION['purchasemade']) && $_SESSION['purchasemade'] == True)
		{
			foreach($_SESSION as $name => $val)
			{
				if ($name !== 'useremail')
				{
				  unset($_SESSION[$name]);
				}
			}
		}
		
		$vin = $_SESSION['rentvin'];
		$querystring = "SELECT * FROM carbrowseview WHERE VIN = '" . $vin . "'";
		$sql = $pdo->prepare($querystring);
		$sql->execute();
		$row = $sql->fetch(PDO::FETCH_ASSOC);
		$rent = $_SESSION['daysrent'] * $row['rent_per_day'];
		
		if (isset($_POST['confirmrent']))
		{
			$cardname = $_POST['cardname'];
			$cardnamevalid = preg_match("/([^a-zA-Z]+)/i", $cardname);
			$cardno = (int)filter_var($_POST['cardno'], FILTER_SANITIZE_NUMBER_INT);
			$expireyear = $_POST['cardexpireyear'];
			$expiremonth = $_POST['cardexpiremonth'];
			$securityno = (int)filter_var($_POST['cardsecurityno'], FILTER_SANITIZE_NUMBER_INT);
			
			if ($cardnamevalid || strlen((string)$cardno) != 16 || strlen((string)$securityno) != 3 || date('Y') == $expireyear && ((int)(date('m')) >= ((int)($expiremonth))))
			{
				$_SESSION['feedbackmessage'] = "Invalid card details.";
			}
			else
			{
				$querystring = "SELECT customer_number FROM customer WHERE email = '" . $_SESSION['useremail'] . "'";
				$sql = $pdo->prepare($querystring);
				$sql->execute();
				$row = $sql->fetch(PDO::FETCH_ASSOC);
				
				$customerno = $row['customer_number'];
				$leaseno = getnextleaseno();
				$vin = $_SESSION['rentvin'];
				$startdate = $_SESSION['startdate']->format('Y-m-d');
				$enddate = $_SESSION['enddate']->format('Y-m-d');
				
				$querystring = "INSERT INTO lease (lease_number, CustomerNumber, CarVIN, start_date, end_date, total_rent) VALUES ('" . $leaseno . "', '" . $customerno . "', '" . $vin . "', '" . $startdate . "', '" . $enddate . "', '" . $rent . "')";
				$sql = $pdo->prepare($querystring);
				$success = $sql->execute();
				
				if ($success)
				{
					$querystring = "UPDATE car SET availability = 0 WHERE VIN = '" . $vin . "'";
					$sql = $pdo->prepare($querystring);
					$updated = $sql->execute();
					
					if ($updated)
					{
						$_SESSION['feedbackmessage'] = "Purchase successful!";
						$_SESSION['purchasemade'] = True;
						header("Location: index.php");
						exit;
					}
					else
					{
						$_SESSION['feedbackmessage'] = "Something went wrong!";
					}
				}
			}
			header("Refresh:0");
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
		
		$querystring = "SELECT * FROM carbrowseview WHERE VIN = '" . $vin . "'";
		$sql = $pdo->prepare($querystring);
		$sql->execute();
		$row = $sql->fetch(PDO::FETCH_ASSOC);
		
		$make = $row['make'];
		$model = $row['model'];
		$type = $row['type'];
		$transmission = $row['transmission'];
		$startdate = $_SESSION['startdate']->format('d-m-Y');
		$enddate = $_SESSION['enddate']->format('d-m-Y');
		$daysrent = $_SESSION['daysrent'];
		$propertyno = $row['property_number'];
		$street = $row['street'];
		$city = $row['city'];
		$postcode = $row['postcode'];
		
		echo "	<div class = 'booking-page1'>
					<img src='Images/rentaldetailscar.jpg' class='hire-cars'>
				
					<b><i><font size='+1'>Car:</b></i><br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Make: $make<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Model: $model<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: $type<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Transmission: $transmission<br>
					<br><br><b><i>Rent:</b></i><br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pick-up date: $startdate<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Drop-off date: $enddate<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total days: $daysrent<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total rent: £$rent<br>
					<br><br><b><i>Pickup Location:</b></i><br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$propertyno<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$street<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$city<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$postcode<br>
				</div>
						
					<div class = 'booking-page'>
						<img src='Images/creditcardcar.jpg' class='hire-cars'>
						<h1>Please Enter Credit Card Details</h1>
						<form method='POST'>							
							<p>Cardholder Name</p>
							<input type='text' name='cardname' required placeholder='Enter cardholder name'><br>
							<p>Card Number</p>
							<input type='text' name='cardno' required placeholder='Enter card number'><br>
							<p>Expiry Date</p>
							<select name = 'cardexpireyear'>";
							for ($i = date('Y'); $i <= date('Y') + 10; $i++)
							{
								echo "<option value='" . $i . "'>" . $i . "</option>";
							}
					echo "	</select>
							<select name = 'cardexpiremonth'>";
							for ($i = 1; $i < 13; $i++)
							{
								echo "<option value='" . sprintf("%02d", $i) . "'>" . sprintf("%02d", $i) . "</option>";
							}
					echo "	</select>
							<p>Security Number</p>
							<input type='text' name='cardsecurityno' required placeholder='Enter security number'><br>
							<input type='submit' name='confirmrent' value='Book Now'>
							<input type='reset' name='reset-button' value='Reset'>					
						</form>
					</div>";
				
		function getnextleaseno()
		{
			include "db.php";
			$querystring = "SELECT lease_number FROM lease order by lease_number DESC"; 
			$sql = $pdo->prepare($querystring);
			$sql->execute();
			$row = $sql->fetch(PDO::FETCH_ASSOC);
			$latest = $row['lease_number'];
			$latest = ltrim($latest, "L");
			$latest = $latest + 1;
			$latest = "L" . sprintf("%09d", $latest);
			return $latest;
		}
	?> 
	</body>
</html>



