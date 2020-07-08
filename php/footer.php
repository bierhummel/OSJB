<footer>
    <hr>
    <nav class="container-fluid" id="footer">
        <div class="row">
            <div class="col-md-2 ">
                <a href="impressum.php" class="btn btn-link">Impressum</a>
            </div>
            <div class="col-md-2 ">
                <a href="datenschutz.php" class="btn btn-link">Datenschutz</a>
            </div>
            <div class="col-md-3 ">
                <a href="nutzungsbedingungen.php" class="btn btn-link">Nutzungsbedingungen</a>
            </div>


            <div class="col-md-3 ">
                <a href="about.php" class="btn btn-link">Über uns</a>
            </div>
            <div class="col-md-2 ">
                <?php if ( isset ($_SESSION["eingeloggt"]) && $_SESSION["eingeloggt"] == "true" ) { ?>
                    <a href="php/controller-logout.php" class="btn btn-link">Abmelden</a>
                <?php } else { ?>
                    <a href="login.php" class="btn btn-link">Anmelden</a>
                <?php } ?>
            </div>        
        </div>
    </nav>
</footer>

<!--Behandlung von unerwünschten Aufrufen?-->