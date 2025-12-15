<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan</title>

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
    <?php include __DIR__ . "/Halaman_Admin/header_admin.php"; ?> <!-- Header terpisah -->

    <div class="container-fluid" id="main-content">
        <div class="row">
            <!-- Sidebar dipindah ke sini -->
            <?php include __DIR__ . "/Halaman_Admin/sidebar_admin.php"; ?>

            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Pengaturan</h3>

                <!-- General -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Pengaturan Umum</h5>
                            <button>Edit</button>
                        </div>
                        <h6 class="card-subtitle mb-1 fw-bold">asd</h6>
                        <p class="card-text">lalala bla bla</p>
                        <h6 class="card-subtitle mb-1 fw-bold">dsa</h6>
                        <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>