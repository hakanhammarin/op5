<?php
/*
 Author: op5 AB
 Date : 27/08/2012
 Description: This example shown here demonstrates
 the basics of how to communicate with the Monitor HTTP API.
*/

# Credentials for a user with read-access for the object
# you wish to fetch data from.
$username = '****'; // must be a user with at least read-access.
$password = '*****';

# API endpoint, see the full API documentation at http://<your-host>/api/help
$uri = "https://ec2xxxx.eu-west-1.compute.amazonaws.com/api/filter/query?format=json&query=[services]%20state=0&columns=host.name,description,state"; // URL to your monitor-instance, ending with /api/, example: http://monitor.mycompany.com/api/

# Host to generate service report on
# Specify the alias/address of the host here.
$host = "";

# Prepare curl execution and wrap it into a re-useable function.
function DoRequest($text) {
        global $username, $password, $uri;

        # Json-formated responses is preferred.
        $c = curl_init("$uri");

        curl_setopt($c, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        
        # in-case you have not installed the SSL certificate properly.
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
        
        $response = curl_exec($c);
        $json = json_decode($response, true);
        curl_close($c);
        
        return $json;
}

# Fire the request and receive the services information.
$status = DoRequest("");



# Print information
echo <<<INFO
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Pragma" content="no-cache"> 
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1"> 
<title>Höglandets IT: Statussida Internet</title>
</head>
<html>
<body>
	<h2>Höglandets IT: Statussida Internet</h2>
	
        
INFO;

#	Total services: <strong>$total_host_services</strong> <br />
#	&nbsp;&nbsp;&nbsp;$services_ok services are in <font color="green">OK</font> state <br />
#	&nbsp;&nbsp;&nbsp;$services_warning services are in <font color="yellow">WARNING</font> state<br />
#	&nbsp;&nbsp;&nbsp;$services_critical services are in  <font color="red">CRITICAL</font> state<br />
#	&nbsp;&nbsp;&nbsp;$services_unknown services are in <font color="orange">UNKNOWN</font> state<br />
#	<hr>
#INFO;

# Print all services with their name, state
# and latest status information.
# echo "<pre>";
echo "<hr>";
foreach ($status as $key => $value) {

foreach ($value["host"] as $key2 => $host) {
}
#   echo $host .  ": " . $value["description"] . ", " . $value["state"] . "<br>";

        if ($value["state"] == 0) {
                $state = "OK";
                echo '<font color=\"green\">' . $host .  ': ' . $value["description"] . ', ' . $state . '</font><br />';

        } elseif ($value["state"] == 1) {
                $state = "WARNING";
                echo '<font color=\"yellow\">' . $host .  ': ' . $value["description"] . ', ' . $state . '</font><br />';

        } elseif ($value["state"] == 2) {
                $state = "CRITICAL";
                echo '<font color=\"red\">' . $host .  ': ' . $value["description"] . ', ' . $state . '</font><br />';

        } elseif ($value["state"] == 3) {
                $state = "UNKNOWN";
                echo '<font color=\"orange\">' . $host .  ': ' . $value["description"] . ', ' . $state . '</font><br />';
        
}
  }



echo "<hr></pre></body></html>";

  


?> 
