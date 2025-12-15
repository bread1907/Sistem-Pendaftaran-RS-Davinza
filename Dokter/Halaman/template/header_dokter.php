<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>RS Davinza | Portal Dokter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
            font-family: "Segoe UI", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .navbar-dokter {
            background: linear-gradient(90deg, #0d6efd, #0b5ed7);
        }

        .navbar-brand {
            font-weight: 600;
            letter-spacing: .3px;
        }

        .page-title {
            font-weight: 600;
            color: #2c3e50;
        }

        .card {
            border-radius: 12px;
            border: none;
        }

        .btn {
            border-radius: 8px;
        }

        footer {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-dokter shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="index.php?aksi=homepagedokter">
            <i class="bi bi-hospital"></i>
            RS Davinza – Portal Dokter
        </a>

        <div class="ms-auto text-white small">
            <?php if (!empty($_SESSION['dokter_nama'])): ?>
                <i class="bi bi-person-circle"></i>
                Dr. <?= htmlspecialchars($_SESSION['dokter_nama']); ?>
            <?php endif; ?>
        </div>
    </div>
</nav>

<main class="py-4">
