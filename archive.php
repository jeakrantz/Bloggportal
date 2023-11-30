<?php

/* 
*   Webbutveckling II - DT093G
*   Projektuppgift 
*   Blogg-portal
*
*   Utvecklare: Jeanette Krantz
*   2023-03-19
*/

$page_title = "Arkiv";
$active2 = "active";

include("includes/header.php");
include("includes/sidebar.php");
?>

<main class="content">
    <section>
        <div class="container">
            <h1>Arkiv</h1>
            <p>Arkiv över alla inlägg på bloggportalen. Sorteras nyast först.</p>
        </div>
        <?php
        $post = new Post();

        $post_list = $post->getPost();

        foreach ($post_list as $p) {
        ?>
            <article class="single-article list">
                <div class="article-title">
                    <h2><?= $p['title']; ?></h2>
                </div>
                <div class="post-time">
                    <p>Publicerad: <?= $p['postdate']; ?></p>
                </div>
                <div class="article-content">
                    <div class="post-text"><?= mb_substr($p['content'], 0, 150); ?>...</div>
                    <a href="blogpost.php?postid=<?= $p['postid']; ?>" class="post-link btn green">Läs mer <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </article>
        <?php
        }

        ?>
    </section>
    <section>
        <!-- Visar random quote från databasen -->
        <div class="container yellow quote">
            <?php
            $quote = new Quote();

            $quoteid = rand(1, 10);

            $q = $quote->getQuoteById($quoteid);
            ?>

            <h2><?= $q['quotetext']; ?></h2>
        </div>
    </section>
</main>

<?php
include("includes/footer.php"); ?>