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
$sql = "DROP TABLE IF EXISTS quotes;";

$sql .= "
CREATE TABLE quotes(
    quoteid INT(11) PRIMARY KEY AUTO_INCREMENT, 
    quotetext TEXT NOT NULL
); 
";

$sql .= "
INSERT INTO quotes(quotetext) 
VALUES('Många bäckar små.');    
";

$sql .= "
INSERT INTO quotes(quotetext) 
VALUES('Fyll inte livet med dagar, fyll dagarna med liv.');    
";

$sql .= "
INSERT INTO quotes(quotetext) 
VALUES('Livet är inte ett problem som ska lösas utan en verklighet som ska upplevas. - Sören Kierkegaard');    
";

$sql .= "
INSERT INTO quotes(quotetext) 
VALUES('What doesn''t kill us makes us stronger. - Friedrich Nietzsche');    
";

$sql .= "
INSERT INTO quotes(quotetext) 
VALUES('When nothing goes right, go left');    
";

$sql .= "
INSERT INTO quotes(quotetext) 
VALUES('Antigen så hittar jag en väg, eller så skapar jag en. - Philip Sidney');    
";

$sql .= "
INSERT INTO quotes(quotetext) 
VALUES('Den tid du tycker om att slösa bort är inte bortslösad tid. - Marthe Troly-Curtin');    
";

$sql .= "
INSERT INTO quotes(quotetext) 
VALUES('Det outforskade livet är inte värt att levas. - Sokrates');    
";

$sql .= "
INSERT INTO quotes(quotetext) 
VALUES('Där kärlek finns, finns liv. - Ghandi');    
";

$sql .= "
INSERT INTO quotes(quotetext) 
VALUES('Livet är för viktigt för att tas seriöst. - Oscar Wilde');    
";

echo "<pre>$sql</pre>";

//Skicka SQL-frågorna till server
if($db -> multi_query($sql)) {
    echo "Tabell installerad.";
} else {
    echo "Fel vid installation av tabell.";
}

$db->close();
