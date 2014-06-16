<?php
class Session extends SessionHandler
{
	private $encryption = FALSE;
	
	public function __construct()
	{
		$this -> start();
	}
	
	private function start()
	{
		if ($this -> encryption)
		{
			$this -> encryption = new Encryption;
			session_set_save_handler($this, TRUE);
		}
		session_start();
	}
	
	public function read($id)
	{
        $data = parent::read($id);
        return $this -> encryption -> decrypt($data);
	}
	
	public function write($id, $data)
	{
        $data = $this -> encryption -> encrypt($data);
        return parent::write($id, $data);
	}
	
	public function _destroy()
	{
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
	            $params["path"], $params["domain"],
	            $params["secure"], $params["httponly"]
       		 );
			 
		session_unset();	 
		session_destroy();
	}
	
	public function setData($key, $val)
	{
		$_SESSION[$key] = $val;
	}
	
	public function unsetData($key)
	{
		unset($_SESSION[$key]);
	}
	
	public function getData($key)
	{
		return $_SESSION[$key];
	}
	
	public function getAllData()
	{
		return $_SESSION;
	}
}
?>