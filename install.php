<?php
    $servername = "localhost";
    $username = "root";	
    $password = "";
    $dbname = "";
    
	$conn = new mysqli($servername, $username, $password, $dbname);

	$sql = "CREATE DATABASE FreqMaker";
	if ($conn->query($sql) === TRUE) {
	    echo "Database created successfully";
	} else {
	    echo "Error creating database: " . $conn->error;
	}

	echo "<br>";

	$dbname = "FreqMaker";
    
	$conn = new mysqli($servername, $username, $password, $dbname);

	$sql = "CREATE TABLE IF NOT EXISTS `users` (
			`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`username` varchar(100) NOT NULL,
			`email` varchar(50) NOT NULL,
			`fingerprint_id` int(11) NOT NULL,
			`fingerprint_select` tinyint(1) NOT NULL DEFAULT '0',
			`user_date` date NOT NULL,
			`time_in` time NOT NULL,
			`del_fingerid` tinyint(1) NOT NULL DEFAULT '0',
			`add_fingerid` tinyint(1) NOT NULL DEFAULT '0'
	) ENGINE=InnoDB DEFAULT CHARSET=latin1";

	if ($conn->query($sql) === TRUE) {
	    echo "Table users created successfully";
	} else {
	    echo "Error creating table: " . $conn->error;
	}

	$sql = "CREATE TABLE IF NOT EXISTS `users_logs` (
			`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`username` varchar(100) NOT NULL,
			`fingerprint_id` int(5) NOT NULL,
			`checkindate` date NOT NULL,
			`timein` time NOT NULL,
			`timeout` time NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=latin1";

	if ($conn->query($sql) === TRUE) {
	    echo "Table users_logs created successfully";
	} else {
	    echo "Error creating table: " . $conn->error;
	}
		
	$conn->close();
?>