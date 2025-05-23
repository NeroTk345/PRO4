<?php require_once base_path("views/partials/head.php") ?>
<?php require_once base_path("views/partials/nav.php") ?>
<?php require_once base_path("views/partials/header.php") ?>

<main>
  <div class="mx-auto max-w-2xl px-4 py-6 sm:px-6 lg:px-8">

    <form method="POST" action="/admin/shows" class="space-y-6">
      <input type="hidden" name="_method" value="PATCH">
      <input type="hidden" name="id" value="<?= $voorstelling['id'] ?>">
      
      <!-- Titel -->
      <div>
        <label for="titel" class="block text-sm font-medium text-gray-900">Titel</label>
        <input type="text" name="titel" id="titel" required
               class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
               value="<?= htmlspecialchars($voorstelling['titel']) ?>">
        <?php if (isset($errors['titel'])): ?>
          <p class="mt-1 text-sm text-red-600"><?= $errors['titel'] ?></p>
        <?php endif ?>
      </div>

      <!-- Beschrijving -->
      <div>
        <label for="beschrijving" class="block text-sm font-medium text-gray-900">Beschrijving</label>
        <textarea name="beschrijving" id="beschrijving" rows="4" required
                  class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"><?= htmlspecialchars($voorstelling['beschrijving']) ?></textarea>
        <?php if (isset($errors['beschrijving'])): ?>
          <p class="mt-1 text-sm text-red-600"><?= $errors['beschrijving'] ?></p>
        <?php endif ?>
      </div>

      <!-- Datum en Tijd -->
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label for="datum" class="block text-sm font-medium text-gray-900">Datum</label>
          <input type="date" name="datum" id="datum" required
                 class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                 value="<?= $voorstelling['datum'] ?>">
          <?php if (isset($errors['datum'])): ?>
            <p class="mt-1 text-sm text-red-600"><?= $errors['datum'] ?></p>
          <?php endif ?>
        </div>
        
        <div>
          <label for="tijd" class="block text-sm font-medium text-gray-900">Tijd</label>
          <input type="time" name="tijd" id="tijd" required
                 class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                 value="<?= substr($voorstelling['tijd'], 0, 5) ?>">
          <?php if (isset($errors['tijd'])): ?>
            <p class="mt-1 text-sm text-red-600"><?= $errors['tijd'] ?></p>
          <?php endif ?>
        </div>
      </div>

      <!-- Prijs en Max bezoekers -->
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label for="prijs" class="block text-sm font-medium text-gray-900">Prijs (€)</label>
          <input type="number" step="0.01" name="prijs" id="prijs" required
                 class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                 value="<?= $voorstelling['prijs'] ?>">
          <?php if (isset($errors['prijs'])): ?>
            <p class="mt-1 text-sm text-red-600"><?= $errors['prijs'] ?></p>
          <?php endif ?>
        </div>
        
        <div>
          <label for="max_bezoekers" class="block text-sm font-medium text-gray-900">Max. bezoekers</label>
          <input type="number" name="max_bezoekers" id="max_bezoekers" required
                 class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                 value="<?= $voorstelling['max_bezoekers'] ?>">
          <?php if (isset($errors['max_bezoekers'])): ?>
            <p class="mt-1 text-sm text-red-600"><?= $errors['max_bezoekers'] ?></p>
          <?php endif ?>
        </div>
      </div>

      <!-- Locatie -->
      <div>
        <label for="locatie" class="block text-sm font-medium text-gray-900">Locatie</label>
        <input type="text" name="locatie" id="locatie" required
               class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
               value="<?= htmlspecialchars($voorstelling['locatie']) ?>">
        <?php if (isset($errors['locatie'])): ?>
          <p class="mt-1 text-sm text-red-600"><?= $errors['locatie'] ?></p>
        <?php endif ?>
      </div>

      <!-- Status -->
      <div>
        <label for="status" class="block text-sm font-medium text-gray-900">Status</label>
        <select name="status" id="status"
                class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
          <option value="actief" <?= $voorstelling['status'] === 'actief' ? 'selected' : '' ?>>Actief</option>
          <option value="inactief" <?= $voorstelling['status'] === 'inactief' ? 'selected' : '' ?>>Inactief</option>
          <option value="uitverkocht" <?= $voorstelling['status'] === 'uitverkocht' ? 'selected' : '' ?>>Uitverkocht</option>
        </select>
      </div>

      <!-- Afbeelding URL -->
      <div>
        <label for="afbeelding_url" class="block text-sm font-medium text-gray-900">Afbeelding URL</label>
        <input type="url" name="afbeelding_url" id="afbeelding_url"
               class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
               value="<?= htmlspecialchars($voorstelling['afbeelding_url'] ?? '') ?>">
      </div>

      <!-- Bezoekers info (read-only) -->
      <div class="bg-gray-50 p-4 rounded-md">
        <h3 class="text-sm font-medium text-gray-900 mb-2">Bezoekers informatie</h3>
        <p class="text-sm text-gray-600">
          Huidige bezoekers: <span class="font-medium"><?= $voorstelling['huidige_bezoekers'] ?></span> van 
          <span class="font-medium"><?= $voorstelling['max_bezoekers'] ?></span>
        </p>
        <p class="text-sm text-gray-600">
          Beschikbare plaatsen: <span class="font-medium"><?= $voorstelling['max_bezoekers'] - $voorstelling['huidige_bezoekers'] ?></span>
        </p>
      </div>

      <!-- Buttons -->
      <div class="flex gap-4">
        <button type="submit"
                class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
          Wijzigingen Opslaan
        </button>
        <a href="/admin/shows"
           class="rounded-md bg-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-400">
          Annuleren
        </a>
      </div>

      <?php if (isset($errors['general'])): ?>
        <p class="text-red-600 text-sm"><?= $errors['general'] ?></p>
      <?php endif ?>

    </form>

  </div>
</main>

<?php require_once base_path("views/partials/footer.php") ?>