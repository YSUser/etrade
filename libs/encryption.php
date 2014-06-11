<?php
class Encryption
{
	private $key = 'keystring';
	private $cipher = 'MCRYPT_RIJNDAEL_128';
	private $mode = 'MCRYPT_MODE_CBC';
	
	public function encrypt($text)
	{
        $ivSize = mcrypt_get_iv_size($this -> cipher, $this -> mode);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_DEV_RANDOM);
        $ciphertext = mcrypt_encrypt($this -> cipher, $this -> key, $text, $this -> mode, $iv);
        return base64_encode($iv.$ciphertext);
	}
	
	public function decrypt($ciphertext)
	{
        $ciphertext = base64_decode($ciphertext);
        $ivSize = mcrypt_get_iv_size($this -> cipher, $this -> mode);
		
        if (strlen($ciphertext) < $ivSize)
        {
			errorHandler::error('Missing initialization vector', 'E_ERROR');
        }

        $iv = substr($ciphertext, 0, $ivSize);
        $ciphertext = substr($ciphertext, $ivSize);
        $plaintext = mcrypt_decrypt($this -> cipher, $this -> key, $ciphertext, $this -> mode, $iv);
        return rtrim($plaintext, "\0");
	}
}
?>