<?php 
	$fullName = $_POST["fullname"];
	$address  = $_POST["address"];
	$email = $_POST['email'];
	$city = $_POST["city"];
	$province = $_POST["province"];
	$postalCode = $_POST["postal"];
	$cardname = $_POST["cardname"];
	$cardnumber = $_POST["cardnumber"];
	$month = $_POST["month"];	

	$qty1 = $_POST["qty1"];
	$qty2 = $_POST["qty2"];
	$qty3 = $_POST["qty3"];
	$qty4 = $_POST["qty4"];
	$qty5 = $_POST["qty5"];
	$cost = 0;
	$totals = 0;
	$costs =array();

	$qty = array($qty1,$qty2,$qty3,$qty4,$qty5);

	$products = array('iMac', 'Mouse', 'WD HDD', 'Nexus', 'Drums');	

	$prices = array( 1899.99, 79.99, 179.99,249.99, 119.99);

	$errorflag = true;

		// Check full name, card name, address and city have value
		if (empty($fullName)) {
			echo"<h1>"."Full name cannot be blank."."</h1>";
			$errorflag = false;
		}

		if (empty($cardname)) {
			echo"<h1>"."Card name cannot be blank."."</h1>";
			$errorflag = false;
		}

		if (empty($address)) {
			echo"<h1>"."Address cannot be blank."."</h1>";
			$errorflag = false;
		}

		if (empty($city)) {
			echo"<h1>"."City cannot be blank."."</h1>";
			$errorflag = false;
		}

		//Check email.
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			echo"<h1>"."You did not supply an appropiate email address."."</h1>";
			$errorflag = false;
		}

		//Check postal code.
		if(!preg_match('/[A-Za-z]\d[A-Za-z] ?\d[A-Za-z]\d/', $postalCode)){
			echo"<h1>"."You did not supply an appropiate postal code."."</h1>";
			$errorflag = false;
		}

		//Check card number
		if(!preg_match('/^\d{10}$/', $cardnumber)){
			echo "<h1>"."You did not supply an appropiate card number."."</h1>";
			$errorflag = false;
		}

		//Check card mouth
		$max = 12;
		$min = 0;
		if (!filter_var($month, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min, "max_range"=>$max)))) {
			echo "<h1>"."You did not supply an appropiate card month."."</h1>";
			$errorflag = false;
		}

		//Check card year
		$currentyear = strftime("%Y");
		$year = $_POST["year"];

		if (!filter_var($year, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$currentyear, "max_range"=>$currentyear+5)))) {
			echo "<h1>"."You did not supply an appropiate card year."."</h1>";
			$errorflag = false;
		}

		//Check card type
		$cardtype = $_POST["cardtype"];
		$visa = "visa";
		$amex = "amex";
		$mastercard = "mastercard";

		if(!($cardtype == $visa || $cardtype == $amex|| $cardtype == $mastercard)){
			echo "<h1>"."You did not supply an appropiate card type."."</h1>";
			$errorflag = false;
		}

		//Check all quantities must be integers.
		for ($i = 0; $i < 5; $i++) { 
			echo $qty[$i];
			if (filter_var($qty[$i], FILTER_VALIDATE_INT)){	
				break;
			}
			else{
				echo "<h1>"."You did not supply an appropiate quantitie."."</h1>";
				$errorflag = false;	
				break;	
			}
		}
		
		// Check province two digit abbreviations
		$province = $_POST["province"];

		if($province != "AB" 
			&& $province != "BC"
			&& $province != "MB"
			&& $province != "NB"
			&& $province != "NL"
			&& $province != "NS"
			&& $province != "ON"
			&& $province != "PE"
			&& $province != "QC"
			&& $province != "SK"
			&& $province != "NT"
			&& $province != "NU"
			&& $province != "YT"){
			echo "<h1>"."You did not supply an appropiate  province two digit abbreviations."."</h1>";
				$errorflag = false;
		}

?>

<!DOCTYPE html>
<html>
	<head>	
		<link rel="stylesheet" type="text/css" href="thankyoustyles.css" />
		<title>Thank You for Your Submission</title>
	</head>

	<body>
		<?php if($errorflag): ?>

		<div class="invoice">

			<h1>Thanks for your order <?= $fullName ?>.</h1>
			<h2>Here's a summary of your order:</h2>
		
			<table>
				<tr>
					<td colspan="4" class="tableHead">Address Information
					</td>		
				</tr>
				<tr>
					<td class="alignright">Address:</td>
					<td><?= $address ?></td>
					<td class="alignright">City:</td>
					<td><?= $city ?></td>
				</tr>
				<tr>
					<td class="alignright">Province:</td>
					<td><?= $province ?></td>
					<td class="alignright">Postal Code:</td>
					<td><?= $postalCode ?></td>
				</tr>
				<tr>
					<td colspan="2" class="alignright">Email:</td>
					<td colspan="2"><?= $email ?></td>
				</tr>
			</table>

			<table>
				<tr>
					<td colspan="3" class="tableHead">Order Information
					</td>		
				</tr>
				<tr>
					<td>Quantity</td>
					<td>Description</td>
					<td>Cost</td>
				</tr>
			
				<?php for($i=0; $i<5; $i++): ?>	
					<?php if(!empty($qty[$i])): ?>
						<tr>	
							<td><?= $qty[$i] ?></td>
							<td><?= $products[$i] ?></td>
							<?php $cost = $prices[$i] *  $qty[$i] ?>
							<?php array_push($costs, $cost) ?>
							<td class="alignright"><?= $cost ?> </td>
						</tr>
					<?php endif; ?>			
				<?php endfor; ?>
							
				<tr>
					<td colspan="2" class="alignright">Totals</td>			 
						<?php for($i=0; $i<count($costs); $i++): ?>	
							<?php $totals += $costs[$i] ?>
						<?php endfor; ?>				
						<td class="alignright">	
							$ <?= $totals ?>
						</td>
				</tr>
			</table>
		</div>
		<?php endif; ?>
	</body>
</html>


























