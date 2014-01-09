<div class="forms" id="login_form">
        		<p>Etrade Login</p>
                <form method="post" action="../controller/login.php">
                <input type="text" name="username"><br>
                <input type="password" name="password"><br>
                <input type="submit" value="Log In" class="buttons">
                </form>
<?php
if (isset($_SESSION['login']))
	{
	echo '<p>'.$_SESSION['login'].'</p>';
		unset($_SESSION['login']);
	}
	
	echo'<p>Or</p>';
	echo'<a href="../root/portfolio.php">Create an account</a>';

?>
</div>
