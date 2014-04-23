<?php


function get_symbol_data($symbol)
	{	
			$symbol_data=array();
			$url="http://download.finance.yahoo.com/d/quotes.csv?s={$symbol}&f=sl1n&e=.csv";
			$handle= @ fopen($url,"r");
			//verify $handle retrieved the file from yahoo
			if ($handle)
				{
				$row=fgetcsv($handle);
					if (isset($row[2]))
						{$symbol_data=array( "symbol" => $row[0],
											 "share_price" => $row[1],
											 "name" => $row[2]);
						} 
						else
						{
							return false;	
						}
				fclose($handle);
				if ($symbol_data['share_price'] <= 0)
					{return false;}
				else
					{return $symbol_data;}
					
			}
			else
			{
				//return false;
				die ('<b>Unable to Connect to Yahoo</b>');
			}
			
	}//end get symbol data



?>