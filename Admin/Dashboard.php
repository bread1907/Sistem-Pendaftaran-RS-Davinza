<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <?php include __DIR__ . "/Halaman_Admin/links.php"; ?>
    <link rel="stylesheet" href="../Style_Admin/main.css">

    <style>
        html,
        body {
            height: 100%;
        }

        #sidepanel {
            position: sticky;
            top: 56px;
            height: calc(100vh - 56px);
        }
    </style>

</head>

<body class="bg-light">
    <?php include __DIR__ . "/Halaman_Admin/header_admin.php"; ?>  <!-- Header terpisah -->

    <div class="container-fluid" id="main-content">
        <div class="row">
            <!-- Sidebar dipindah ke sini -->
             <?php include __DIR__ . "/Halaman_Admin/sidebar_admin.php"; ?>

            <!-- Konten sejajar di kanan -->
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                adsasd  <!-- Konten Anda sekarang sejajar -->
            </div>
        </div>
    </div>

</body>

</html>