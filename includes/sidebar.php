<!-- 
*   Webbutveckling II - DT093G
*   Projektuppgift 
*   Blogg-portal
*
*   Utvecklare: Jeanette Krantz
*   2023-03-19
-->

<div class="menu-toggle">
    <div class="menu-icon">
        <i class="fa-solid fa-bars"></i>
    </div>
</div>

<aside class="sidebar">
    <div class="menu">
        <div class="logo">
            <a href="index.php">Livet.</a>
        </div>
        <nav>
            <ul>
                <li><a href="index.php" class="menu-item <?= $active1 ?> ">Startsida <i class="fa-solid fa-house"></i></a></li>
                <li><a href="archive.php" class="menu-item <?= $active2 ?>">Arkiv <i class="fa-solid fa-box-archive"></i></a></li>
                <li><a href="users.php" class="menu-item <?= $active3 ?>">Bloggare <i class="fa-solid fa-users"></i></a></li>
                <?php
                /* Syns bara om man är inloggad */
                if (isset($_SESSION['userid'])) {
                ?>
                    <li><a class="menu-item <?= $active4 ?>" href="admin.php">Skapa inlägg <i class="fa-solid fa-square-pen"></i></a></li>
                    <li><a class="menu-item <?= $active6 ?>" href="userblog.php">Dina inlägg <i class="fa-solid fa-circle-user"></i></a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
    </div>
    <!-- Ändras beroende på om man är inloggad eller ej -->
    <div class="login">
        <?php
        if (!isset($_SESSION['userid'])) {
        ?>
            <a class="btn black <?= $active5 ?>" href="login.php">Logga in</a>
        <?php
        } else {
        ?>
            <a href="logout.php" class="btn black">Logga ut</a>
        <?php
        }
        ?>

    </div>
</aside>
<div class="all-container">