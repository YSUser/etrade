<?php
class Form
{
	private $postData = array();
	private $postRules = array();
	private $postErrors = FALSE;
	private $postErrorMessages = array();
	
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
	
	public function setPostRules($field, $arg = array())
	{
		if (!empty($arg) && array_key_exists($field, $_POST))
		{
			$this -> postData["$field"] = $_POST["$field"];
			$this -> postRules[$field] = array();
			foreach ($arg as $key)
			{
				if (method_exists($this, $key))
				{
					array_push($this -> postRules[$field], $key);
				}
			}

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
	
	public function submit()
	{
		$rules = $this -> postRules;
		if (!empty($rules))
		{
			foreach ($rules as $name => $rulesArray)
			{
				foreach ($rulesArray as $rule)
				{
					if ($this -> $rule($this ->postData[$name]) === FALSE)
					{
						$this -> postErrors = TRUE;
					}
				}
			}
		}
		if ($this -> postErrors === FALSE && !empty($this -> postRules))
		{
			return TRUE;
		}
		return FALSE;
	}
	
	public function getErrors()
	{
		if (empty($this -> postErrorMessages))
		{
			return FALSE;
		}
		else {
			{
				return $this -> postErrorMessages;
			}
		}
	}
	
	public function positiveNumber($arg)
	{
		if (ctype_digit($arg))
		{
			return TRUE;
		}
		else
		{
			array_push($this -> postErrorMessages, $arg . ' is not a positive number');
			return FALSE;
		}
	}
	
	public function validEmail($arg)
	{
		if (preg_match('/^[a-z0-9_-]+(\.[a-z0-9_-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$/', $arg))
		{
			return TRUE;
		}
		else
		{
			array_push($this -> postErrorMessages, $arg . ' is not a valid email');
			return FALSE;	
		}
	}
	
	public function validPassword($arg)
	{
		if (preg_match('/^.{6,}$/', $arg))
		{
			return TRUE;
		}
		else
		{
			array_push($this -> postErrorMessages, $arg . ' is not a valid password');
			return FALSE;	
		}
	}
	
	protected function alphanumeric($arg)
	{	
		if (preg_match('/^[0-9A-Za-z_-]{5,}$/', $arg))
		{
			return TRUE;
		}
		else
		{
			array_push($this -> postErrorMessages, $arg . ' is not a alphanumeric');
			return FALSE;
		}
		
	}
	
	
}
?>