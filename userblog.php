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
$page_title = "Dina inlägg";
$active6 = "active";

include("includes/header.php");
include("includes/sidebar.php");

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
?>

<main class="content">
    <section class="container">
        <h1>Dina inlägg</h1>
        <?php

        $post_list = $post->getPostByUser($_SESSION['userid']);

        foreach ($post_list as $p) {
        ?>
            <article class="single-article list">
                <div class="article-title">
                    <h2><?= $p['title']; ?></h2>
                </div>
                <div class="post-time">
                    <p>Publicerad: <?= $p['postdate']; ?></p>
                </div>
                <div class="post-link"><a href="blogpost.php?postid=<?= $p['postid']; ?>" class="btn green">Se mer <i class="fa-solid fa-arrow-right"></i></a></div>
                <div class="btn-div">
                    <a class="btn yellow" href="edit.php?postid=<?= $p['postid']; ?>">Ändra</a>
                    <button onclick="showPopup(<?= $p['postid']; ?>)" class="deletebtn btn red">Radera</button>
                </div>
            </article>
        <?php
        }

        ?>
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

<script src="js/popup.js"></script>

<?php
include("includes/footer.php"); ?>