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
?>

<?php
$page_title = "Skapa inlägg";
$active4 = "active";

include("includes/header.php"); ?>
<?php include("includes/sidebar.php"); ?>


<main class="content">

    <section class="container">

        <div>
            <h2 class="title-text">Skriv inlägg</h2>
        </div>

        <?php
        $post = new Post();

        //Radera nyhet
        if (isset($_GET['deleteid'])) {
            $deleteid = intval($_GET['deleteid']);

            if ($post->deletePost($deleteid)) {
                echo "<p class='goodmsg'>Inlägget är raderat!</p>";
                unset($_GET['deleteid']);
            } else {
                echo "<p class='errormsg'>Fel vid radering av inlägget.</p>";
                unset($_GET['deleteid']);
            }
        }

        //Standardvärden
        $title = "";
        $content = "";
        $image = "";

        if (isset($_POST['title'])) {
            $title = $_POST['title'];
            $content = $_POST['content'];

            $success = true;
            //Felmeddelande rubrik
            if (!$post->setTitle($title)) {
                $success = false;
                echo "<p class='errormsg'>Du måste ange en rubrik.</p>";
            }
            //Felmeddelande Innehåll
            if (!$post->setContent($content)) {
                $success = false;
                echo "<p class='errormsg'>Du måste skriva en inläggstext.</p>";
            }

            if ($_FILES['image']['size'] >= 200000) {
                $success = false;
                echo "<p class='errormsg'>Bilden får max vara 200kB.</p>";
                $image = "";
            }

            if ($success) {
                if ($_FILES['image']['error'] <= 0) {
                    $image = $_FILES['image'];
                    if ($post->addPostWithImage($title, $content, $image, $_SESSION['userid'])) {

                        echo "<p class='goodmsg'>Inlägget är publicerat!</p>";
                        //Standardvärden
                        $title = "";
                        $content = "";
                        $image = "";
                    } else {
                        echo "<p class='errormsg'>Fel vid lagring av inlägget.</p>";
                    }
                } else {
                    if ($post->addPost($title, $content, $_SESSION['userid'])) {

                        echo "<p class='goodmsg'>Inlägget är publicerat! </p>";
                        //Standardvärden
                        $title = "";
                        $content = "";
                    } else {
                        echo "<p class='errormsg'>Fel vid lagring av inlägget.</p>";
                    }
                }
            } else {
                echo "<p class='errormsg'>Inlägget är ej tillagt. Kontrollera fälten och försök igen.</p>";
            }
        }
        ?>
        <div class="container container-small">
            <form action="admin.php" method="post" enctype="multipart/form-data">
                <label for="title">Rubrik: </label>
                <br>
                <input type="text" name="title" id="title" placeholder="Nyhetens rubrik..." value="<?= $title; ?>">
                <br>
                <label for="content">Inlägg: </label>
                <br>
                <textarea name="content" id="content" placeholder="Skriv ditt inlägg här..." rows="10"><?= $content; ?></textarea>
                <br>
                <input type="hidden" name="MAX_FILE_SIZE" value="200000" /> <!-- 200K max storlek -->
                <label for="image">Bild: </label>
                <br>
                <input type="file" name="image" id="image">
                <br>
                <button type="submit" class="btn right green"><i class='fa-solid fa-plus'></i> Publicera inlägg</button>
            </form>
        </div>

        <div class="table-container">
            <h2 class="title-text">Dina publicerade inlägg</h2>
            <table>
                <thead>
                    <tr>
                        <th>Rubrik</th>
                        <th>Publicerad</th>
                        <th>Ändra</th>
                        <th>Radera</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $post_list = $post->getPostByUser($_SESSION['userid']);

                    foreach ($post_list as $p) {
                    ?>
                        <tr>
                            <td><?= $p['title']; ?></td>
                            <td><?= $p['postdate']; ?></td>
                            <td><a class="btn yellow" href="edit.php?postid=<?= $p['postid']; ?>">Ändra</a></td>
                            <!-- Aktiverar popupen -->
                            <td><button onclick="showPopup(<?= $p['postid']; ?>)" class="deletebtn btn red">Radera</button></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Popupen för att bekräfta radering av inlägg -->
        <div id="popup" class="popup">
            <div class="container">
                <h1>Radera inlägg</h1>
                <p>Är du säker på att du vill radera inlägget?</p>

                <div class="btn-div">
                    <button type="button" class="cancelbtn btn" onclick="hidePopup()">Tillbaka</button>
                    <a id="delete-link" class="btn red deletebtn" href="#">Radera</a>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    ClassicEditor
        .create(document.querySelector('#content'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script>

<script src="js/popup.js"></script>

<?php
include("includes/footer.php"); ?>