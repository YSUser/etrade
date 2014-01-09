<div class="forms" id="register_form">
<form method="post" action="../controller/register.php">
<table>
<tr><td>Username</td><td>Password</td></tr>
<tr><td><input type="text" name="username"></td><td><input type="password" name="password"></td></tr>
<tr><td colspan="2" style="text-align:center;"><input type="submit" value="Register" class="buttons"></td></tr>
</table>
</form>
<?php
if (isset($_SESSION['register']))
	{
	echo '<p>'.$_SESSION['register'].'</p>';
		unset($_SESSION['register']);
	}
?>

</div>