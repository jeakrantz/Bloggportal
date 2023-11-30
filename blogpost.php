<?php
/* 
*   Webbutveckling II - DT093G
*   Projektuppgift 
*   Blogg-portal
*
*   Utvecklare: Jeanette Krantz
*   2023-03-19
*/

include_once("includes/config.php");

// Ränka besök på sidan
// $sql = mysql_query(" UPDATE blogposts SET views + 1 WHERE id = '$id' "); exempel på sql för att räkna views

if (isset($_SESSION['views']))
    $_SESSION['views'] = $_SESSION['views'] + 1;
else
    $_SESSION['views'] = 1;

/* echo "views = " . $_SESSION['views']; */

//Kontroll om id skickats
if (isset($_GET['postid'])) {
    $id = intval($_GET['postid']);

    $post = new Post();

    //Hämta information om nyheten
    $details = $post->getPostById($id);
} else {
    header("location: index.php");
}

$user = new User();
$u = $user->getUserById($details['user_id']);

?>


<?php
$page_title = $details['title'];

include("includes/header.php");
include("includes/sidebar.php");
?>

<main class="content">
    <section>
        <button onclick="history.back()" class="btn black"><i class="fa-solid fa-angle-left"></i> Tillbaka</button>

        <article class="single-article">
            <div class="article-title">
                <h1><?= $details['title']; ?></h1>
            </div>
            <p class="title-user center"><i class="fa-solid fa-circle-user"></i> <?= $u['name']; ?> | Publicerad: <?= $details['postdate']; ?></p>
            <div class="article-content">
                <div class="article-image">
                    <picture>
                        <?php
                        if ($details['imagefile'] == NULL) {
                            $image = "placeholder.svg";
                        } else {
                            $image = "upload/" . $details['imagefile'];
                        }
                        ?>
                        <img src="images/<?= $image; ?>" alt="Ingen bild tillgänglig.">
                    </picture>
                </div>
                <div class="article-text"><?= $details['content']; ?></div>
            </div>
        </article>
    </section>
</main>

<?php
include("includes/footer.php"); ?>