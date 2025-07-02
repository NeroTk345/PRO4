<?php require_once base_path("views/partials/head.php") ?>

<?php require_once base_path("views/partials/nav.php") ?>

<?php require_once base_path("views/partials/header.php") ?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php if (!empty($notes)): ?>
        <?php foreach ($notes as $note): ?>
          <div class="bg-white shadow-lg rounded-xl p-4 border border-gray-200 flex flex-col mb-4 relative transition-transform duration-150 hover:scale-[1.02] hover:shadow-2xl">
            <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'Admin'): ?>
              <form method="POST" action="/note" class="absolute top-2 right-2 z-10">
                <input type="hidden" name="id" value="<?= htmlspecialchars((string)($note['Id'] ?? '')) ?>">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="bg-red-600/80 text-white p-2 rounded-full hover:bg-red-700 hover:scale-110 transition-all text-xs flex items-center justify-center shadow-md" title="Verwijder melding" aria-label="Verwijder melding" style="width:32px;height:32px;" onclick="return confirm('Weet je zeker dat je deze melding wilt verwijderen?');">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <title>Verwijder melding</title>
                    <desc>Prullenbak icoon</desc>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 3h6a2 2 0 012 2v1H7V5a2 2 0 012-2zm3 7v6m-4-6v6m8-6v6" />
                  </svg>
                </button>
              </form>
            <?php endif; ?>
            <div class="mb-2">
              <a href="/note?id=<?= isset($note['Id']) ? $note['Id'] : '' ?>"
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
              // Gebruik de juiste Id uit de database (niet Nummer)
              $meldingId = $note['Id'] ?? null;
              
              $reactiesVoorMelding = array_filter($reacties ?? [], function($r) use ($meldingId) {
                return isset($r['melding_id']) && $r['melding_id'] == $meldingId;
              });
            ?>
            <div class="text-gray-700 text-sm mb-1 flex items-center gap-2">
              <span class="font-medium">Afgehandeld</span>
              <?php if (!empty($reactiesVoorMelding)): ?>
                <span class="inline-block px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-semibold border border-green-300" aria-label="Afgehandeld">Ja</span>
              <?php else: ?>
                <span class="inline-block px-2 py-0.5 rounded-full bg-red-100 text-red-700 text-xs font-semibold border border-red-300" aria-label="Niet afgehandeld">Nee</span>
              <?php endif; ?>
            </div>
            <?php if (!empty($reactiesVoorMelding)): ?>
              <?php foreach ($reactiesVoorMelding as $r): ?>
                <div class="mt-2 p-2 border rounded bg-blue-50">
                  <div class="mb-1 text-sm font-medium text-blue-800">
                    Admin reactie:
                  </div>
                  <div class="mb-1 text-sm">
                    <?= htmlspecialchars($r['inhoud'] ?? 'Geen inhoud') ?>
                  </div>
                  <div class="mb-1 text-xs text-gray-600">
                    <span class="font-medium">Door:</span> <?= htmlspecialchars($r['Gebruikersnaam'] ?? 'Onbekend') ?>
                    <?php if (isset($r['datum_tijd'])): ?>
                      <span class="font-medium ml-2">Datum/tijd:</span> <?= htmlspecialchars($r['datum_tijd']) ?>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="text-xs text-gray-400">Geen reacties gevonden</div>
            <?php endif; ?>
            <div class="text-gray-500 text-xs">
              <span><?= htmlspecialchars($note['Datum'] ?? '') ?></span>
              <span><?= htmlspecialchars($note['Tijd'] ?? '') ?></span>
            </div>
            <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'Admin'): ?>
              <form method="POST" action="/notes" class="mt-4 p-3 border rounded bg-gray-50">
                <input type="hidden" name="gebruiker_id" value="<?= htmlspecialchars((string)($_SESSION['user']['id'] ?? '')) ?>">
                <input type="hidden" name="melding_id" value="<?= htmlspecialchars((string)($note['Id'] ?? '')) ?>">
                <div class="mb-2">
                  <label for="inhoud_<?= htmlspecialchars((string)($note['Id'] ?? '')) ?>" class="block text-sm font-medium text-gray-700">Reactie</label>
                  <textarea id="inhoud_<?= htmlspecialchars((string)($note['Id'] ?? '')) ?>" name="inhoud" rows="2" class="w-full border rounded p-1" required></textarea>
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
