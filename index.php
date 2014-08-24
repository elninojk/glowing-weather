<!DOCTYPE html>
<html lang="en">

<head>

</head>
<body >


<?php
    require ('includes/html_table.class.php');
    // $auth = base64_encode('username:password'); 

    // $opts = array( 
    // 'http' => array ( 
    //     'method'=>'GET', 
    //     'proxy'=>'tcp://10.100.9.115:8080', 
    //     'request_fulluri' => true, 
    //     'header'=> array("Proxy-Authorization: Basic $auth", "Authorization: Basic $auth") 

    // ), 
    // 'https' => array ( 
    //     'method'=>'GET', 
    //     'proxy'=>'tcp://10.100.9.115:8080', 
    //     // 'proxy'=>'tcp://69.162.120.112:62266', 
    //     'request_fulluri' => true, 
    //     'header'=> array("Proxy-Authorization: Basic $auth", "Authorization: Basic $auth") 
    // ) 
    // ); 
    // $ctx = stream_context_create($opts);


    // // echo "Weather Application  ";
    // $response = file_get_contents('http://api.openweathermap.org/data/2.5/weather?q=Kochi,IN',false, $ctx);

     $response = file_get_contents('http://api.openweathermap.org/data/2.5/weather?q=Kochi,IN');
    // $ch = curl_init();
    // curl_setopt($ch, CURLOPT_URL, $url);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($ch, CURLOPT_REFERER, 'http://api.openweathermap.org/data/2.5/weather?q=Kochi,IN');
    // $response = curl_exec($ch);
    // curl_close($ch);
    $response = json_decode($response,true);
    if ($response == FALSE) {
        echo "Nothing";
    }
    // echo "LEN" . sizeof($response);
    echo "<br>";
    echo "<br>";
    // var_dump($response);
    // echo "Location <br>";
    // echo "Langitude " . $response['coord']['lon'];
    // echo "<br>";
    // echo "Latitude " . $response['coord']['lat'];
    // echo "<br>";
    // echo "Country " . $response['sys']['country'];
    // echo "<br>";
    // echo "Description " . $response['weather'][0]['description'];
    // echo "<br>";
    // echo "Temp  :" . ($response['main']['temp'] - 273.15) . " Degrees" ;
    // echo "<br>";
    // echo "City " . $response['name'];

    
    $database = "test";  // the name of the database.
    $server = "localhost:3306";  // server to connect to.
    $db_user = "root";  // mysql username to access the database with.
    $db_pass = "password";  // mysql password to access the database with.
    //Changed from weather to test.weather
    $table = "test.weather";    // the table that this script will set up and use.

    $link = mysql_connect($server, $db_user, $db_pass);
    mysql_select_db($database,$link);


    // INSERT INTO `test`.`weather` (`id`, `City`, `Country`, `Temp`, `Condition`) VALUES ('1', 'kochin', 'India', '23', 'cloudy');
    

    //Get the newest data.

    $country = $response['sys']['country'];
    $city = $response['name'];
    $temp = (($response['main']['temp'] - 273.15));
    // echo "Tempp " . $temp;
    $desc = $response['weather'][0]['description'];


    // $country = "India";
    // $city = "Kochi";
    // $temp = "26";
    // // echo "Tempp " . $temp;
    // $desc = "details";


    //Create the statement 
    // $stmt = "INSERT INTO 'test'.`weather` (`City`, `Country`, `Temp`, `Condition`) VALUES ('$city', '$country', '$temp', '$desc')";

    $stmt = "INSERT INTO `test`.`weather` (`City`,`Country`,`Condition`,`Temp`) VALUES ('$city','$country','$desc',$temp)";

    // "INSERT INTO Persons (FirstName, LastName, Age) VALUES ('Peter', 'Griffin',35)"
    // echo "Statementr " . $stmt;
    // Insert the query
    mysql_query($stmt);
    mysql_close($link);


    $link = mysql_connect($server, $db_user, $db_pass);
    mysql_select_db($database,$link);
    //Get All contents of table
    $match = "SELECT * FROM test.weather;";
    $qry = mysql_query($match);
    $num_rows = mysql_num_rows($qry);

    //Get the data
    $row = mysql_fetch_array($qry);

    // echo "Row is " . $row;
    // echo "<br> Number of rows" . $num_rows;
  


    $tbl = new HTML_Table('', 'demoTbl');
    $tbl->addCaption("Weather Application", 'cap', array('id' => 'tblCap'));

    $tbl->addRow();
    $tbl->addCell("City ", 'data');
    $tbl->addCell($row['City'], 'data');

    $tbl->addRow();
    $tbl->addCell("Country ", 'data');
    $tbl->addCell($row['Country'], 'data');

    $tbl->addRow();
    $tbl->addCell("Temperature ", 'data');
    $tbl->addCell($row['Temp'], 'data');

    $tbl->addRow();
    $tbl->addCell("Condition ", 'data');
    $tbl->addCell($row['Condition'] , 'data');

    echo $tbl->display();
    
?>    
</body>

</html>
