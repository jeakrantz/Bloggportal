<?php
/* 
*   Webbutveckling II - DT093G
*   Projektuppgift 
*   Blogg-portal
*
*   Utvecklare: Jeanette Krantz
*   2023-03-19
*/

class Post
{
    //Properties
    private $db;
    private $title;
    private $content;
    private $image;

    // Constructor 
    function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Fel vid anslutning: " . $this->db->connect_error);
        }
    }

    //Add post
    public function addPost(string $title, string $content, $user_id): bool
    {

        if (!$this->setTitle($title)) return false;
        if (!$this->setContent($content)) return false;


        //Lite säkerhet
        $this->title = $this->db->real_escape_string($this->title);
        $this->content = $this->db->real_escape_string($this->content);

        $this->title = strip_tags($this->title, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->content = strip_tags($this->content, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');

        $sql = "INSERT INTO blogpost(title, content, user_id)VALUES('" . $this->title . "', '" . $this->content . "' , '"  . $user_id . "');";

        //Send sql query
        return mysqli_query($this->db, $sql);
    }


    //Add post with image
    public function addPostWithImage(string $title, string $content, $image, $user_id): bool
    {

        if (!$this->setTitle($title)) return false;
        if (!$this->setContent($content)) return false;
        if (!$this->setImage($image)) return false;

        if (!$this->uploadImage($image)) return false;

        //Lite säkerhet
        $this->title = $this->db->real_escape_string($this->title);
        $this->content = $this->db->real_escape_string($this->content);

        $this->title = strip_tags($this->title, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->content = strip_tags($this->content, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');

        $sql = "INSERT INTO blogpost(title, content, imagefile, user_id)VALUES('" . $this->title . "', '" . $this->content . "' , '"  . $this->image . "' , '" . $user_id . "');";

        //Send sql query
        return mysqli_query($this->db, $sql);
    }

    public function uploadImage($image)
    {
        //Kontrollerar att uppladdad bild är av rätt typ (JPEG) och fil-storleken
        if ((($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"] ==
            "image/pjpeg")) && ($_FILES["image"]["size"] < 200000)) {
            if ($_FILES["image"]["error"] > 0) {
                return "Felmeddelande: " . $_FILES["image"]["error"] . "<br />";
            } else {

                //Flyttar filen till rätt katalog      
                move_uploaded_file($_FILES["image"]["tmp_name"], "images/upload/" . $_FILES["image"]["name"]);

                return true;
            }
        } else {
            // Här hamnar man om det inte är JPEG/bildfil för stor
            return false;
        }
    }


    //Get post
    public function getPost(): array
    {
        $sql = "SELECT * FROM blogpost ORDER BY postdate DESC;";
        $result = mysqli_query($this->db, $sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    //get limited posts
    public function getLimitPost($limit): array
    {

        $sql = "SELECT * FROM blogpost ORDER BY postdate DESC LIMIT $limit;";
        $result = mysqli_query($this->db, $sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    //get post by specific user_id
    public function getPostByUser($id): array
    {
        $sql = "SELECT * FROM blogpost WHERE user_id=$id ORDER BY postdate DESC;";
        $result = mysqli_query($this->db, $sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    //Delete post
    public function deletePost(int $id): bool
    {
        $id = intval($id);

        $sql = "DELETE FROM blogpost WHERE postid=$id;";

        return mysqli_query($this->db, $sql);
    }


    //Update post
    public function updatePost(int $id, string $title, string $content): bool
    {
        if (!$this->setTitle($title)) return false;
        if (!$this->setContent($content)) return false;


        $this->title = $this->db->real_escape_string($this->title);
        $this->content = $this->db->real_escape_string($this->content);

        $this->title = strip_tags($this->title, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->content = strip_tags($this->content, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');

        $sql = "UPDATE blogpost SET title='" . $this->title . "', content='" . $this->content . "' WHERE postid=$id;";

        return mysqli_query($this->db, $sql);
    }

    //Update post with image
    public function updatePostWithImage(int $id, string $title, string $content, $image): bool
    {
        if (!$this->setTitle($title)) return false;
        if (!$this->setContent($content)) return false;
        if (!$this->setImage($image)) return false;

        $this->uploadImage($image);

        $this->title = $this->db->real_escape_string($this->title);
        $this->content = $this->db->real_escape_string($this->content);

        $this->title = strip_tags($this->title, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->content = strip_tags($this->content, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');

        $sql = "UPDATE blogpost SET title='" . $this->title . "', content='" . $this->content . "', imagefile='" . $this->image . "' WHERE postid=$id;";

        return mysqli_query($this->db, $sql);
    }

    //Get post by id
    public function getPostById(int $id): array
    {
        $id = intval($id);
        $sql = "SELECT * FROM blogpost WHERE postid=$id;";
        $result = mysqli_query($this->db, $sql);
        return $result->fetch_assoc();
    }


    //Set methods
    public function setTitle(string $title): bool
    {
        if ($title != "") {
            $this->title = $title;
            return true;
        } else {
            return false;
        }
    }

    public function setContent(string $content): bool
    {
        if ($content != "") {
            $this->content = $content;
            return true;
        } else {
            return false;
        }
    }
    public function setImage($image): bool
    {
        if ($image['name'] != "") {
            $this->image = $image['name'];
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
