<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $title; ?> - Dashboard</title>
    <link rel="icon" type="image/ico" href="/assets/icon.ico">
    <link rel="stylesheet" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    @font-face {
        font-family: 'Plus Jakarta Sans';
        src: url('/assets/fonts/PlusJakartaSans-VariableFont_wght.ttf') format('truetype');
    }

    body {
        background-color: #01131E;
        color: #fff;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .navbar-custom {
        background-color: #1E1E1E;
        border-radius: 20px;
        padding: 10px;
    }

    .nav-link {
        color: #fff;
        font-weight: bold;
        padding: 0 20px;
    }

    .nav-link:hover {
        color: #28a745;
    }

    .nav-active {
        color: #1E90FF;
    }

    ::-webkit-scrollbar {
        width: 12px;
    }

    ::-webkit-scrollbar-track {
        background: #1E1E1E;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #555;
        border-radius: 10px;
        border: 3px solid #1E1E1E;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #28a745;
    }
    </style>
    <?php if (isset($_GET['message'])) { ?>
    <script>
    alert(<?php echo $_GET['message']; ?>);
    </script>
    <?php } ?>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-custom rounded-5 fixed-top mt-2 w-75 mx-auto">
        <button class="navbar-toggler navbar-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="justify-content-start ms-3">
            Halo, <a href="/admin/profile" style="text-decoration: none; color: inherit;"><strong class="ms-1">
                    <?php echo $user['username']; ?></strong></a>
        </div>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav"
            style="position: absolute; left: 50%; transform: translateX(-50%);">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?php echo $title == 'Inbox' ? 'nav-active' : ''; ?>"
                        href="/admin/dashboard">Inbox</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $title == 'Booking' ? 'nav-active' : ''; ?>"
                        href="/admin/booking">Booking</a>

                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $title == 'Paket' ? 'nav-active' : ''; ?>"
                        href="/admin/paket">Paket</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $title == 'Layanan' ? 'nav-active' : ''; ?>"
                        href="/admin/layanan">Layanan</a>
                </li>
            </ul>
        </div>
        <div class="justify-content-end ms-auto" style="margin-right: 20px;">
            <a href="/admin/logout" class="text-danger me-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                    <path fill-rule="evenodd"
                        d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                </svg>
            </a>
        </div>
    </nav>