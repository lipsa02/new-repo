<?php
$cryptinstall="cryptographp.fct.php";
include $cryptinstall; 
	$comments_textarea_1 = "<text";
	$comments_textarea_2 = 'area name="comments" cols="32" rows="6">';
	$end_textarea_1 = "</text";
	$end_textarea_2 = "area>";
	if (!function_exists('str_split')) {
		function str_split($string, $split_length = 1) {
			return explode("\r\n", chunk_split($string, $split_length));
		}
	}
	
	function generateDropDown($values,$value_selected) {
		$value_array = explode(',',$values);
		$i = 0;
		while ($value_array[$i] != '') {
			if ($value_array[$i] == $value_selected) {
				$selected = ' selected ';
			} else {
				$selected = '';
			}
			$options .= '<option value="' . $value_array[$i] . '" ' . $selected . '>' . $value_array[$i] . '</option>';
			$i++;
		}
		return $options;
	}
	
	function checkValidChars($string,$valid_chars) {
		$string_array = str_split($string);
		$valid_chars_array = str_split($valid_chars);
		$i = 0;
		while ($string_array[$i] != '') {
			if (!in_array($string_array[$i],$valid_chars_array)) {
				return false;
			}
			$i++;
		}
		return true;
	}
	
	function getResultDiv($value,$type='error') {
		// Formats successful or error results whether they are in an array or a snippet.
		if ($type == 'success') {
			$class = 'success-div';
		} elseif ($type == 'test') {
			$class = 'test-div';
		} else {
			$class = 'error-div';
		}
		if (is_array($value)) {
			for ($i = 0; $value[$i] != ''; $i++) {
				$result_div .= '<li>' . $value[$i] . '</li>';
			}
			if ($result_div != '') {
				$result_div = '<div class="' . $class . '"><ul>' . $result_div . '</ul></div>';
			}
		} else {
			if ($value != '') {
				$result_div = '<div class="' . $class . '">' . $value . '</div>';
			}
		}
		return $result_div;
	}

	function getValidation($add_edit,$fullname,$msg,$type,$value='') {
		global $edit_action;
		global $add_action;
		global $error_div;
		global $_POST;
		global $_GET;
		if  ($_POST['action'] == "submit_form") {
			$do = 1;
		} 
		// No value
		if ($type == 'novalue') {
			if ($do == 1) {
				if (strlen($_POST[$fullname]) < '1') {
					$error_div .= getResultDiv($msg);
				}
			}
			$js_clause = 'form.' . $fullname . '.value == ""';
			return jsCheck($js_clause,$msg,$fullname);
		}
		
		// Number is less than
		if ($type == 'less_than') {
			if ($do == 1) {
				if ($_POST[$fullname] < $value) {
					$error_div .= getResultDiv($msg);
				}
			}
			$js_clause = 'form.' . $fullname . '.value < ' . $value;
			return jsCheck($js_clause,$msg,$fullname);
		}
		
		// Number is greater than
		if ($type == 'greater_than') {
			if ($do == 1) {
				if ($_POST[$fullname] > $value) {
					$error_div .= getResultDiv($msg);
				}
			}
			$js_clause = 'form.' . $fullname . '.value > ' . $value;
			return jsCheck($js_clause,$msg,$fullname);
		}
		
		// Value equals
		if ($type == 'equals') {
			if ($do == 1) {
				if ($_POST[$fullname] == $value) {
					$error_div .= getResultDiv($msg);
				}
			}
			$js_clause = 'form.' . $fullname . '.value == ' . $value;
			return jsCheck($js_clause,$msg,$fullname);
		}
		
		// Less Than String Length
		if ($type == 'strlen_less') {
			if ($do == 1) {
				if (strlen($_POST[$fullname]) < $value) {
					$error_div .= getResultDiv($msg);
				}
			}
			$js_clause = 'form.' . $fullname . '.value.length < ' . $value;
			return jsCheck($js_clause,$msg,$fullname);
		}
		
		// String Length
		if ($type == 'strlen') {
			if ($do == 1) {
				if (strlen($_POST[$fullname]) != $value) {
					$error_div .= getResultDiv($msg);
				}
			}
			$js_clause = 'form.' . $fullname . '.value.length != ' . $value;
			return jsCheck($js_clause,$msg,$fullname);
		}
		
		// Zip Code
		if ($type == 'zip') {
			$valid_chars = "0123456789";
			if ($do == 1) {
				if (strlen($_POST[$fullname]) != 5) {
					$error_div .= getResultDiv('Please enter 5 digits for the zip code');
				} elseif (!checkValidChars($_POST[$fullname],$valid_chars)) {
					$error_div .= getResultDiv('Please enter only digits for the zip code');
				}
			}
			$js_clause_1 = 'form.' . $fullname . '.value.length != 5';
			$js_clause_2 = '!ValidChars(form.' . $fullname . '.value,"' . $valid_chars . '")';
			return 
				jsCheck($js_clause_1,'Please enter 5 numbers for the zip code',$fullname) . 
				jsCheck($js_clause_2,'Please enter only numbers in the zip code',$fullname);
		}
		
		// Price
		if ($type == 'price') {
			$valid_chars = "0123456789.,";
			
			if ($do == 1) {
				$post_value = str_replace(',','',$_POST[$fullname]);
				if (!checkValidChars($post_value,$valid_chars)) {
					$error_div .= getResultDiv('Please enter only a number for ' . $msg);
				} elseif (strlen($post_value) > $value) {
					$error_div .= getResultDiv('Please enter a smaller value for ' . $msg);
				}
			}
			$js_clause_1 = 'form.' . $fullname . '.value.length > ' . $value;
			$js_clause_2 = '!ValidChars(form.' . $fullname . '.value,"' . $valid_chars . '")';

			return 
				jsCheck($js_clause_1,'Please enter no more than ' . $value . ' characters for ' . $msg,$fullname) . 
				jsCheck($js_clause_2,'Please enter only numbers for ' . $msg,$fullname);
		}
		
		// Number
		if ($type == 'number') {
			$valid_chars = "0123456789";
			if ($do == 1) {
				$post_value = str_replace(',','',$_POST[$fullname]);
				if (!checkValidChars($post_value,$valid_chars)) {
					$error_div .= getResultDiv('Please enter only a number for ' . $msg);
				} elseif (strlen($post_value) > $value) {
					$error_div .= getResultDiv('Please enter a smaller value for ' . $msg);
				}
			}
			$js_clause_1 = 'form.' . $fullname . '.value.length > ' . $value;
			$js_clause_2 = '!ValidChars(form.' . $fullname . '.value,"' . $valid_chars . '")';

			return 
				jsCheck($js_clause_1,'Please enter no more than ' . $value . ' numbers for ' . $msg,$fullname) . 
				jsCheck($js_clause_2,'Please enter only numbers for ' . $msg,$fullname);
		}
		
		// Phone Number
		if ($type == 'phone') {
			$valid_chars = "0123456789-() ";
			$value = 7;
			if ($do == 1) {
				if (!checkValidChars($_POST[$fullname],$valid_chars)) {
					$error_div .= getResultDiv('Please enter only a phone number for ' . $msg);
				} elseif (strlen($post_value) > $value) {
					$error_div .= getResultDiv('Please enter a smaller value for ' . $msg);
				}
			}
			$js_clause_1 = 'form.' . $fullname . '.value.length < ' . $value;
			$js_clause_2 = '!ValidChars(form.' . $fullname . '.value,"' . $valid_chars . '")';

			return 
				jsCheck($js_clause_1,'Please enter no more than ' . $value . ' numbers for the phone number',$fullname) . 
				jsCheck($js_clause_2,'Please enter a valid phone number',$fullname);
		}
		
		// Password
		if ($type == 'password') {
			$valid_chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
			if ($do == 1) {
				if (!checkValidChars($_POST[$fullname],$valid_chars)) {
					$error_div .= getResultDiv('Please enter only alpha-numeric values for ' . $msg);
				} elseif (strlen($_POST[$fullname]) < $value || $_POST[$fullname] == '') {
					$error_div .= getResultDiv($msg . ' must be at least 6 characters long');
				}
			}
			$js_clause_1 = 'form.' . $fullname . '.value.length < ' . $value . ' && ' . ' form.' . $fullname . '.value.length > 0';
			$js_clause_2 = '!ValidChars(form.' . $fullname . '.value,"' . $valid_chars . '")';

			return 
				jsCheck($js_clause_1,$msg . ' must be at least 6 characters long',$fullname) . 
				jsCheck($js_clause_2,'Please enter only alpha-numeric values for ' . $msg,$fullname);
		}
		
		// Duplicate
		if ($type == 'duplicate') {
			if ($do == 1) {
				$value_array = explode(':',$value);
				$table = $value_array[0];
				$column = $value_array[1];
				$content = $_POST[$fullname];
			}
		}
		
	}
	
		function jsCheck($clause,$msg,$fullname) {
			return '
				if (' . $clause . ') {
				 alert( "' . $msg . '" );
				 form.' . $fullname . '.focus();
					return false;
				}
			';
		}
		
	if ($_POST['action'] == 'submit_form') {
	  if (dsp_crypt($_POST['code'])) 
		{

			if (strlen($_POST['fullname']) < 1) {
					$error_div .= getResultDiv('Please enter a value for your name');
				}
				if (strlen($_POST['email']) < 1) {
					$error_div .= getResultDiv('Please enter a value for your email address');
				}
			
			$valid_chars = "0123456789-() ";
			if (!checkValidChars($_POST['phone'],$valid_chars)) {
					$error_div .= getResultDiv('Please enter a valid (numbers, dashes and parenthesis) ');
			}
		$result_div .= $error_div;
		if ($error_div == '') {
			if (strlen($_POST["subject"] ) > 1) {
				$psubject =  $_POST["subject"] . "\n";
			}
			if (strlen($_POST["fullname"]) > 1) {
				$pfullname = $_POST["fullname"] . "\n";
			}
			if (strlen($_POST["email"]) > 1) {
				$pemail =  $_POST["email"] . "\n";
			}
			if (strlen($_POST["phone"] ) > 1) {
				$pphone =  $_POST["phone"] . "\n";
			}
			
			if (strlen($_POST["address"] ) > 1) {
				$paddress =  $_POST["address"] . "\n"; 
			}
			
			if (strlen($_POST["city"] ) > 1) {
				$pcity =  $_POST["city"] . "\n"; 
			}
			
			if (strlen($_POST["state"] ) > 1) {
				$pstate =  $_POST["state"] . "\n"; 
			}
			
			if (strlen($_POST["zip"] ) > 1) {
				$pzip =  $_POST["zip"] . "\n"; 
			}
			if (strlen($_POST["comments"] ) > 1) {
				$pcomments =  $_POST["comments"] . "\n\n";
			}
			$message = "Below is the information submitted to your Online Contact Form on " . date('F j, Y') . ":\n\n" ;
			$message.="
<table width='600' border='0' cellspacing='4' cellpadding='0'>
    <tr>
      <td width='140' valign='top'><strong>Name:</strong></td>
      <td width='460' valign='top'>".$pfullname."</td>
    </tr>
	<tr>
      <td width='140' valign='top'><strong>Email:</strong></td>
      <td width='460' valign='top'>".$pemail."</td>
    </tr>
	<tr>
      <td width='140' valign='top'><strong>Phone No:</strong></td>
      <td width='460' valign='top'>".$pphone."</td>
    </tr>
    <tr>
      <td width='140' valign='top'><strong>Address: </strong></td>
      <td width='460'>".$paddress."</td>
    </tr>
	 <tr>
      <td width='140' valign='top'><strong>City:</strong></td>
      <td width='460' valign='top'>".$pcity."</td>
    </tr>
	<tr>
      <td width='140' valign='top'><strong>State:</strong></td>
      <td width='460' valign='top'>".$pstate."</td>
    </tr>
	<tr>
      <td width='140' valign='top'><strong>Zip Code:</strong></td>
      <td width='460' valign='top'>".$pzip."</td>
    </tr>
   <tr>
      <td width='140' valign='top'><strong>Comments:</strong></td>
      <td width='460' valign='top'>".$pcomments."</td>
    </tr>
</table>";
		 ini_set("SMTP","192.168.0.40");
		//$to="padam@wserve.com";
		// $to="foreveryoung_46@yahoo.com";
		$fullname=$_POST['fullname'];
		$email=$_POST['email'];
	    $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: '.$fullname.' <'.$email.'>'. "\r\n";
        $message = str_replace("\'","'",$message);
		// $to="genii_ics@hotmail.com";
		$subject = 'You have received a mail from '.$fullname; //Modify the mail subject here
		// Mail it now
     
		$headers1  = 'MIME-Version: 1.0' . "\r\n";
        $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers1 .= 'From:  <'.$to.'>'. "\r\n";
        $message = str_replace("\'","'",$message);
		 
		 		 
		//Modify the mail subject here
      	$subject1 = "Thank you for visiting our site"; 
		  
		  		  
		// Modify the Message 
		$message1 = "Thank you for submitting your online Contact form on " . date('F j, Y') . ":\n\n" ;
					
if(mail($email, $subject1, $message1, $headers1) && mail($to, $subject, $message, $headers))
{
 echo "<a><font class='plzscript'>Your form has been submitted successfully. We will get back to you shortly!</font></a>";
 }
} else {
			$form = $_POST;
		}
	}
else
{
		   echo "<a><font color='#FF0000' size='+2'>Incorrect Image Text</font></a>" ;
} 
	}
?>