<div class="forms" id="transactions">
<p>Quick Transactions</p>
<table><form action="../controller/transactions.php" method="post">
<tr><td>Symbol</td><td>Amount</td></tr>
<tr><td><input type="text" name="symbol" size="4"></td><td><input type="text" name="amount" size="4"></td></tr>
<tr><td><input type="submit" name="submit" value="Buy" class="buttons"></td><td><input type="submit" name="submit" value="Sell" class="buttons"></td></tr>
</table></form>
<?php
if (isset($_SESSION['transaction']))
	{
	echo '<p>'.$_SESSION['transaction'].'</p>';
		unset($_SESSION['transaction']);
	}
?>
</div>
