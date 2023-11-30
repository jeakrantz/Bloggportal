<?php
/* 
*   Webbutveckling II - DT093G
*   Projektuppgift 
*   Blogg-portal
*
*   Utvecklare: Jeanette Krantz
*   2023-03-19
*/

$page_title = "Logga in";
$active5 = "active";

include("includes/config.php");
?>
<?php


if (isset($_POST['email'])) {
    $user = new User();
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($user->loginUser($email, $password)) {
        header('location: admin.php');
    } else {
        $message = "Felaktigt användarnamn / lösenord!";
    }
}

?>

<?php
include("includes/header.php");
include("includes/sidebar.php");
?>

<main class="content">
    <section class="container">
        <div>
            <h1>Logga in</h1>
            <?php
            if (isset($_SESSION['errormsg'])) {
                //Error om hitskickad pga ej inloggad
                echo "<p class='errormsg'>" . $_SESSION['errormsg'] . "</p>";
            }
            unset($_SESSION['errormsg']);

            if (isset($message)) {
                echo "<p class='errormsg'>" . $message . "</p>";
            }
            ?>

            <div class="container-small login-box">
                <form method="post" action="login.php">
                    <label for="email">Epost: </label>
                    <br>
                    <input type="text" name="email" id="email">
                    <br>
                    <label for="password">Lösenord: </label>
                    <br>
                    <input type="password" name="password" id="password">
                    <br>
                    <input type="submit" value="Logga in" class="btn black center">
                </form>
            </div>
            <p>Är du inte en registrerad användare på bloggportalen?</p>
            <br>
            <a class="btn center" href="register.php">Registrera ny användare <i class="fa-solid fa-user-plus"></i></a>
        </div>

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