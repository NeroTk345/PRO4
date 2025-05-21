<?php require_once "partials/head.php" ?>

<?php require_once "partials/nav.php" ?>

<?php require_once "partials/header.php" ?>

<main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <p> Hello, Welcome to the home page.</p>
        <?php print_r($_SESSION);?>
    </div>
</main>

<?php require_once "partials/footer.php" ?>