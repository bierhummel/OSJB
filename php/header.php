<header class="container-fluid jumbotron">
    <div class="row">
        <!--leeres div für Symetrie-->
        <div class="col-md-4">
        </div>
        <!--Schriftzug der immer zum Index verlinkt-->
        <div class="col-md-4 ">
            <h1 class="center">
                <a href="index.php">OSJB</a>
            </h1>    
        </div>
        <!--Links für Login/Logout + ggf. zum Profil-->
        <div class="col-md-4">
            <h2 class="login-links">
                <?php if( isset($_SESSION["eingeloggt"]) && $_SESSION["eingeloggt"] == "true" ) { ?>
                    <a href="profil.php" class="btn btn-primary login-links mr-2">Profil</a>
                    
                    <a href="php/controller-logout.php" class="btn btn-secondary login-links">Abmelden</a>
                <?php } else { ?>
                    <a href="login.php" class="btn btn-primary login-links">Anmeldung/Registrierung für Arbeitgeber</a>
                <?php } ?>
            </h2>
        </div>
    </div>
</header>