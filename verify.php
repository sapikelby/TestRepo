<?php
	$user = $postArray['username'];
	$pass= $postArray['password']; 	// password
	$salt = 'st'; 					// extra layer of protection

	// encrypt the password
	$md5pass = md5($pass); 
	$sha1pass = sha1($pass);
	$cryptpass = crypt($pass, $salt);

	$sha1pass = sha1($md5pass);  // sha1 gets md5 hash
	$cryptpass = crypt($sha1pass); // crypt gets sha1 hash

	// a total of three layers, much harder to break into but not impossible
	if (crypt(sha1(md5($pass)) == $cryptpass))
	{
		// Then we're good
	}
?>