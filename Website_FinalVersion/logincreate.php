<html>
<body>
      <head>			 
	<div class="h1"> 
        <title>Murray Motors</title>
        <link href="stylesheet2.css" rel="stylesheet" type="text/css">   
            <div class="row">
                <ul class="main-nav">
                    <li><a href="index.php"> HOME </a></li>
					<?php
						session_start();
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
									<p>Please login before proceeding</p>
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
<div class = "login-page">
<img src="Images/logincar.jpg" class="hire-cars">
	<form method = "post">
		<br>Email address<br>
		<input type="email" required name="useremail"><br>
		Password<br>
		<input type="password" required name="userpass"><br><br>
		<input type="submit" name="login" value="Log In">
	</form>
</div>


	<form method = "post">
	<div class = 'login2-page'>
			<img src="Images/registeraccountcar.jpg" class="hire-cars">
			<font size="-1.5">
		First Name<br>
		<input type="text" required name="fname"><br>
		Last Name<br>
		<input type="text" required name="lname"><br>
		Email address<br>
		<input type="email" required name="email"><br>
		Phone Number<br>
		<input type="text" required name="phoneno"><br>
		License Number<br>
		<input type="text" required name="licenseno"><br>
		Password<br>
		<input type="password" required name="password"><br>
		Confirm Password<br>
		<input type="password" required name="confpassword"><br>
		Property Number<br>
		<input type="text" required name="propertyno"><br>
		Street<br>
		<input type="text" required name="street"><br>
		City<br>
		<input type="text" required name="city"><br>
		Postcode<br>
		<input type="text" required name="postcode"><br>
		<input type="submit" name="createaccount" value="Register Account"></font>
	</form>
	</div>

<?php
include ("db.php");

if (isset($_SESSION['useremail']) || !isset($_SESSION['rentvin']))
{
	header("Location: index.php");
	exit;
}
else if (isset($_POST["login"]))
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
				header("Location: purchase.php");
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
else if (isset($_POST["createaccount"]))
{
	if ($_POST['password'] == $_POST['confpassword'])
	{
		$success = insertaddress();
		
		if ($success == False)
		{
			echo "Invalid address";
		}
		else
		{
			$success2 = insertcustomer();
			
			if ($success2 == False)
			{
				echo "Invalid customer details";
				deletelatestaddress();
			}
			else
			{
				$_SESSION['useremail'] = $_POST["email"];
				
				header("Location: purchase.php");
				exit;
			}
		}
	}
}
		
function getnextcustomerno()
{
	include "db.php";
	$querystring = "SELECT customer_number FROM customer order by customer_number DESC"; 
	$sql = $pdo->prepare($querystring);
	$sql->execute();
	$row = $sql->fetch(PDO::FETCH_ASSOC);
	$latest = $row['customer_number'];
	$latest = $latest + 1;
	$latest = "0" . sprintf("%09d", $latest);
	return $latest;
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
	$_SESSION['latestaddressid'] = $latest;
	return $latest;
}

function insertcustomer()
{
	include "db.php";
	if(!$row && $row['email'] == $_POST['email'])
	{
		$_SESSION['feedbackmessage'] = "Email is already in use";
	}
	else
	{
		$customerno = getnextcustomerno();
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$sql = $pdo->prepare("INSERT INTO customer (customer_number, Address_ID, first_name, last_name, email, phone_number, license_number, password) VALUES (:customerno, :addressid, :fname, :lname, :email, :phoneno, :licenseno, :password)");
		$updated = $sql->execute(array(':customerno' => $customerno, ':addressid' => $_SESSION['latestaddressid'], ':fname' => $_POST['fname'], ':lname' => $_POST['lname'], ':email' => $_POST['email'], ':phoneno' => $_POST['phoneno'], ':licenseno' => $_POST['licenseno'], ':password' => $password));
		return $updated;
	}
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
	$sql->execute(array(':addressid' => $_SESSION['latestaddressid']));
}

?> 		

</body>
</html>

