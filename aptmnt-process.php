<?php
include ('globals.php');
include ('dbconfig.php');

$category = $_POST["selecy_ct"];

$date = $_POST["booking_dt"];
$time = $_POST["booking_time"];
$fname = $_POST["booking_fname"];
$lname = $_POST["booking_lname"];
$email = $_POST["booking_email"];
$phone = $_POST["booking_phone"];
$wed_date = $_POST["wed_dt"];
$captcha = $_POST['g-recaptcha-response'];
//echo $captcha;
$book_date = date("y-m-d h:i:s");

$secret_key = '6Ldd3d8gAAAAAOYio95ANi6qXEgtWhazu5OirXhC';
$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_RETURNTRANSFER => 1,
CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
CURLOPT_POST => 1,
CURLOPT_POSTFIELDS => array(
	'secret' => $secret_key,
	'response' => $captcha
)
));
$response = curl_exec($curl);
curl_close($curl);

if(strpos($response, '"success": true') !== FALSE)
{
	$sql = "INSERT INTO ".tbl_booking."(event_category, booking_dt, booking_time, fname, lname, email, phone_no, wed_dt, created_dt)
		VALUES(:selecy_ct, :booking_dt, :booking_time, :booking_fname, :booking_lname, :booking_email, :booking_phone, :wed_dt, :created_dt)";
	$query = $DB_con->prepare($sql);

	$query->execute(array(
	':selecy_ct'=>$category,
	':booking_dt'=>$date,
	':booking_time'=>$time,
	':booking_fname'=>$fname,
	':booking_lname'=>$lname,
	':booking_email'=>$email,
	':booking_phone'=>$phone,
	':wed_dt'=>$wed_date,
	':created_dt'=>date("y-m-d h:i:s")
	));

	//$adminaddress = "nchaudhry1228@gmail.com";
	$adminaddress = "creative@corporateranking.com";
	$subject = "Online Appointment";
	$date = date("m/d/Y H:i:s");
	$headers = "From:<nchaudhry1228@gmail.com>\r\n".
			"X-Mailer: PHP/" . phpversion() . "\n" .
			"MIME-Version: 1.0\r\n" .
			"Content-Type: text/html; charset=utf-8\r\n" .
			"Content-Transfer-Encoding: 8bit\n";

	$message = 'An appointment has been booked on '.$book_date.', following is the details of booking:<br><br>
	<table width="710px" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="40%" height="30" valign="top">Event Category:</td>
			<td width="60%" height="30" valign="top"><b>'.$_POST["selecy_ct"].'</b></td>
		</tr>
		<tr>
			<td width="40%" height="30" valign="top">Booking Date:</td>
			<td width="60%" height="30" valign="top"><b>'.$_POST["booking_dt"].'</b></td>
		</tr>
		<tr>
			<td width="40%" height="30" valign="top">Booking Time:</td>
			<td width="60%" height="30" valign="top"><b>'.$_POST["booking_time"].'</b></td>
		</tr>
		<tr>
			<td width="40%" height="30" valign="top">First Name:</td>
			<td width="60%" height="30" valign="top"><b>'.$_POST["booking_fname"].'</b></td>
		</tr>
		<tr>
			<td width="40%" height="30" valign="top">Last Name:</td>
			<td width="60%" height="30" valign="top"><b>'.$_POST["booking_lname"].'</b></td>
		</tr>
		<tr>
			<td width="40%" height="30" valign="top">Email ID:</td>
			<td width="60%" height="30" valign="top"><b>'.$_POST["booking_email"].'</b></td>
		</tr>	  
		<tr>
			<td width="40%" height="30" valign="top">Phone No:</td>
			<td width="60%" height="30" valign="top"><b>'.$_POST["booking_phone"].'</b></td>
		</tr>
		<tr>
			<td width="40%" height="30" valign="top">Wedding Date:</td>
			<td width="60%" height="30" valign="top"><b>'.$_POST["wed_dt"].'</b></td>
		</tr>	  
	</table>';
	echo "success";	
	mail($adminaddress, $subject, $message, $headers);
	
	$replymail = "$email";
	$subject2 = "Online Appointment";
	$headers2 = "From:<nchaudhry1228@gmail.com>\r\n".
			"X-Mailer: PHP/" . phpversion() . "\n" .
			"MIME-Version: 1.0\r\n" .
			"Content-Type: text/html; charset=utf-8\r\n" .
			"Content-Transfer-Encoding: 8bit\n";
	$message2 = 'Thank You. Your appointment has been booked successfully.';
	mail($replymail, $subject2, $message2, $headers2);
}
else
{
 echo "error";	
}
?>