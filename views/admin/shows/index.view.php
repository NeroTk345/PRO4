
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/head.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/nav.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/partials/header.php'; ?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

    <!-- Success message -->
    <?php if (isset($_SESSION['success_message'])): ?>
      <div class="mb-4 rounded-md bg-green-50 p-4">
        <div class="text-sm text-green-700"><?= $_SESSION['success_message'] ?></div>
      </div>
      <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <!-- Add new show button -->
    <div class="mb-6">
      <a href="/admin/shows/create" 
         class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
        Nieuwe Voorstelling Toevoegen
      </a>
    </div>

    <?php if (!empty($voorstellingen)): ?>
      <!-- Shows table -->
      <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
        <table class="min-w-full divide-y divide-gray-300">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Titel</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Datum & Tijd</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Prijs</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Bezoekers</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Acties</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($voorstellingen as $voorstelling): ?>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">
                    <?= htmlspecialchars($voorstelling['titel']) ?>
                  </div>
                  <div class="text-sm text-gray-500">
                    <?= htmlspecialchars($voorstelling['locatie']) ?>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  <?= date('d-m-Y', strtotime($voorstelling['datum'])) ?><br>
                  <?= date('H:i', strtotime($voorstelling['tijd'])) ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  €<?= number_format($voorstelling['prijs'], 2) ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  <?= $voorstelling['huidige_bezoekers'] ?> / <?= $voorstelling['max_bezoekers'] ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                    <?= $voorstelling['status'] === 'actief' ? 'bg-green-100 text-green-800' : 
                        ($voorstelling['status'] === 'uitverkocht' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') ?>">
                    <?= ucfirst($voorstelling['status']) ?>
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                  <a href="/admin/shows/edit?id=<?= $voorstelling['id'] ?>" 
                     class="text-indigo-600 hover:text-indigo-900">Bewerken</a>
                  
                  <form method="POST" action="/admin/shows" class="inline">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="id" value="<?= $voorstelling['id'] ?>">
                    <button type="submit" 
                            class="text-red-600 hover:text-red-900"
                            onclick="return confirm('Weet je zeker dat je deze voorstelling wilt verwijderen?')">
                      Verwijderen
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    <?php else: ?>
      <!-- No shows message -->
      <div class="text-center py-12">
        <div class="mx-auto h-12 w-12 text-gray-400">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
          </svg>
        </div>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Geen voorstellingen beschikbaar</h3>
        <p class="mt-1 text-sm text-gray-500">Er zijn nog geen voorstellingen toegevoegd aan het systeem.</p>
        <div class="mt-6">
          <a href="/admin/shows/create" 
             class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
            Eerste voorstelling toevoegen
          </a>
        </div>
      </div>
    <?php endif; ?>

  </div>
</main>

<?php require_once base_path("views/partials/footer.php") ?>