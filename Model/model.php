<?php
//add yahoo connect to model class

class Model
{	
	public $dbh;



public funcntion __construct()
	{
		$this->dbh = dbConnect();
	}

//Hashing password PHP version < 5.3.7
private function randomSalt()
	{
		$size = 16;
		$salt = mcrypt_create_iv($size, MCRYPT_DEV_RANDOM );
		return $salt;
	}

private function passwordHash($password)
	{
		$salt = random_salt();
		$hash[0] = crypt($password,$salt);
		
			while ($hash[0] == '*0')
			{
				$hash = password_hash($password);
			}
	
		$hash[1] = $salt;
		return $hash;
	}

protected function alphanumeric_validate($input)
	{	
		if (preg_match('/^[0-9A-Za-z_-]{5,}$/', $input))
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}

//connect to db
private function dbConnect()
{
		$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME;

			try	{
				$dbh = new PDO($dsn,DB_USER,DB_PASSWORD);
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //Development Environment only
				}
			catch (PDOException $e)
				{
				return false; //'PDO component failed:<br>'. $e->getMessage();
				}
			catch (Exception $e)
				{
				return false; //'Unknown component failed:<br>'. $e->getMessage();
				}
		return $dbh;
}

//login user
public function login($username,$password)
	{
		if ($dbh=db_connect())
		{
		//get salt
		$sth=$dbh->prepare("SELECT salt FROM users WHERE username=:username");
		$sth->bindValue(':username',$username,PDO::PARAM_STR);
		$sth->execute();
		$salt=$sth->fetch(PDO::FETCH_ASSOC);
		
		//get secure password
		$securePassword = crypt($password,$salt['salt']);
		
		$sth=$dbh->prepare("SELECT * FROM users WHERE username=:username && password='$securePassword'");
		$pass=array(':username' => $username);
		$sth->execute($pass);
		$count = $sth->rowCount();
			if ($count)
			{
				$_SESSION['userid'] = (int)$sth->fetchColumn(0);
				$_SESSION['username'] = $username;
				//$_SESSION['auth'] = true; older version
				$dbh = NULL;
				return;
			}
			else
			{	
				//$_SESSION['auth'] = false; older version
				$dbh = NULL;
				$e='Invalid Username or Password';
				return $e;
			}
		//dbh fail
		} else {
			return false;
		}
	}//end of login_user function



//get user share information
function get_shares($userid)
{
		$dbh=db_connect();

			$user_shares=array();
		$sth=$dbh->prepare("SELECT symbol,name,shares FROM e_trade.portfolio WHERE id=:id;");
		$sth->bindValue(':id',$_SESSION['userid'],PDO::PARAM_STR);
		$sth->execute();			
				$user_shares = array();
				while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
					array_push($user_shares, $row);
	}
		$dbh= NULL;
			return $user_shares;
} //end of get_shares function




//get user account balance
function get_balance($userid)
{
	$dbh=db_connect();
	
			$user_balance=array();
		$sth=$dbh->query("SELECT balance FROM users WHERE id='$userid'");
		$user_balance=$sth->fetch(PDO::FETCH_ASSOC);
	$dbh=NULL;
	return $user_balance['balance'];
	
}//end of user account balance



//register user
function register_user($username,$password)
{
	//validate user input
	if (alphanumeric_validate($username) == true && alphanumeric_validate($password) == true)
	{
	if ($dbh=db_connect())
	{
	
	//hash password
	$securePassword = password_hash($password);
	try
	{
		//check if username is in use
		$sth=$dbh->prepare("SELECT username FROM users WHERE username=:username");
		$sth->bindValue(':username',$username);
		$sth->execute();
		$row=$sth->rowCount();
			if ($row) //end if username already taken
			{
				$e='Username already exists';
				return $e;
			}
			else	// create a new user and update their balance
			{	
				$sth=$dbh->prepare("INSERT INTO e_trade.users (username, password, salt, balance) VALUES (:username, '$securePassword[0]','$securePassword[1]', 10000)");
				$sth->bindValue(':username',$username);
				$sth->execute();
				
				//SELECT user id (auto incremented) for the use of SESSION on portfolio page
				$sth=$dbh->prepare("SELECT id FROM users WHERE username=:username");
				$sth->bindValue(':username',$username);
				$sth->execute();
				$id=$sth->fetch(PDO::FETCH_ASSOC);
				$_SESSION['userid']=$id['id'];
				$_SESSION['username']=$username;
				//$_SESSION['auth'] = true; older version
				
				$dbh=NULL;
				return true;
			}
		
	}
	catch (PDOexception $e)
	{
		return 'PDO EXCEPTION<br>'.$e;
	}
	
	//dbh fail
	} else {
		return false;
	}
	
	//end alpha numeric validatetion
	}
	else
	{
		$e='Invalid length or characters';
		return $e;
	}	//return error
	
	
}	//end of register user function




//buy shares
function buy_shares($symbol,$amount)
{	
	$symbol=strtoupper($symbol);
	$symbol_data=get_symbol_data($symbol);
	$pos=strpos($amount,'.'); // check if numeric string has a decimal point
	
		//check if a valid symbol has been entered
		if (($symbol_data !== false) && (is_numeric($amount)) && ($pos === false))
		{
		//check if user has enough money to buy the stock
		if ($_SESSION['userbalance'] > ($symbol_data['share_price'] * $amount))
		{
			
		 $userid=$_SESSION['userid'];//user ID
		 $shareName=$symbol_data['name'];
		 $_SESSION['userbalance']=$_SESSION['userbalance'] - ($symbol_data['share_price'] * $amount);
		 $newAmount=$_SESSION['userbalance']; //new amount of money to be inserted into account

		 	//connect to DB
			$dbh=db_connect();
			
							//check if row (stock) already exists
							$sth=$dbh->query("SELECT symbol FROM e_trade.portfolio WHERE id=$userid AND symbol='$symbol'");
							$row=$sth->fetch(PDO::FETCH_ASSOC);
								if ($row)
								{$rowExists = true;}
								else
								{$rowExists = false;}
			//begin transaction
				try
				{
					$dbh->beginTransaction();
					//UPDATE new amount of money into users table (old balance - newAmountOfShares * share price)
					$subtractFunds="UPDATE e_trade.users SET balance='$newAmount' WHERE users.id='$userid'";
					
						if	($rowExists == true)	// if user already owns this stock, update amount
							{
						$sth=$dbh->prepare("UPDATE e_trade.portfolio SET shares=`shares`+:amount WHERE id=$userid AND symbol='$symbol'");
						$sth->bindValue(':amount',$amount,PDO::PARAM_INT);
						$sth->execute();
						$sth=$dbh->prepare("$subtractFunds");
						$sth->execute();
							}
						if	($rowExists == false)	// if user doesn't own this stock, create new row
							{
		$sth=$dbh->prepare("INSERT INTO e_trade.portfolio (id, symbol, name, shares) VALUES ('$userid', :symbol, '$shareName', :amount)");
								$sth->bindValue(':symbol',$symbol,PDO::PARAM_STR);
								$sth->bindValue(':amount',$amount,PDO::PARAM_INT);
								$sth->execute();
								$sth=$dbh->prepare("$subtractFunds");
								$sth->execute();
	
							}
							
						$dbh->commit();
						$s='Transaction Complete';
						$dbh=NULL;
						return $s;
				}
				catch (PDOexception $e) //rollback if transaction unsucceful
				{
					$dbh->rollback();
					$dbh=NULL;
					return 'PDO EXCEPTION<br>'.$e;
				}
				
			}
			else
			{
				$e='Insufficient Funds';
				return $e;
			}//end if Insufficient Funds wrapper
		
		}//end if valid symbol wrapper
		else
		{
			$e='Invalid amount or symbol';
			return $e;	
		}
		
}//end of buy_shares function


function sell_shares($symbol,$amount)
{
		$symbol=strtoupper($symbol);
	$symbol_data=get_symbol_data($symbol);
	$pos=strpos($amount,'.'); // check if numeric string has a decimal point
	
		//check if a valid symbol has been entered
		if (($symbol_data !== false) && (is_numeric($amount)) && ($pos === false))
		{
			 $userid=$_SESSION['userid'];//user ID

					 	//connect to DB
			$dbh=db_connect();
			
							//check if stock already exists
							$sth=$dbh->query("SELECT symbol FROM e_trade.portfolio WHERE id=$userid AND symbol='$symbol'");
							$row=$sth->fetch(PDO::FETCH_ASSOC);
								if ($row)
								{	// if symbol exists, check amount of shares
								$sth=$dbh->query("SELECT shares FROM e_trade.portfolio WHERE id=$userid AND symbol='$symbol'");
								$row=$sth->fetch(PDO::FETCH_ASSOC);
								}
								else //or return $e
								{
									$e='You don\'t own any '.$symbol.' stock';
									$dbh=NULL;
									return $e;
								}
								
						//check if user owns enough stock
						//if user has enough stock execute transaction
						if ($row['shares'] >= $amount)
						{
							$newBalance=($symbol_data['share_price'] * $amount);
							try
							{
							//begin transaction
							$dbh->beginTransaction();
							
							//if user's total amount of shares is bigger than the amount to be sold
							if ($row['shares'] > $amount)
							{
						$sth=$dbh->prepare("UPDATE e_trade.portfolio SET shares=`shares`-:amount WHERE id=$userid AND symbol='$symbol'");
						$sth->bindValue(':amount',$amount,PDO::PARAM_INT);
						$sth->execute();
						$sth=$dbh->prepare("UPDATE e_trade.users SET balance=`balance`+$newBalance WHERE users.id='$userid'");
						$sth->execute();

							}
							
							//if user's amount of shares is EQUAL to the amount being sold
							//delete share row (because there would be none left)
							if ($row['shares'] == $amount)
							{
						$sth=$dbh->prepare("DELETE FROM e_trade.portfolio WHERE id=$userid AND symbol='$symbol'");
						$sth->execute();
						$sth=$dbh->prepare("UPDATE e_trade.users SET balance=`balance`+$newBalance WHERE users.id='$userid'");
						$sth->execute();
						
							}
								//commit transaction
							$dbh->commit();
							$s='Transaction Complete';
							$dbh=NULL;
							return $s;

							//send PDO exception if unable to perform transaction
							}
							catch (PDOexception $e)
							{
								$dbh->rollback();
								$dbh=NULL;
								return 'PDO EXCEPTION<br>'.$e;
							}
							
							
							
							
							
						}
						else
						{
							$e='You don\'t own enough '.$symbol.' stock';
							$dbh=NULL;
							return $e;
						}// end not enough stock validation
									
		}// end if valid symbol wrapper
		else
		{
			$e='Invalid amount or symbol';
			return $e;	
		}

	
}//end of sell shares

function deleteAccount($username)
{
	$dbh=db_connect();
	$sth=$dbh->query("DELETE FROM e_trade.users WHERE id='$username'");
		if ($sth !== false)
		{
			return true;	
		}
		else
		{
			return false;	
		}
}

}
?>
