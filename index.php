<?php

// Connect to local SQL database
$con = mysqli_connect("localhost","root","","harv-5");

// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
 
// Prevent PHP from stopping the script after 30 sec
set_time_limit(0);
 
// Opening the socket
$socket = fsockopen("irc.freenode.net", 6667);
 
$steamlookup = mysqli_query($con,"SELECT * FROM steamid ");
$nick = strpos($ex[0], '!');

	while($row = mysqli_fetch_array($steamlookup))
  {
	echo $row['Nick'] . " " . $row['SteamID'];
  }

 
// Send auth info
fputs($socket,"USER Harv-5 arcanetheory.net Harv-5 :Harv-5\n");
fputs($socket,"NICK Harv-5\n");
 
// Join channel
fputs($socket,"JOIN #digitalgames\n");
 
// Force endless while
while(1) {
 
	// Create variable for data received from IRC
	while($data = fgets($socket, 128)) {
 
		echo nl2br($data);
		flush();
 
		// Separate all data
		$ex = explode(' ', $data);
 
		// Send PONG back to the server
		if($ex[0] == "PING"){
			fputs($socket, "PONG ".$ex[1]."\n");
		}
 
		// Commands
		$command = str_replace(array(chr(10), chr(13)), '', $ex[3]);
		
		if ($command == ":!report") {
			fputs($socket, "PRIVMSG ".$ex[2]." :Harv-5 reporting for duty!\n");
		}
		
		
		if ($command == ":!link") {
			fputs($socket, "PRIVMSG ".$ex[2]." :Steam ID linked to $ex[0]\n");
			mysqli_query($con,"INSERT INTO steamid (Nick, SteamID) VALUES ('$nick','$ex[4]')");
		}
		
		if ($command == ":!steam") {
			fputs($socket, "PRIVMSG ".$ex[2]." :$steamlookup\n");
		}
		
	}
 
}
 
?>
