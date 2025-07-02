<?php $heading = 'Ticket gekocht'; ?>
<?php require_once base_path("views/partials/head.php"); ?>
<?php require_once base_path("views/partials/nav.php"); ?>
<?php require_once base_path("views/partials/header.php"); ?>

<main>
  <div class="mx-auto max-w-lg px-4 py-16 text-center">
    <div class="bg-green-100 border border-green-300 rounded-2xl shadow p-8">
      <svg class="mx-auto mb-4 text-green-500" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4 -4" /></svg>
      <h1 class="text-2xl font-bold text-green-800 mb-2">Ticket succesvol gekocht!</h1>
      <p class="text-green-700 mb-6">Je hebt succesvol een ticket gekocht voor de voorstelling.<br>Je ontvangt een bevestiging per e-mail (indien van toepassing).</p>
      <a href="/shows" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition-all">Terug naar overzicht</a>
    </div>
  </div>
</main>

<?php require_once base_path("views/partials/footer.php"); ?>
