<footer>
    <hr>
    <nav class="container-fluid" id="footer">
        <div class="row">
            <div class="col-md-4">
                <a href="impr-agb-ds.php" class="btn btn-link">AGB - Impressum - Datenschutz</a>
            </div>
            <div class="col-md-4">
                <a href="about.php" class="btn btn-link">Über uns</a>
            </div>
            <div class="col-md-4">
                
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