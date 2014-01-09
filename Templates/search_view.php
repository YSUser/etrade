<div id="search"><form action="" method="get">
<p>Stock Search <input type="text" name="search">
<input type="submit" value="Go!" class="buttons"></p>
</form>
<?php
if (isset($_GET['search']))
{

$search = urlencode($_GET['search']);
$searchResult=get_symbol_data("$search");
if ($searchResult !== false)
{
	extract($searchResult);
	echo"<ul><li>Company Name: $name</li>"."<li>Company Symbol: $symbol</li>"."<li>Share Price: $share_price</li></ul>";
	echo'<ul>';
	echo "<li><img src=\"http://chart.finance.yahoo.com/t?s={$search}&width=350&height=200\"></li>";
	echo "<li><img src=\"http://chart.finance.yahoo.com/z?s={$search}&t=6m&z=s\"></li>";
	echo'</ul></div>';
}
else
{
	echo'<p>Please provide a valid stock symbol</p>';
}
}
?>