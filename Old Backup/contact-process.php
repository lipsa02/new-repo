<?php
include ('globals.php');
session_start();

$email = $_POST["email"];
$adminaddress = "nchaudhry1228@gmail.com";
$subject = " Contact Form Submission";
$date = date("m/d/Y H:i:s");
$headers = "From:$name <$email>\r\n".
		"X-Mailer: PHP/" . phpversion() . "\n" .
       	"MIME-Version: 1.0\r\n" .
       	"Content-Type: text/html; charset=utf-8\r\n" .
       	"Content-Transfer-Encoding: 8bit\n";;

$message = '
	A request form has been submitted on the website on '.$date.', following is the result of the submission.<br><br>
<table width="710px" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="40%" height="30" valign="top">Name:</td>
    <td width="60%" height="30" valign="top"><b>'.$_POST["name"].'</b></td>
  </tr>
  <tr>
    <td width="40%" height="30" valign="top">Address:</td>
    <td width="60%" height="30" valign="top"><b>'.$_POST["address"].'</b></td>
  </tr> 
  <tr>
    <td width="40%" height="30" valign="top">Zip code:</td>
    <td width="60%" height="30" valign="top"><b>'.$_POST["zipcode"].'</b></td>
  </tr>
   <tr>
    <td width="40%" height="30" valign="top">Phone No:</td>
    <td width="60%" height="30" valign="top"><b>'.$_POST["phone"].'</b></td>
  </tr>
  <tr>
    <td width="40%" height="30" valign="top">Your Email Address:</td>
    <td width="60%" height="30" valign="top"><b>'.$_POST["email"].'</b></td>
  </tr>
<tr>
    <td width="40%" height="30" valign="top">Comments:</td>
    <td width="60%" height="30" valign="top"><b>'.$_POST["comments"].'</b></td>
  </tr>  
</table>';


if (md5($_REQUEST['code_check'])==$_COOKIE[$site_cookie_verifyimage_name]) {
	mail($adminaddress, $subject, $message, $headers);
	header('Location: contact-us.php?sentok');
	}
	else {
	header('Location: contact.php?err');
	}
?>