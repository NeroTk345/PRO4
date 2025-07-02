<?php require_once base_path("views/partials/head.php") ?>
<?php require_once base_path("views/partials/nav.php") ?>
<?php require_once base_path("views/partials/header.php") ?>

<main>
<?php // DEBUG: Toon de opgehaalde data
echo '<pre style="background:#fff;color:#000;">';
echo '</pre>';
?>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Voorstellingen overzicht</h1>
    <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'Admin'): ?>
      <button id="openModalBtn" class="mb-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-all">Nieuwe voorstelling</button>
    <?php endif; ?>

    <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
      <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg relative">
        <button id="closeModalBtn" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>
        <h2 class="text-xl font-bold mb-4">Nieuwe voorstelling toevoegen</h2>
        <form id="addShowForm" method="post" action="/shows/create">
          <div class="mb-2">
            <label class="block text-sm font-medium">Naam</label>
            <input type="text" name="Naam" required class="w-full border rounded px-2 py-1">
          </div>
          <div class="mb-2">
            <label class="block text-sm font-medium">Beschrijving</label>
            <textarea name="Beschrijving" required class="w-full border rounded px-2 py-1"></textarea>
          </div>
          <div class="mb-2">
            <label class="block text-sm font-medium">Datum</label>
            <input type="date" name="Datum" required class="w-full border rounded px-2 py-1">
          </div>
          <div class="mb-2">
            <label class="block text-sm font-medium">Tijd</label>
            <input type="time" name="Tijd" required class="w-full border rounded px-2 py-1">
          </div>
          <div class="mb-2">
            <label class="block text-sm font-medium">Locatie</label>
            <input type="text" name="Locatie" required class="w-full border rounded px-2 py-1">
          </div>
          <div class="mb-2">
            <label class="block text-sm font-medium">Max aantal tickets</label>
            <input type="number" name="MaxAantalTickets" required class="w-full border rounded px-2 py-1">
          </div>
          <div class="mb-2">
            <label class="block text-sm font-medium">Opmerking</label>
            <input type="text" name="Opmerking" class="w-full border rounded px-2 py-1">
          </div>
          <div class="flex justify-end mt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Opslaan</button>
          </div>
        </form>
      </div>
    </div>

    <script>
      const openModalBtn = document.getElementById('openModalBtn');
      const closeModalBtn = document.getElementById('closeModalBtn');
      const modal = document.getElementById('modal');
      if(openModalBtn && closeModalBtn && modal) {
        openModalBtn.onclick = () => modal.classList.remove('hidden');
        closeModalBtn.onclick = () => modal.classList.add('hidden');
        window.onclick = (e) => { if(e.target === modal) modal.classList.add('hidden'); };
      }
    </script>

    <div class="overflow-x-auto">
      <?php if (empty($shows)): ?>
        <div class="text-center text-gray-500">Geen voorstellingen gevonden.</div>
      <?php else: ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($shows as $show): ?>
          <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-6 flex flex-col justify-between hover:shadow-2xl transition-all max-w-xl w-full mx-auto">
            <div>
              <div class="flex items-center justify-between mb-2">
                <h2 class="text-xl font-bold text-blue-900" style="word-break:break-word;" title="<?= htmlspecialchars($show['Naam'] ?? '') ?>"><?= htmlspecialchars($show['Naam'] ?? '') ?></h2>
                <?php if (($show['Beschikbaarheid'] ?? '') === 'Beschikbaar'): ?>
                  <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold border border-green-300 shadow-sm ml-2">✔ Beschikbaar</span>
                <?php else: ?>
                  <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold border border-red-300 shadow-sm ml-2">✖ Uitverkocht</span>
                <?php endif; ?>
              </div>
              <div class="text-gray-700 mb-2 min-h-[48px]" title="<?= htmlspecialchars($show['Beschrijving'] ?? '') ?>">
                <?= htmlspecialchars($show['Beschrijving'] ?? '') ?>
              </div>
              <div class="flex flex-wrap gap-2 text-sm text-gray-600 mb-2">
                <span><strong>Datum:</strong> <?= htmlspecialchars($show['Datum'] ?? '') ?></span>
                <span><strong>Tijd:</strong> <?= htmlspecialchars($show['Tijd'] ?? '') ?></span>
              </div>
              <div class="flex flex-wrap gap-2 text-sm text-gray-600 mb-2">
                <span><strong>Locatie:</strong> <?= htmlspecialchars($show['Locatie'] ?? '') ?></span>
                <span><strong>Aantal:</strong> <?= htmlspecialchars($show['MaxAantalTickets'] ?? '') ?></span>
              </div>
            </div>
            <div class="flex flex-col gap-2 mt-6">
              <?php if (($show['MaxAantalTickets'] ?? 0) > 0 && ($show['Beschikbaarheid'] ?? '') === 'Beschikbaar'): ?>
                <form method="post" action="/shows/buy" class="flex-1">
                  <input type="hidden" name="Id" value="<?= htmlspecialchars($show['Id']) ?>">
                  <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 font-semibold transition-all">Koop ticket</button>
                </form>
              <?php else: ?>
                <button class="w-full bg-gray-300 text-gray-500 rounded-lg px-4 py-2 font-semibold cursor-not-allowed" disabled>Niet beschikbaar</button>
              <?php endif; ?>
              <?php if (isset($_SESSION['user']['role']) && strtolower($_SESSION['user']['role']) === 'admin'): ?>
              <div class="flex gap-2 justify-end">
                <form method="post" action="/shows/delete" style="display:inline;">
                  <input type="hidden" name="Id" value="<?= htmlspecialchars($show['Id']) ?>">
                  <button type="submit" onclick="return confirm('Weet je zeker dat je deze voorstelling wilt verwijderen?');" class="bg-red-500 hover:bg-red-600 text-white rounded-full p-2 transition-all" title="Verwijder">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                  </button>
                </form>
                <button type="button" class="bg-yellow-400 hover:bg-yellow-500 text-white rounded-full p-2 transition-all" title="Bewerk" onclick="openEditModal(<?= htmlspecialchars($show['Id']) ?>, '<?= htmlspecialchars(addslashes($show['Naam'] ?? '')) ?>', '<?= htmlspecialchars(addslashes($show['Beschrijving'] ?? '')) ?>', '<?= htmlspecialchars($show['Datum'] ?? '') ?>', '<?= htmlspecialchars($show['Tijd'] ?? '') ?>', '<?= htmlspecialchars(addslashes($show['Locatie'] ?? '')) ?>', <?= htmlspecialchars($show['MaxAantalTickets'] ?? 0) ?>, '<?= htmlspecialchars($show['Beschikbaarheid'] ?? '') ?>', '<?= htmlspecialchars(addslashes($show['Opmerking'] ?? '')) ?>')">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6 6M3 21h6a2 2 0 002-2v-6a2 2 0 00-2-2H3v8z" /></svg>
                </button>
              </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</main>

<!-- Bewerk Modal -->
<div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
  <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg relative">
    <button id="closeEditModalBtn" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
    <h2 class="text-xl font-bold mb-4">Voorstelling bewerken</h2>
    <form id="editShowForm" method="post" action="/shows/update">
      <input type="hidden" name="Id" id="editId">
      <div class="mb-2">
        <label class="block text-sm font-medium">Naam</label>
        <input type="text" name="Naam" id="editNaam" required class="w-full border rounded px-2 py-1">
      </div>
      <div class="mb-2">
        <label class="block text-sm font-medium">Beschrijving</label>
        <textarea name="Beschrijving" id="editBeschrijving" required class="w-full border rounded px-2 py-1"></textarea>
      </div>
      <div class="mb-2">
        <label class="block text-sm font-medium">Datum</label>
        <input type="date" name="Datum" id="editDatum" required class="w-full border rounded px-2 py-1">
      </div>
      <div class="mb-2">
        <label class="block text-sm font-medium">Tijd</label>
        <input type="time" name="Tijd" id="editTijd" required class="w-full border rounded px-2 py-1">
      </div>
      <div class="mb-2">
        <label class="block text-sm font-medium">Locatie</label>
        <input type="text" name="Locatie" id="editLocatie" required class="w-full border rounded px-2 py-1">
      </div>
      <div class="mb-2">
        <label class="block text-sm font-medium">Max aantal tickets</label>
        <input type="number" name="MaxAantalTickets" id="editMaxAantalTickets" required class="w-full border rounded px-2 py-1">
      </div>
      <div class="mb-2">
        <label class="block text-sm font-medium">Beschikbaarheid</label>
        <select name="Beschikbaarheid" id="editBeschikbaarheid" class="w-full border rounded px-2 py-1">
          <option value="Beschikbaar">Beschikbaar</option>
          <option value="Uitverkocht">Uitverkocht</option>
        </select>
      </div>
      <div class="mb-2">
        <label class="block text-sm font-medium">Opmerking</label>
        <input type="text" name="Opmerking" id="editOpmerking" class="w-full border rounded px-2 py-1">
      </div>
      <div class="flex justify-end mt-4">
        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Opslaan</button>
      </div>
    </form>
  </div>
</div>
<script>
function openEditModal(id, naam, beschrijving, datum, tijd, locatie, maxAantalTickets, beschikbaarheid, opmerking) {
  document.getElementById('editId').value = id;
  document.getElementById('editNaam').value = naam;
  document.getElementById('editBeschrijving').value = beschrijving;
  document.getElementById('editDatum').value = datum;
  document.getElementById('editTijd').value = tijd;
  document.getElementById('editLocatie').value = locatie;
  document.getElementById('editMaxAantalTickets').value = maxAantalTickets;
  document.getElementById('editBeschikbaarheid').value = beschikbaarheid;
  document.getElementById('editOpmerking').value = opmerking;
  document.getElementById('editModal').classList.remove('hidden');
}
document.getElementById('closeEditModalBtn').onclick = function() {
  document.getElementById('editModal').classList.add('hidden');
};
window.onclick = function(event) {
  var modal = document.getElementById('editModal');
  if (event.target === modal) {
    modal.classList.add('hidden');
  }
};
</script>
<?php require_once base_path("views/partials/footer.php") ?>
