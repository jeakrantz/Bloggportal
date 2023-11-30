<?php
/* 
*   Webbutveckling II - DT093G
*   Projektuppgift 
*   Blogg-portal
*
*   Utvecklare: Jeanette Krantz
*   2023-03-19
*/

include("includes/config.php");

//Anslut
$db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
if($db->connect_errno > 0) {
    die("Fel vid anslutning: " . $db->connect_error);
}

// SQL-frågor
$sql = "DROP TABLE IF EXISTS blogpost;";

$sql .= "
CREATE TABLE blogpost(
    postid INT(11) PRIMARY KEY AUTO_INCREMENT, 
    title VARCHAR(128) NOT NULL,
    content TEXT NOT NULL,
    postdate timestamp NOT NULL DEFAULT current_timestamp(),
    imagefile VARCHAR (256),
    user_id INT(11) NOT NULL
); 
";

$sql .= "DROP TABLE IF EXISTS user;"; 

$sql .= "
CREATE TABLE user(
    userid INT(11) PRIMARY KEY AUTO_INCREMENT, 
    email VARCHAR(128) NOT NULL,
    password VARCHAR(256) NOT NULL,
    name VARCHAR (128) NOT NULL,
    create_date timestamp NOT NULL DEFAULT current_timestamp()
); 
";

echo "<pre>$sql</pre>";

//Skicka SQL-frågorna till server
if($db -> multi_query($sql)) {
    echo "Tabell installerad.";
} else {
    echo "Fel vid installation av tabell.";
}

$db->close();
