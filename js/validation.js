function emptyvalidation(entered, alertbox)
{
	with (entered)
{
	if (entered.value==null || entered.value=="")
	{if (alertbox!="") {alert(alertbox);} return false;}
	else {return true;}
	}
} 

function emailvalidation(entered, alertbox)
{
	with (entered)
{
	apos=value.indexOf("@"); 
	dotpos=value.lastIndexOf(".");
	lastpos=value.length-1;
	if (apos<1 || dotpos-apos<2 || lastpos-dotpos>3 || lastpos-dotpos<2) 
	{if (alertbox) {alert(alertbox);} return false;}
	else {return true;}
	}
}

function numbervalidation(entered, alertbox)
{
	with(entered)	
	{
		if (isNaN(entered.value) || entered.value=="")
		{
			if (alertbox!="") {alert(alertbox);} return false;
		}
		else 
		{
			return true;
		}
	}
}

function selectValidation(entered, alertbox)
{
	with(entered)	
	{
		if (entered.options[entered.selectedIndex].value == 'select')
		{
			if (alertbox!="") {alert(alertbox);} return false;
		}
		else 
		{
			return true;
		}
	}
}

function formvalidation(thisform)
{
	with (thisform)
	{
		if (emptyvalidation(name,"Error ! Please Type Your Full Name !")==false) {name.focus(); return false;}
		if (emptyvalidation(address,"Error ! Please Type Your Correct Address !")==false) {address.focus(); return false;}
		if (emptyvalidation(postalcode,"Error ! Please Type Your Postal Code !")==false) {postalcode.focus(); return false;}
		if (numbervalidation(phone,"Error ! Please Type Your Correct Phone No !")==false) {phone.focus(); return false;}
		if (emptyvalidation(email,"Error ! Please Type Your Valid Email Address !")==false) {email.focus(); return false;}
		if (emptyvalidation(message,"Error ! Please Type Your Message !")==false) {message.focus(); return false;}
		
		
		
		if (emptyvalidation(code_check,"Error ! Please Type the Code Text Correctly !")==false) {code_check.focus(); return false;}
		
		
		else
		{
		document.contact.submit();
		}
	}
} 





