<?php require_once base_path("views/partials/head.php") ?>

<?php require_once base_path("views/partials/nav.php") ?>

<?php require_once base_path("views/partials/header.php") ?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

    <form method="POST" action="/notes">
      <div class="col-span-full">
        <label for="body" class="block text-xl font-medium text-gray-900">About</label>
        <div class="mt-2">
          <textarea name="Bericht" id="Bericht" rows="3" placeholder="Type hier je melding" required
            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"><?= $_POST['Bericht'] ?? '' ?></textarea>
        </div>
       
      <div>
      </div>
      <div>
        <label for="voorstelling" class="block text-sm font-medium text-gray-700">Voorstelling</label>
        <select id="voorstelling" name="voorstelling" required class="mt-1 block w-full border border-gray-300 rounded p-2">
          <option value="">Kies een voorstelling</option>
          <?php foreach (($voorstellingen ?? []) as $v): ?>
            <option value="<?= htmlspecialchars($v['id']) ?>">
              <?= htmlspecialchars($v['naam']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label for="datum" class="block text-sm font-medium text-gray-700">Datum</label>
        <input type="date" id="datum" name="datum" required class="mt-1 block w-full border border-gray-300 rounded p-2" />
      </div>
      <div>
        <label for="tijd" class="block text-sm font-medium text-gray-700">Tijd</label>
        <input type="time" id="tijd" name="tijd" required class="mt-1 block w-full border border-gray-300 rounded p-2" />
      </div>
      <!-- <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Toevoegen</button> -->
    </form></form>
        <?php if (isset($errors['Bericht'])): ?>
          <p class="text-red-500 text-s mt-1 mb-1"><?= $errors['Bericht'] ?></p>
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