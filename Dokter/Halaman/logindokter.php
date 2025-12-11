<?php
session_start();

// Jika sudah login, langsung arahkan ke homepage dokter
if (isset($_SESSION['dokter_logged_in']) && $_SESSION['dokter_logged_in'] === true) {
    header("Location: homepagedokter.php");
    exit;
}

// Load header
require_once __DIR__ . "/template/header_dokter.php";
?>

<div class="container" style="max-width: 460px; margin-top: 80px;">

    <h2 style="text-align: center; margin-bottom: 25px;">Login Dokter</h2>

    <?php if (isset($_GET['error'])): ?>
        <div style="
            padding: 10px;
            background: #ffdddd;
            border-left: 5px solid #d9534f;
            margin-bottom: 20px;
        ">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <form action="../../controller/doktercontroller.php?aksi=login" method="POST"
          style="background: #ffffff; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

        <div style="margin-bottom: 15px;">
            <label for="email">Email Dokter</label>
            <input type="email" id="email" name="email" required
                   style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password">Kata Sandi</label>
            <input type="password" id="password" name="password" required
                   style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
        </div>

        <button type="submit" 
                style="width: 100%; padding: 10px; border: none; background: #0275d8; 
                       color: white; border-radius: 6px; cursor: pointer;">
            Masuk
        </button>

    </form>
</div>

<?php
// Load footer
require_once __DIR__ . "/template/footer_dokter.php";
?>
