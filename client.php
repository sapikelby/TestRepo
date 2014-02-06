<?php
   $host = "127.0.0.1";
   $port = 1234;
   $message = "request to share session key";
   //$message = "request not to share session key";
   
   echo "Message to server : " . $message . "\n"; 
   
   // create the socket
   $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
   
   // connect to the server 
   $result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");
   
   // send string to the server 
   socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
   
   // get server response
   $result = socket_read($socket, 1024) or die("Could not read server response\n");
   
   echo "---";
   echo "Reply from server: " . $result; 
   
   // close socket
   socket_close($socket);
   
?>
