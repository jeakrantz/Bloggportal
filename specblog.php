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

//Kontroll om id skickats
if (isset($_GET['userid'])) {
    $id = intval($_GET['userid']);

    $user = new User();

    //Hämta information om nyheten
    $details = $user->getUserById($id);
} else {
    header("location: index.php");
}

?>


<?php
$page_title = "Blogg för " . $details['name'];

include("includes/header.php");
include("includes/sidebar.php");
?>

<main class="content">
    <section>
        <button onclick="history.back()" class="btn black"><i class="fa-solid fa-angle-left"></i> Tillbaka</button>
        <?php
        $post = new Post();

        $post_list = $post->getPostByUser($id);

        foreach ($post_list as $p) {
        ?>
            <article class="single-article list">
                <div class="post-header">
                    <h2><?= $p['title']; ?></h2>
                </div>
                <div class="post-time">
                    <p>Publicerad: <?= $p['postdate']; ?></p>
                </div>
                <div class="post-text">
                    <p><?= mb_substr($p['content'], 0, 150); ?>...</p>
                </div>
                <div class="post-link"><a href="blogpost.php?postid=<?= $p['postid']; ?>" class="btn">Läs mer <i class="fa-solid fa-arrow-right"></i></a></div>
            </article>
        <?php
        }

        ?>
    </section>
</main>

<?php
include("includes/footer.php"); ?>