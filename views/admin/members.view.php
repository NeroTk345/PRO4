<?php require_once base_path('views/partials/head.php'); ?>
<?php require_once base_path('views/partials/nav.php'); ?>
<main class="mx-auto max-w-7xl px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Ledenoverzicht</h1>
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Alle leden</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Voornaam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tussenvoegsel</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Achternaam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gebruikersnaam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($leden as $lid): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium"><?= htmlspecialchars($lid['Voornaam'] ?? '') ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium"><?= htmlspecialchars($lid['Tussenvoegsel'] ?? '') ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium"><?= htmlspecialchars($lid['Achternaam'] ?? '') ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700"><?= htmlspecialchars($lid['Gebruikersnaam'] ?? '') ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700"><?= htmlspecialchars($lid['rolnaam'] ?? '') ?></td>
                            <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                <button type="button" class="bg-yellow-400 hover:bg-yellow-500 text-white rounded-full p-2 transition-all" title="Bewerk" onclick='openEditMemberModal(<?= json_encode($lid, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6 6M3 21h6a2 2 0 002-2v-6a2 2 0 00-2-2H3v8z" /></svg>
                                </button>
                                <form method="post" action="/admin/members/delete" onsubmit="return confirm('Weet je zeker dat je dit lid wilt verwijderen?');">
                                                                                                            <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="Id" value="<?= htmlspecialchars($lid['Id'] ?? '') ?>">
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white rounded-full p-2 transition-all" title="Verwijder">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="flex justify-end mb-6">
        <button id="openModalBtn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-all">Nieuw lid toevoegen</button>
    </div>
    <!-- Modal -->
    <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg relative">
            <button id="closeModalBtn" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            <h2 class="text-xl font-semibold mb-4">Nieuw lid toevoegen</h2>
            <form method="post" action="/admin/members/create" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Voornaam</label>
                    <input type="text" name="Voornaam" required class="w-full border rounded px-2 py-1">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tussenvoegsel</label>
                    <input type="text" name="Tussenvoegsel" class="w-full border rounded px-2 py-1">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Achternaam</label>
                    <input type="text" name="Achternaam" required class="w-full border rounded px-2 py-1">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Gebruikersnaam</label>
                    <input type="text" name="Gebruikersnaam" required class="w-full border rounded px-2 py-1">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Wachtwoord</label>
                    <input type="password" name="Wachtwoord" required class="w-full border rounded px-2 py-1">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Rol</label>
                    <select name="RolId" class="w-full border rounded px-2 py-1">
                        <?php /* Dynamisch rollen ophalen indien gewenst */ ?>
                        <option value="1">Admin</option>
                        <option value="2">Medewerker</option>
                        <option value="3">Bezoeker</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Toevoegen</button>
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
<!-- Bewerk Lid Modal -->
<div id="editMemberModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
  <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg relative">
    <button id="closeEditMemberModalBtn" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
    <h2 class="text-xl font-bold mb-4">Lid bewerken</h2>
        <form id="editMemberForm" method="post" action="/admin/members/update">
            <input type="hidden" name="_method" value="PATCH">
      <input type="hidden" name="Id" id="editMemberId">
      <div class="mb-2">
        <label class="block text-sm font-medium">Voornaam</label>
        <input type="text" name="Voornaam" id="editMemberVoornaam" required class="w-full border rounded px-2 py-1">
      </div>
      <div class="mb-2">
        <label class="block text-sm font-medium">Tussenvoegsel</label>
        <input type="text" name="Tussenvoegsel" id="editMemberTussenvoegsel" class="w-full border rounded px-2 py-1">
      </div>
      <div class="mb-2">
        <label class="block text-sm font-medium">Achternaam</label>
        <input type="text" name="Achternaam" id="editMemberAchternaam" required class="w-full border rounded px-2 py-1">
      </div>
      <div class="mb-2">
        <label class="block text-sm font-medium">Gebruikersnaam</label>
        <input type="text" name="Gebruikersnaam" id="editMemberGebruikersnaam" required class="w-full border rounded px-2 py-1">
      </div>
      <div class="mb-2">
        <label class="block text-sm font-medium">Rol</label>
        <select name="RolId" id="editMemberRolId" required class="w-full border rounded px-2 py-1">
            <option value="1">Admin</option>
            <option value="2">Medewerker</option>
            <option value="3">Bezoeker</option>
        </select>
      </div>
      <div class="flex justify-end mt-4">
        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Opslaan</button>
      </div>
    </form>
  </div>
</div>
<script>
function openEditMemberModal(lid) {
  document.getElementById('editMemberId').value = lid.Id || lid.id || '';
  document.getElementById('editMemberVoornaam').value = lid.Voornaam || '';
  document.getElementById('editMemberTussenvoegsel').value = lid.Tussenvoegsel || '';
  document.getElementById('editMemberAchternaam').value = lid.Achternaam || '';
  document.getElementById('editMemberGebruikersnaam').value = lid.Gebruikersnaam || '';
  document.getElementById('editMemberRolId').value = lid.RolId || '';
  document.getElementById('editMemberModal').classList.remove('hidden');
}
document.getElementById('closeEditMemberModalBtn').onclick = function() {
  document.getElementById('editMemberModal').classList.add('hidden');
};
window.onclick = function(event) {
  var modal = document.getElementById('editMemberModal');
  if (event.target === modal) {
    modal.classList.add('hidden');
  }
};
</script>
</main>
<?php require_once base_path('views/partials/footer.php'); ?>
