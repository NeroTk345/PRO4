<?php require_once base_path("views/partials/head.php") ?>

<?php require_once base_path("views/partials/nav.php") ?>

<?php require_once base_path("views/partials/header.php") ?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

    <form method="POST" action="/notes">
      <div class="col-span-full">
        <label for="body" class="block text-xl font-medium text-gray-900">About</label>
        <div class="mt-2">
          <textarea name="body" id="body" rows="3" placeholder="Typ hier een idee..." required
            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
            <?= $_POST['body'] ?? '' ?></textarea>
        </div>
        <?php if (isset($errors['body'])): ?>
          <p class="text-red-500 text-s mt-1 mb-1"><?= $errors['body'] ?></p>
        <?php endif ?>
        <button type="submit"
          class="mt-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
      </div>
  </div>
  </div>
  </form>

  </div>
</main>

<?php require_once base_path("views/partials/footer.php") ?>