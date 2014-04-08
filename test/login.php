<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Login</title>
</head>

<body>
<table border="0" cellpadding="0" cellspacing="0" align="center" class="loginsubtable">
<tr>
<td valign="top"></td>
<td class="loginsep">
<form enctype="multipart/form-data" id="loginform" method="post">
<input type="hidden" name="uri" id="uri" value="/snapshot.cgi" />
<table border="0" cellpadding="0" cellspacing="0" class="logintable" align="center">
	<tr><td colspan="2" align="center"> &nbsp;
	
	</td></tr>
	<tr>
		<td><label for="username">Username:</label></td>
		<td><input type="text" name="username" id="username" /></td>
	</tr>
	<tr>
		<td><label for="password">Password:</label></td>
		<td><input type="password" name="password" id="password" maxlength="8"/></td>
	</tr>
	<tr>
		<td></td>
		<td class="submit"><input name="Submit" type="submit" id="submit" value="Login" /></td>
	</tr>
</table>
</form>
</td>
</tr>
</table>
</body>
</html>

<?php
print_r($_POST);
?>