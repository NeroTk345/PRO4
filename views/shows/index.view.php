<?php require_once base_path("views/partials/head.php") ?>

<?php require_once base_path("views/partials/nav.php") ?>

<?php require_once base_path("views/partials/header.php") ?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    
    <!-- Voorstellingen statistieken -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-4 mb-8">
      <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-.976-.608-.976-1.192v-2.197l-1.971 1.971L12 12.747l3 3m0 0l3-3m-3 3V13m0 0h-6M7.5 12.75A3.75 3.75 0 1111.25 9h3.75a.75.75 0 010 1.5H11.5"/>
              </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">Totaal Voorstellingen</dt>
                <dd class="text-lg font-medium text-gray-900"><?= count($shows) ?></dd>
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
                <dt class="text-sm font-medium text-gray-500 truncate">Actieve Voorstellingen</dt>
                <dd class="text-lg font-medium text-gray-900">
                  <?= count(array_filter($shows, fn($show) => $show['Isactief'] == 1)) ?>
                </dd>
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
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">Toekomstige Shows</dt>
                <dd class="text-lg font-medium text-gray-900">
                  <?= count(array_filter($shows, fn($show) => $show['status'] === 'toekomstig')) ?>
                </dd>
              </dl>
            </div>
          </div>
        </div>
      </div>

      <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"/>
              </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">Uitverkocht</dt>
                <dd class="text-lg font-medium text-gray-900">
                  <?= count(array_filter($shows, fn($show) => $show['status'] === 'uitverkocht')) ?>
                </dd>
              </dl>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php if (!empty($shows)): ?>
      <!-- Voorstellingen overzicht -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Aurora Theater Programma</h3>
            <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
              <svg class="-ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
              </svg>
              Nieuwe Voorstelling
            </button>
          </div>
          
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Voorstelling
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Datum & Tijd
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Tickets
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Verantwoordelijke
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Acties
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($shows as $show): ?>
                  <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                      <div class="flex items-start">
                        <div class="flex-shrink-0">
                          <div class="h-10 w-10 rounded-lg bg-gradient-to-r from-purple-400 to-pink-400 flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-.976-.608-.976-1.192v-2.197l-1.971 1.971L12 12.747l3 3m0 0l3-3m-3 3V13"/>
                            </svg>
                          </div>
                        </div>
                        <div class="ml-4">
                          <div class="text-sm font-medium text-gray-900">
                            <?= htmlspecialchars($show['Naam']) ?>
                          </div>
                          <?php if ($show['Beschrijving']): ?>
                            <div class="text-sm text-gray-500 max-w-xs truncate">
                              <?= htmlspecialchars($show['Beschrijving']) ?>
                            </div>
                          <?php endif; ?>
                          <div class="text-xs text-gray-400">ID: <?= $show['Id'] ?></div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm font-medium text-gray-900">
                        <?= date('d-m-Y', strtotime($show['Datum'])) ?>
                      </div>
                      <div class="text-sm text-gray-500">
                        <?= date('H:i', strtotime($show['Tijd'])) ?>
                      </div>
                      <div class="text-xs text-gray-400">
                        <?php
                        $datetime = new DateTime($show['Datum'] . ' ' . $show['Tijd']);
                        $now = new DateTime();
                        if ($datetime > $now) {
                            $diff = $now->diff($datetime);
                            echo "Over " . $diff->days . " dagen";
                        } elseif ($datetime->format('Y-m-d') === $now->format('Y-m-d')) {
                            echo "Vandaag";
                        } else {
                            $diff = $datetime->diff($now);
                            echo $diff->days . " dagen geleden";
                        }
                        ?>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">
                        <div class="flex items-center">
                          <span class="font-medium"><?= $show['tickets_verkocht'] ?></span>
                          <span class="text-gray-400 mx-1">/</span>
                          <span><?= $show['MaxAantalTickets'] ?></span>
                        </div>
                      </div>
                      <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                        <?php 
                        $percentage = $show['MaxAantalTickets'] > 0 ? ($show['tickets_verkocht'] / $show['MaxAantalTickets']) * 100 : 0;
                        $color = $percentage >= 100 ? 'bg-red-500' : ($percentage >= 80 ? 'bg-yellow-500' : 'bg-green-500');
                        ?>
                        <div class="<?= $color ?> h-2 rounded-full" style="width: <?= min($percentage, 100) ?>%"></div>
                      </div>
                      <div class="text-xs text-gray-500 mt-1">
                        <?= $show['tickets_beschikbaar'] ?> beschikbaar
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">
                        <?= htmlspecialchars($show['medewerker_naam'] ?? 'Onbekend') ?>
                      </div>
                      <?php if ($show['medewerker_nummer']): ?>
                        <div class="text-sm text-gray-500">
                          #<?= $show['medewerker_nummer'] ?>
                        </div>
                      <?php endif; ?>
                      <?php if ($show['Medewerkersoort']): ?>
                        <div class="text-xs text-gray-400">
                          <?= htmlspecialchars($show['Medewerkersoort']) ?>
                        </div>
                      <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex flex-col space-y-1">
                        <?php
                        $statusColors = [
                            'toekomstig' => 'bg-blue-100 text-blue-800',
                            'bezig' => 'bg-yellow-100 text-yellow-800',
                            'voltooid' => 'bg-gray-100 text-gray-800',
                            'uitverkocht' => 'bg-red-100 text-red-800'
                        ];
                        $statusTexts = [
                            'toekomstig' => 'Toekomstig',
                            'bezig' => 'Bezig',
                            'voltooid' => 'Voltooid',
                            'uitverkocht' => 'Uitverkocht'
                        ];
                        ?>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $statusColors[$show['status']] ?? 'bg-gray-100 text-gray-800' ?>">
                          <?= $statusTexts[$show['status']] ?? ucfirst($show['status']) ?>
                        </span>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $show['Isactief'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                          <?= $show['Isactief'] ? 'Actief' : 'Inactief' ?>
                        </span>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                          <?= htmlspecialchars($show['Beschikbaarheid']) ?>
                        </span>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                      <a href="/show/<?= $show['Id'] ?>" class="text-indigo-600 hover:text-indigo-900">
                        Bekijken
                      </a>
                      <a href="/show/<?= $show['Id'] ?>/edit" class="text-yellow-600 hover:text-yellow-900">
                        Bewerken
                      </a>
                      <a href="/show/<?= $show['Id'] ?>/tickets" class="text-green-600 hover:text-green-900">
                        Tickets
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php else: ?>
      <!-- Geen voorstellingen beschikbaar -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6 text-center">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-.976-.608-.976-1.192v-2.197l-1.971 1.971L12 12.747l3 3m0 0l3-3m-3 3V13m0 0h-6M7.5 12.75A3.75 3.75 0 1111.25 9h3.75a.75.75 0 010 1.5H11.5"/>
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Geen voorstellingen beschikbaar</h3>
          <p class="mt-1 text-sm text-gray-500">
            Er zijn nog geen voorstellingen toegevoegd aan het Aurora Theater programma.
          </p>
          <div class="mt-6">
            <button class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
              </svg>
              Eerste voorstelling toevoegen
            </button>
          </div>
        </div>
      </div>
    <?php endif; ?>

  </div>
</main>

<?php require_once base_path("views/partials/footer.php") ?>