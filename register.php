<?php
/* 
*   Webbutveckling II - DT093G
*   Projektuppgift 
*   Blogg-portal
*
*   Utvecklare: Jeanette Krantz
*   2023-03-19
*/

$page_title = "Registrera ny användare";

include("includes/config.php");
?>

<?php
include("includes/header.php");
include("includes/sidebar.php");
?>

<main class="content">
    <section class="container">
        <button onclick="history.back()" class="btn black"><i class="fa-solid fa-angle-left"></i> Tillbaka</button>
        <div>
            <h1>Registrera ny användare</h1>

            <div class="container-small">
                <form method="post" action="register.php">
                    <?php
                    if (isset($_POST['email'])) {
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $name = $_POST['name'];

                        $user = new User();

                        if ($user->registerUser($email, $password, $name)) {
                            echo "<p class='goodmsg'>Användaren är registrerad</p>";
                        } else {
                            echo "<p class='errormsg'>Fel vid registering av användare</p>";
                        }
                    }
                    ?>
                    <label for="email">Epost: </label>
                    <br>
                    <input type="text" name="email" id="email" placeholder="Din epost">
                    <br>
                    <label for="password">Lösenord: </label>
                    <br>
                    <input type="password" name="password" id="password" placeholder="Lösenord">
                    <br>
                    <label for="name">Namn: </label>
                    <br>
                    <input type="text" name="name" id="name" placeholder="Förnamn och Efternamn">
                    <br>
                    <button type="submit" class="btn green center">Registrera användare <i class="fa-solid fa-user-plus"></i></button>
                </form>
            </div>
        </div>

    </section>
</main>



<?php
include("includes/footer.php"); ?>