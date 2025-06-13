<?php require_once base_path("views/partials/head.php") ?>

<?php require_once base_path("views/partials/nav.php") ?>

<?php require_once base_path("views/partials/header.php") ?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php if (!empty($notes)): ?>
        <?php foreach ($notes as $note): ?>
          <div class="bg-white shadow rounded p-4 border border-gray-200 flex flex-col mb-4">
            <div class="mb-2">
              <a href="/note?id=<?= isset($note['id']) ? $note['id'] : '' ?>"
                class="text-blue-900 hover:underline text-lg font-semibold">
                <?= htmlspecialchars($note['Bericht'] ?? 'Geen inhoud beschikbaar') ?>
              </a>
            </div>
            <div class="text-gray-600 text-sm mb-1">
              <span class="font-medium">Gebruiker:</span>
              <?= htmlspecialchars($note['gebruiker_naam'] ?? 'Onbekend') ?>
            </div>
            <div class="text-gray-700 text-sm mb-1">
              <span class="font-medium">Voorstelling:</span>
              <?= htmlspecialchars($note['voorstelling_naam'] ?? 'Onbekend') ?>
            </div>
             <?php 
              $reactiesVoorMelding = array_filter($reacties ?? [], function($r) use ($note) {
                return isset($r['gebruiker_id']) && $r['gebruiker_id'] == ($note['GebruikerId'] ?? $note['gebruiker_id'] ?? null);
              });
            ?>
            <div class="text-gray-700 text-sm mb-1">
              <span class="font-medium">Reacties:</span>
            </div>
            <?php if (!empty($reactiesVoorMelding)): ?>
              <?php foreach ($reactiesVoorMelding as $r): ?>
                <div class="mt-2 p-2 border rounded bg-green-50">
                  <div class="mb-1 text-sm">
                    <?= htmlspecialchars($r['inhoud']) ?>
                  </div>
                  <div class="mb-1 text-xs">
                    <span class="font-medium">Door:</span> <?= htmlspecialchars($r['Gebruikersnaam'] ?? '') ?>
                    <span class="font-medium ml-2">Datum/tijd:</span> <?= htmlspecialchars($r['datum_tijd'] ?? '') ?>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="text-xs text-gray-400">Geen reacties</div>
            <?php endif; ?>
            <div class="text-gray-500 text-xs">
              <span><?= htmlspecialchars($note['Datum'] ?? '') ?></span>
              <span><?= htmlspecialchars($note['Tijd'] ?? '') ?></span>
            </div>
            <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'Admin'): ?>
              <form method="POST" action="/notes" class="mt-4 p-3 border rounded bg-gray-50">
                <input type="hidden" name="gebruiker_id" value="<?= htmlspecialchars((string)($_SESSION['user']['id'] ?? '')) ?>">
                <input type="hidden" name="melding_id" value="<?= htmlspecialchars((string)($note['id'] ?? '')) ?>">
                <div class="mb-2">
                  <label for="inhoud_<?= htmlspecialchars((string)($note['id'] ?? $note['Nummer'] ?? '')) ?>" class="block text-sm font-medium text-gray-700">Reactie</label>
                  <textarea id="inhoud_<?= htmlspecialchars((string)($note['id'] ?? $note['Nummer'] ?? '')) ?>" name="inhoud" rows="2" class="w-full border rounded p-1" required></textarea>
                </div>
                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">Plaats reactie</button>
              </form>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="text-gray-500">Geen notes gevonden.</div>
      <?php endif; ?>
    </div>
    <p class="mt-6">
      <a class="text-blue-500 hover:underline" href="/note/create">Creeër een note</a>
    </p>

  </div>
</main>

<?php require_once base_path("views/partials/footer.php") ?>
