


<?php
$page_title = "Theater Aurora";
$year = date("Y");
if(isset($_POST["login"])) {
    header('Location:../pages/login.php');
}
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if (isset($_POST['add_to_cart'])) {
    $_SESSION['cart'][] = $_POST['show_title'];
}
if (isset($_POST['remove_from_cart'])) {
    $key = array_search($_POST['remove_from_cart'], $_SESSION['cart']);
    if ($key !== false) unset($_SESSION['cart'][$key]);
}
?>
<?php require_once base_path("views/partials/head.php") ?>

<?php require_once base_path("views/partials/nav.php") ?>


<!-- Header Section -->
<header id="home">
    <div class="header-content">
        <h1>Welcome to <?php echo $page_title; ?></h1>
        <p>Experience the magic of live performances and unforgettable moments.</p>
        <a href="/pages/shows.php" class="btn">View Shows</a>
    </div>
    <div class="header-image">
        <img src="https://images.unsplash.com/photo-1464983953574-0892a716854b?q=80&w=800" alt="Theater Stage">
        <link rel="stylesheet" href="css/style.css">
    </div>
</header>



<!-- About Section -->
<section id="about">
    <div class="container">
        <h2>About Aurora</h2>
        <p>
            At <?php echo $page_title; ?>, we bring stories to life on stage. 
            Join us for a season of drama, comedy, and musical performances in a beautiful, historic setting.
        </p>
        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=800" alt="Theater Audience">
    </div>
</section>

<!-- Show Agenda Section -->
<section id="agenda" style="background:#181824; padding: 60px 10vw;">
    <div class="container" style="display:flex; flex-direction:column; gap:32px;">
        <h2 style="color:#eab308; margin-bottom:24px;">Show Agenda</h2>
        <?php
        // Example shows for today and tomorrow
        $shows = [
            [
                "date" => "Today",
                "time" => "18:00",
                "title" => "Aurora Opening Night",
                "img" => "https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?q=80&w=400",
                "price" => "€25",
                "info" => "A spectacular opening with music, dance, and drama to kick off the season."
            ],
            [
                "date" => "Today",
                "time" => "20:30",
                "title" => "Comedy Hour: Laugh Factory",
                "img" => "https://images.unsplash.com/photo-1465101046530-73398c7f28ca?q=80&w=400",
                "price" => "€20",
                "info" => "Stand-up comedy with the city's best comedians. Laughter guaranteed!"
            ],
            [
                "date" => "Today",
                "time" => "22:00",
                "title" => "Late Night Jazz",
                "img" => "https://images.unsplash.com/photo-1509228468518-180dd4864904?q=80&w=400",
                "price" => "€18",
                "info" => "Smooth jazz performances by local and international artists."
            ],
            [
                "date" => "Tomorrow",
                "time" => "17:00",
                "title" => "Children's Theater: Fairy Tales",
                "img" => "https://images.unsplash.com/photo-1519125323398-675f0ddb6308?q=80&w=400",
                "price" => "€30",
                "info" => "A magical afternoon for kids and families with classic fairy tales on stage."
            ],
            [
                "date" => "Tomorrow",
                "time" => "19:30",
                "title" => "Drama: The Lost Letter",
                "img" => "https://images.unsplash.com/photo-1464983953574-0892a716854b?q=80&w=400",
                "price" => "€20",
                "info" => "A moving drama about love, loss, and hope, performed by Aurora's ensemble."
            ],
            [
                "date" => "Tomorrow",
                "time" => "21:30",
                "title" => "Musical: Night in Paris",
                "img" => "https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=400",
                "price" => "€22",
                "info" => "A romantic musical journey through the streets of Paris with song and dance."
            ],
            
        ];
        ?>
        <div style="display:flex; flex-wrap:wrap; gap:32px; justify-content:center;">
            <?php foreach($shows as $index => $show): ?>
            <div class="show-card">
                <img src="<?php echo $show['img']; ?>" alt="<?php echo htmlspecialchars($show['title']); ?>">
                <div class="show-info">
                    <span class="show-date"><?php echo $show['date']; ?>, <?php echo $show['time']; ?></span>
                    <h3><?php echo htmlspecialchars($show['title']); ?></h3>
                    <p><?php echo htmlspecialchars($show['info']); ?></p>
                    <!-- Price button -->
                    <button class="price-btn" data-index="<?php echo $index; ?>">
                        <?php echo $show['price']; ?>
                    </button>
                    <!-- Add to cart form, hidden by default -->
                    <form method="post" class="add-form" id="add-form-<?php echo $index; ?>" style="display:none;">
                        <input type="hidden" name="show_title" value="<?php echo htmlspecialchars($show['title']); ?>">
                        <button type="submit" name="add_to_cart" class="add-btn">+</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Cart Modal -->
<div id="cart-modal">
    <div class="cart-content">
        <button class="close-modal" onclick="closeCart()">&times;</button>
        <h2 style="color:#eab308;">Your Cart</h2>
        <ul class="cart-list">
            <?php if (empty($_SESSION['cart'])): ?>
                <li>Your cart is empty.</li>
            <?php else: ?>
                <?php foreach ($_SESSION['cart'] as $key => $item): ?>
                    <li>
                        <?php echo htmlspecialchars($item); ?>
                        <form method="post" style="display:inline;">
                            <button type="submit" name="remove_from_cart" value="<?php echo htmlspecialchars($item); ?>">Delete</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        <div class="cart-actions">
            <a href="/pages/login.php">Login</a>
            <a href="/pages/guest_checkout.php" style="margin-left:8px;">Continue as Guest</a>
        </div>
    </div>
</div>

<footer>
  <div class="container">
    <p>&copy; <?php echo $year; ?> Aurora Theater. All rights reserved.</p>
  </div>
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="script.js"></script>
<script>
    // Show "+" button when price is clicked
    document.querySelectorAll('.price-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var idx = btn.getAttribute('data-index');
            document.getElementById('add-form-' + idx).style.display = 'block';
            btn.style.display = 'none';
        });
    });

    // Cart modal logic
    document.querySelector('a[href="/pages/cart.php"]').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('cart-modal').style.display = 'flex';
    });
    function closeCart() {
        document.getElementById('cart-modal').style.display = 'none';
    }
    // Close modal on outside click
    window.onclick = function(event) {
        var modal = document.getElementById('cart-modal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>