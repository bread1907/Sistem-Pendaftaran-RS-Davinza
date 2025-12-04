<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Style_Admin/main.css">
    <title>Admin Login Panel</title>
    <?php require 'Halaman_Admin/links.php'; ?>

    <style>
        div.login-form{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
        }
    </style>
</head>
<body class="bg-light">

<div class="login-form text-center rounded bg-white shadow overflow-hidden">
    <form method="POST">
        <h4 class="bg-dark text-white py-3">Admin Login Panel</h4>
        <div class="p-4">
            <div class="mb-3">
                <input name="admin_name" required type="text" class="form-control shadow-none text-center" placeholder="Username">
            </div>
            <div class="mb-4">
                <input name="admin_pass" required type="password" class="form-control shadow-none" placeholder="Password">
            </div>
            <button name="login" type="submit" class="btn text-white custom-bg shadow-none">Masuk</button>
        </div>
    </form>
</div>
    
</body>
</html>