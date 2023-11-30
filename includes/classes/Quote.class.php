<?php
/* 
*   Webbutveckling II - DT093G
*   Projektuppgift 
*   Blogg-portal
*
*   Utvecklare: Jeanette Krantz
*   2023-03-19
*/

class Quote
{
    private $db;
    private $quote;


    // Constructor 
    function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Fel vid anslutning: " . $this->db->connect_error);
        }
    }


    public function setQuote(string $quote): bool
    {
        if ($quote != "") {
            $this->quote = $quote;
            return true;
        } else {
            return false;
        }
    }

    public function getQuote(): array
    {
        $sql = "SELECT * FROM quotes;";
        $result = mysqli_query($this->db, $sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }


    public function getQuoteById(int $id): array
    {
        $id = intval($id);
        $sql = "SELECT * FROM quotes WHERE quoteid=$id;";
        $result = mysqli_query($this->db, $sql);
        return $result->fetch_assoc();
    }




    // Destructor
    function __destruct()
    {
        mysqli_close($this->db);
    }
}
