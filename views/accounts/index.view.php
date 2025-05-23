<?php 
// All use statements must be at the top of the file
use Models\Account;

require_once base_path("views/partials/head.php");
require_once base_path("views/partials/nav.php");
require_once base_path("views/partials/header.php");
?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    
    <!-- Accounts statistieken -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-4 mb-8">
      <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
              </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">Totaal Accounts</dt>
                <dd class="text-lg font-medium text-gray-900"><?= $stats['total'] ?></dd>
              </dl>
            </div>
          </div>
        </div>
      </div>
      
      <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">Actieve Accounts</dt>
                <dd class="text-lg font-medium text-gray-900"><?= $stats['active'] ?></dd>
              </dl>
            </div>
          </div>
        </div>
      </div>

      <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3A2.25 2.25 0 008.25 5.25v3.093m4.5 0c.167-.048.33-.102.5-.16V5.25A.75.75 0 0012.5 4.5h-1a.75.75 0 00-.75.75v2.683c.17.058.333.112.5.16m0 0V9a.75.75 0 01.75.75v.007c0 .414.336.75.75.75h.007a.75.75 0 01.75-.75V9.75a.75.75 0 01.75-.75z"/>
              </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">Medewerkers</dt>
                <dd class="text-lg font-medium text-gray-900"><?= $stats['employees'] ?></dd>
              </dl>
            </div>
          </div>
        </div>
      </div>

      <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
              </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">Bezoekers</dt>
                <dd class="text-lg font-medium text-gray-900"><?= $stats['visitors'] ?></dd>
              </dl>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php if (!empty($accounts)): ?>
      <!-- Accounts tabel -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Alle Accounts</h3>
            <div class="flex space-x-3">
              <span class="text-sm text-gray-500">
                <?= $stats['online'] ?> online • <?= $stats['admins'] ?> admins
              </span>
              <a href="/accounts/create" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Nieuw Account
              </a>
            </div>
          </div>
          
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Gebruiker
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Contact
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Type & Rol
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Login Info
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Acties
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($accounts as $account): ?>
                  <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="h-8 w-8 flex-shrink-0">
                          <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                            <span class="text-sm font-medium text-gray-700">
                              <?= Account::getInitials($account) ?>
                            </span>
                          </div>
                        </div>
                        <div class="ml-4">
                          <div class="text-sm font-medium text-gray-900">
                            <?= htmlspecialchars(Account::getFullName($account)) ?>
                          </div>
                          <div class="text-sm text-gray-500">ID: <?= $account['Id'] ?></div>
                          <?php if ($account['medewerker_nummer']): ?>
                            <div class="text-xs text-blue-600">Medewerker #<?= $account['medewerker_nummer'] ?></div>
                          <?php endif; ?>
                          <?php if ($account['bezoeker_nummer']): ?>
                            <div class="text-xs text-purple-600">Bezoeker #<?= $account['bezoeker_nummer'] ?></div>
                          <?php endif; ?>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900"><?= htmlspecialchars($account['email']) ?></div>
                      <?php if ($account['contact_email'] && $account['contact_email'] !== $account['email']): ?>
                        <div class="text-sm text-gray-500">Alt: <?= htmlspecialchars($account['contact_email']) ?></div>
                      <?php endif; ?>
                      <?php if ($account['Mobiel']): ?>
                        <div class="text-sm text-gray-500"><?= htmlspecialchars($account['Mobiel']) ?></div>
                      <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex flex-col space-y-1">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                          <?php 
                            switch($account['gebruiker_type']) {
                              case 'Medewerker': echo 'bg-blue-100 text-blue-800'; break;
                              case 'Bezoeker': echo 'bg-purple-100 text-purple-800'; break;
                              default: echo 'bg-gray-100 text-gray-800';
                            }
                          ?>">
                          <?= htmlspecialchars($account['gebruiker_type']) ?>
                          <?php if ($account['Medewerkersoort']): ?>
                            (<?= htmlspecialchars($account['Medewerkersoort']) ?>)
                          <?php endif; ?>
                        </span>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                          <?= $account['rol_naam'] === 'Admin' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' ?>">
                          <?= htmlspecialchars($account['rol_naam']) ?>
                        </span>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex flex-col space-y-1">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                          <?= $account['Isactief'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                          <?= $account['Isactief'] ? 'Actief' : 'Inactief' ?>
                        </span>
                        <?php if ($account['IsIngelogd']): ?>
                          <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            Online
                          </span>
                        <?php endif; ?>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                      <?php if ($account['Ingelogd']): ?>
                        <div>Laatste login:</div>
                        <div class="font-medium"><?= date('d-m-Y H:i', strtotime($account['Ingelogd'])) ?></div>
                      <?php endif; ?>
                      <?php if ($account['Uitgelogd']): ?>
                        <div>Laatste logout:</div>
                        <div><?= date('d-m-Y H:i', strtotime($account['Uitgelogd'])) ?></div>
                      <?php endif; ?>
                      <?php if (!$account['Ingelogd'] && !$account['Uitgelogd']): ?>
                        <span class="text-gray-400">Nog nooit ingelogd</span>
                      <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                      <a href="/accounts/<?= $account['Id'] ?>" class="text-indigo-600 hover:text-indigo-900">
                        Bekijken
                      </a>
                      <a href="/accounts/<?= $account['Id'] ?>/edit" class="text-yellow-600 hover:text-yellow-900">
                        Bewerken
                      </a>
                      <form method="post" action="/accounts/<?= $account['Id'] ?>/toggle-status" style="display: inline;">
                        <button type="submit" class="<?= $account['Isactief'] ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' ?>">
                          <?= $account['Isactief'] ? 'Deactiveren' : 'Activeren' ?>
                        </button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php else: ?>
      <!-- Geen accounts beschikbaar -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6 text-center">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Geen accounts beschikbaar</h3>
          <p class="mt-1 text-sm text-gray-500">
            Er zijn nog geen accounts toegevoegd aan het Aurora theater systeem.
          </p>
          <div class="mt-6">
            <a href="/accounts/create" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
              </svg>
              Eerste account aanmaken
            </a>
          </div>
        </div>
      </div>
    <?php endif; ?>

  </div>
</main>

<?php require_once base_path("views/partials/footer.php") ?>