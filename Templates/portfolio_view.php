<?php
require('../Model/model.php');

	echo'<div id="portfolio_view">';
	echo '<p>Welcome, '.$user.'<br>Current account balance is $'.$_SESSION['userbalance']=get_balance($_SESSION['userid']).'</p>';

$user_shares = get_shares($_SESSION['userid']);
if (!$user_shares == NULL)
{
	/*
	*	shares table
	*/
	
	echo'<p>You also own the following shares:</p>';
	echo'<table id="shares_table">';
	echo'<tr><th>Symbol</th><th>Name</th><th>Shares</th><th>Share Price</th><th>Total</th>';
	foreach ($user_shares as $value => $key) //loop through the portfolio table to recieve data
	{
		echo"<tr>";
		$i=0;
			foreach ($key as $value2 => $key2)
			{
				$i++;
				echo "<td>$key2</td>";
				//saving symbol and number of shares for later use in the table
				switch ($i)	{
					case 1:
						$symbol=$key2;
					case 3:
						$shares=$key2;
							}
			}
			if ($i == 3) //if the loop finished parsing the portfolio row, continue displaying the rest of the table
			{
				$symbol_data=get_symbol_data($symbol);
				$share_price=$symbol_data['share_price'];
				echo'<td>$'.$share_price.'</td><td>$'.$share_price*$shares.'</td>';
			}
		echo'</tr>';
	}
echo'</table>';
}	//end of if table wrapper

else	//if user doesn't own any shares
{
	echo'<p>You do not own any stock yet, use your availabe balance to invest.</p>';	
}


echo'</div>';	//end of profile view render
?>
