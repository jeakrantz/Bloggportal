<?php
/* 
*   Webbutveckling II - DT093G
*   Projektuppgift 
*   Blogg-portal
*
*   Utvecklare: Jeanette Krantz
*   2023-03-19
*/


$page_title = "Bloggare";
$active3 = "active";

include("includes/header.php");
include("includes/sidebar.php");
?>

<main class="content">
    <section class="container">
        <h1>Bloggare</h1>
        <p>Här syns alla registerade användare i bloggportalen.</p>
        <div class="user-box">
            <?php
            $user = new User();

            $user_list = $user->getUser();

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
        <div class="container green quote">
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