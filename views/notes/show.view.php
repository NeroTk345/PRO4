<?php require_once base_path("views/partials/head.php") ?>

<?php require_once base_path("views/partials/nav.php") ?>

<?php require_once base_path("views/partials/header.php") ?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <p class="mb-6">
      <a class="text-blue-700 hover:underline" href="/notes">ga terug!</a>
    </p>
    <ul>
      <li>
        <?= htmlspecialchars($note['body']) ?>
      </li>
    </ul>

    <div class="mt-6">
      <a class="mt-2 rounded-md bg-green-800 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-green-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" href="/note/edit?id=<?= $note['id'] ?>">Edit</a>
    </div>

    <form class="mt-6" method="post">
      <input type="hidden" name="_method" value="DELETE">
      <input type="hidden" name="id" value="<?= $note['id'] ?>">
      <button class="mt-2 rounded-md bg-red-400 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-300 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Delete</button>
    </form>
  </div>
</main>

<?php require_once base_path("views/partials/footer.php") ?>