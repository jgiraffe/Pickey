<?php
	ob_end_clean();
	header("Connection: close");
	ignore_user_abort(true); // just to be safe
	ob_start();
	//echo('Text the user will see');
	$size = ob_get_length();
	header("Content-Length: $size");
	ob_end_flush(); // Strange behaviour, will not work
	flush(); // Unless both are called !
	// Do processing here
?>