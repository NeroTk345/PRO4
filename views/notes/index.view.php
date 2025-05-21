<?php require_once base_path("views/partials/head.php") ?>

<?php require_once base_path("views/partials/nav.php") ?>

<?php require_once base_path("views/partials/header.php") ?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

    <ul>
      <?php if (!empty($notes)): ?>
      <?php foreach ($notes as $note): ?>
        <li>
          <a href="/note?id=<?= isset($note['id']) ? $note['id'] : '' ?>" class="text-blue-900 hover:underline">
            <?= htmlspecialchars($note['Bericht'] ?? 'Geen inhoud beschikbaar') ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
        (<?php else: ?> 
        <li class="text-gray-500">Geen notes gevonden.</li>)
      <?php endif; ?>
    <p class="mt-6">
      <a class="text-blue-500 hover:underline" href="/note/create">Creeër een note</a>
    </p>


  </div>
</main>

<?php require_once base_path("views/partials/footer.php") ?>