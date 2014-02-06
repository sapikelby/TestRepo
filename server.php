 <?php
            // sorry for the indentation
            // basic server and client connection
            // you can test this using WAMP server (http://www.wampserver.com/en/)
            // you'll basically send a message and receive a message
            // if you test it out, take out the database stuff since it most likely
            // will give you errors
            // P.S. if you upload this to your website server, it will also work, but 
            // you might have to change the port and host
 
            require ('mysql_connect.php');
            
            //echo "server script page";
            
            // set host and port
            $host = "127.0.0.1";  // 192.168.0.1
            $port = 1234; 
            
            // no timeout on the service/script
            set_time_limit(0);
            
            // create the socket
            $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
            
            // AF_INET = address family for IPv4 (processes that run on the same 
            // sysytem or on different systems. (IP addresses and port numbers)
            
            // bind the socket to the port and host
            $result = socket_bind($socket, $host, $port) or die("Could not bind socket\n");
            
            // wait for client to connect, start listening
            $result = socket_listen($socket, 3) or die("Could not setup socket listener\n");
            
            // accept incoming connection
            // this function accepts incoming connections on the created socket
            $spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
            
            // read message from the client socket
            $input = socket_read($spawn, 1024) or die("Could not read message\n");
            
            // Checking for ip address
            //$ip_address = '192.168.0.1';
            
            
            $http_client_ip = $_SERVER['HTTP_CLIENT_IP'];
            $http_x_forwarded_for = $_SERVER['HTTP_X_FORWARDED_FOR'];
            $remote_addr = $_SERVER['REMOTE_ADDR'];
            
            // check for ip address
            // test for a shared client
            if(!empty($http_client_ip))
            {
                $ip_address = $http_client_ip; 
            }
            // test for proxy address
            else if(!empty($http_x_forwarded_for))
            {
                $ip_address = $http_x_forwarded_for; 
            }
            else  
            {
                $ip_address = $remote_addr; 
            }
            
            
            $connections = 5; 
            $pointer = 1244;
            
            // ~~~~
            if($input === 'request to share session key')
            {
                $output = 'request to share sk granted.';
                
                // populate database with info
                $q = "INSERT INTO dvps (dvp_ip, time_joined, number_of_connections, dvp_pointer) VALUES ('$ip_address', NOW(), $connections , $pointer)";		
		$r = @mysqli_query ($dbc, $q); // Run the query.
		
		if (mysqli_affected_rows($dbc) == 1) {
                        echo "1 record was inserted!";
		
		}
            }
            
            else
            {
                $output = 'request not granted';
            }
            
            
            // reverse message received
            //$output = strrev($input) . "\n";
            
            // send message to the client socket
            socket_write($spawn, $output, strlen($output)) or die("Could not write output\n");
            
            // close the socket (end connection)
            socket_close($socket);
            socket_close($spawn);
            
        ?>

