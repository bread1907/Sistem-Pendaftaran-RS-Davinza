<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Style_Admin/main.css">

    <title>Admin Login Panel</title>


    <?php require 'Halaman_Admin/links.php'; ?>

    <style>
        div.login-form {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
        }

        .custom-alert {
            position: fixed !important;
            top: 25px !important;
            right: 25px !important;
        }
    </style>
</head>

<body class="bg-light">
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
    </svg>
    <?php
    if (isset($_SESSION['login_error'])) {
        $msg = $_SESSION['login_error'];
        echo <<<alert
        <div class="alert alert-danger d-flex align-items-center custom-alert" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            <div>
                $msg
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    alert;
        unset($_SESSION['login_error']);
    }

    ?>

    <div class="login-form text-center rounded bg-white shadow overflow-hidden">

        <form action="index.php?action=admin_login" method="POST">
            <h4 class="bg-dark text-white py-3">Admin Login Panel</h4>
            <div class="p-4">
                <div class="mb-3">
                    <input name="admin_name" required type="text" class="form-control shadow-none text-center"
                        placeholder="Username">
                </div>
                <div class="mb-4">
                    <input name="admin_pass" required type="password" class="form-control shadow-none"
                        placeholder="Password">
                </div>
                <button name="login" type="submit" class="btn text-white custom-bg shadow-none">Masuk</button>
            </div>
        </form>
    </div>

</body>

</html>