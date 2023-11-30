<?php
/* 
*   Webbutveckling II - DT093G
*   Projektuppgift 
*   Blogg-portal
*
*   Utvecklare: Jeanette Krantz
*   2023-03-19
*/


include("includes/config.php"); ?>

<?php
//Kontroll om inloggad

$user = new User();

if (!$user->isLoggedIn()) {
    $_SESSION['errormsg'] = "Du måste vara inloggad för att skriva nyheter.";
    header("location: login.php");
}


$post = new Post();


//Kontroll om det finns id lagrat
if (isset($_GET['postid'])) {
    $id = intval($_GET['postid']);

    if (isset($_POST['title'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];

        if (isset($_FILES['image'])) {
            $image = $_FILES['image'];
        } else {
            $image = NULL;
        }

        $success = true;

        $message = "";

        //Felmeddelande rubrik
        if (!$post->setTitle($title)) {
            $success = false;
            $message .= "<p class='errormsg'>Du måste ange en rubrik.</p>";
        }
        //Felmeddelande Innehåll
        if (!$post->setContent($content)) {
            $success = false;
            $message .= "<p class='errormsg'>Du måste skriva inläggstext.</p>";
        }

        if ($success) {
            if ($image != NULL) {
                $image = $_FILES['image'];
                if ($post->updatePostWithImage($id, $title, $content, $image)) {

                    echo "<p class='goodmsg'>Ändringar sparade!</p>";
                } else {
                    echo "<p class='errormsg'>Fel vid lagring av inlägget.</p>";
                }
            } else {
                if ($post->updatePost($id, $title, $content)) {
                    $message .= "<p class='goodmsg'>Ändringar sparade!</p>";
                } else {
                    $message .= "<p class='errormsg'>Fel vid uppdatering av inlägget.</p>";
                }
            }
        } else {
            $message .= "<p class='errormsg'>Ändringar ej sparade. Kontrollera fälten och försök igen.</p>";
        }
    }
    //Hämta information om nyheten
    $details = $post->getPostById($id);
}

$page_title = "Ändra nyhet - " . $details['title'];

?>

<?php include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>


<main class="content">

    <section class="container">
        <button onclick="history.back()" class="btn black"><i class="fa-solid fa-angle-left"></i> Tillbaka</button>
        <div>
            <h2 class="title-text">Ändra inlägg</h2>
        </div>
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
        <div class="container container-small">
            <form action="edit.php?postid=<?= $id ?>" method="post" enctype="multipart/form-data">
                <label for="title">Rubrik: </label>
                <br>
                <input type="text" name="title" id="title" placeholder="Nyhetens rubrik..." value="<?= $details['title']; ?>">
                <br>
                <label for="content">Inlägg: </label>
                <br>
                <textarea name="content" id="content" placeholder="Skriv ditt inlägg här..." rows="10"><?= $details['content']; ?></textarea>
                <br>
                <?php
                if ($details['imagefile'] == NULL) {
                ?>
                    <input type="hidden" name="MAX_FILE_SIZE" value="200000" /> <!-- 200K max storlek -->
                    <label for="image">Bild: </label>
                    <br>
                    <input type="file" name="image" id="image">
                    <br>
                <?php
                } else {
                ?>
                    <picture>
                        <img src="images/upload/thumb_<?= $details['imagefile']; ?>" alt="Ingen bild tillgänglig.">
                    </picture>
                <?php
                }
                ?>
                <button type="submit" class="btn right green"><i class='fa-solid fa-plus'></i>Uppdatera inlägg</button>
            </form>
        </div>
    </section>
</main>
<script>
    ClassicEditor
        .create(document.querySelector('#content'))
        .catch(error => {
            console.error(error);
        });
</script>


<?php
include("includes/footer.php"); ?>