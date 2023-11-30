<?php
/* 
*   Webbutveckling II - DT093G
*   Projektuppgift 
*   Blogg-portal
*
*   Utvecklare: Jeanette Krantz
*   2023-03-19
*/

class User
{
    //properties
    private $db;
    private $email;
    private $password;
    private $name;

    // Constructor 
    function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Fel vid anslutning: " . $this->db->connect_error);
        }
    }

    //Login a user
    public function loginUser(string $email, string $password): bool
    {
        if (!$this->setEmail($email)) return false;
        if (!$this->setPassword($password)) return false;

        $this->email = $this->db->real_escape_string($this->email);
        $this->password = $this->db->real_escape_string($this->password);

        $sql = "SELECT * FROM user WHERE email='$this->email';";

        $result = $this->db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id = $row['userid'];
            $stored_password = $row['password'];

            if (password_verify($password, $stored_password)) {
                $_SESSION['userid'] = $id;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //register a user
    public function registerUser(string $email, string $password, string $name): bool
    {
        if (!$this->setEmail($email)) return false;
        if (!$this->setPassword($password)) return false;
        if (!$this->setName($name)) return false;

        $this->email = $this->db->real_escape_string($this->email);
        $this->password = $this->db->real_escape_string($this->password);
        $this->name = $this->db->real_escape_string($this->name);

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user(email, password, name)VALUES('$email', '$hashed_password', '$name');";
        $result = $this->db->query($sql);

        return $result;
    }

    //check if user is logged in
    public function isLoggedIn(): bool
    {
        if (isset($_SESSION['userid'])) {
            return true;
        } else {
            return false;
        }
    }

    //get user 
    public function getUser(): array
    {
        $sql = "SELECT * FROM user ORDER BY create_date DESC;";
        $result = mysqli_query($this->db, $sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // get specific user by id
    public function getUserById(int $id): array
    {
        $id = intval($id);
        $sql = "SELECT * FROM user WHERE userid=$id;";
        $result = mysqli_query($this->db, $sql);
        return $result->fetch_assoc();
    }

    // get limited users
    public function getLimitUser($limit): array
    {

        $sql = "SELECT * FROM user ORDER BY create_date DESC LIMIT $limit;";
        $result = mysqli_query($this->db, $sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }


    //Set methods
    public function setEmail(string $email): bool
    {
        if ($email != "") {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->email = $email;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function setPassword(string $password): bool
    {
        if ($password != "") {
            if (strlen($password) > 6) {
                $this->password = $password;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function setName(string $name): bool
    {
        if ($name != "") {
            $this->name = $name;
            return true;
        } else {
            return false;
        }
    }

    // Destructor
    function __destruct()
    {
        mysqli_close($this->db);
    }
}
