<?php require_once base_path("views/partials/head.php") ?>

<?php require_once base_path("views/partials/nav.php") ?>

<div class="container" style="margin-top: 20px;">
    <h3>Account Details</h3>
    <p>Hier kunt u uw accountinformatie bekijken en aanpassen.</p>
</div>
<br>
<div class="info">
    <h2>Welkom, <span id="naamText"><?php echo htmlspecialchars($gebruikersnaam ?? 'Gast'); ?></span>!</h2>
</div>

<?php require_once base_path("views/partials/footer.php") ?>