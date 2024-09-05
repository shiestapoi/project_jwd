<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Kuta Bali</title>
    <link rel="icon" type="image/ico" href="/assets/icon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <style>
    @font-face {
        font-family: 'Plus Jakarta Sans';
        src: url('assets/fonts/PlusJakartaSans-VariableFont_wght.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    body {
        background-color: #000;
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
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom justify-content-center rounded-5 fixed-top mt-2 w-75 mx-auto">
        <button class="navbar-toggler navbar-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link nav-active" href="#home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#introduce">Introduce</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#facilities">Facility</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contactme">Contact Me</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/riwayat">Riwayat Booking</a>
                </li>
            </ul>
        </div>
    </nav>
    <a href="/booking" class="btn btn-primary fixed-bottom mb-3 mx-auto rounded-3"
        style="right: 0; bottom: 0; position: fixed; width: 170px; height: 50px; display: flex; align-items: center; justify-content: center;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-plus"
            viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5">
            </path>
            <path
                d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2">
            </path>
            <path
                d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z">
            </path>
        </svg>
        <span style="margin-left: 3px; font-weight: 500;">Pesan Sekarang</span>
    </a>