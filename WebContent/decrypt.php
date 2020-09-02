<?php
function decrypt($encryptedKey, $key) {
	if( openssl_private_decrypt($encryptedKey, $decrypted, $key) )
	{
		return $decrypted;
	}
	return $encryptedKey;
}
?>