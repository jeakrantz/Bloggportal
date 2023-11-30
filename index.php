<?php
/* 
*   Webbutveckling II - DT093G
*   Projektuppgift 
*   Blogg-portal
*
*   Utvecklare: Jeanette Krantz
*   2023-03-19
*/

$page_title = "Startsida";
$active1 = "active green";

include("includes/header.php");
include("includes/sidebar.php");
?>

<main class="content">
    <div class="container">
        <h1>Din bloggportal om Livet.</h1>
        <!-- Direkt-knapp till register.php, syns bara om man inte är inloggad. -->
        <?php
        if (!isset($_SESSION['userid'])) {
        ?>
            <a class="btn green center" href="register.php">Bli bloggare på Livet. <i class="fa-solid fa-user-plus"></i></a>
        <?php
        }
        ?>
        <h2>Livet på en pinne.</h2>
    </div>
    <section>
        <h2>Nya inlägg om Livet.</h2>
        <div class="new-blogpost">
            <?php
            $user = new User();

            $post = new Post();

            $post_list = $post->getLimitPost(5);

            foreach ($post_list as $p) {
                $u = $user->getUserById($p['user_id']);
            ?>
                <article>
                    <div class="article-title">
                        <div class="left-title">
                            <p class="title-user"><i class="fa-solid fa-circle-user"></i><?= $u['name']; ?></p>
                            <h3><?= $p['title']; ?></h3>
                        </div>
                        <a class="btn top-article smaller-link" href="blogpost.php?postid=<?= $p['postid']; ?>">Läs mer <i class="fa-solid fa-angle-right"></i></a>
                    </div>
                    <div class="article-content">
                        <div class="article-image">
                            <picture>
                                <?php
                                if ($p['imagefile'] == NULL) {
                                    $image = "placeholder.svg";
                                } else {
                                    $image = "upload/" . $p['imagefile'];
                                }
                                ?>
                                <img src="images/<?= $image; ?>" alt="Ingen bild tillgänglig.">
                            </picture>
                        </div>
                        <div class="article-text"><?= mb_substr($p['content'], 0, 150); ?>...</div>
                    </div>
                    <div class="article-link">
                        <a class="btn smaller-link" href="blogpost.php?postid=<?= $p['postid']; ?>">Läs mer <i class="fa-solid fa-angle-right"></i></a>
                    </div>
                </article>
            <?php
            }

            ?>

        </div>
    </section>
    <section>
        <!-- Visar random quote från databasen -->
        <div class="container blue quote">
            <?php
            $quote = new Quote();

            $quoteid = rand(1, 10);

            $q = $quote->getQuoteById($quoteid);
            ?>

            <h2><?= $q['quotetext']; ?></h2>
        </div>
    </section>

    <section>
        <h2>Nya bloggare på Livet.</h2>
        <div class="user-box">
            <?php
            $user = new User();

            $user_list = $user->getLimitUser(3);

            foreach ($user_list as $u) {
            ?>
                <article class="user-info">
                    <div class="user-header">
                        <h2><?= $u['name']; ?></h2>
                    </div>
                    <div class="member-time">
                        <p>Medlem sedan: <?= substr($u['create_date'], 0, 10); ?></p>
                    </div>
                    <div class="post-link"><a href="specblog.php?userid=<?= $u['userid']; ?>" class="btn yellow">Se inlägg <i class="fa-solid fa-arrow-right"></i></a></div>
                </article>
            <?php
            }

            ?>
        </div>
    </section>
    <section>
        <!-- Visar random quote från databasen -->
        <div class="container red quote">
            <?php
            $quote = new Quote();

            $quoteid = rand(1, 10);

            $q = $quote->getQuoteById($quoteid);
            ?>

            <h2><?= $q['quotetext']; ?></h2>
        </div>
    </section>
    <script>

    </script>
</main>

<?php include("includes/footer.php") ?>