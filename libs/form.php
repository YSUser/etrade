<?php
class Form
{
	private $postData = array();
	
	public function setPostData($field)
	{
		if (!empty($field) && array_key_exists($field, $_POST))
		{
			$this -> postData["$field"] = $_POST["$field"];
		}
		else
			{
				$e = new error('Undefined Post Key');
			}
	}
	
	public function getPostData($field = NULL)
	{
		if (isset($field) && array_key_exists($field, $this -> postData))
		{
			return $this -> postData["$field"];
		}
		elseif (!$field)
			{
				return $this -> postData;
			}
		else
			{
				$e = new error('Undefined Post Key');
			}
	}
	
}
?>