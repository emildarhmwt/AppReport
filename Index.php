<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report Application</title>
    <link rel="shortcut icon" type="image/png" href="./assets/images/logos/logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Acme&family=Coiny&family=Concert+One&family=Fredoka:wght@300..700&family=Outfit:wght@100..900&family=Pacifico&family=Playpen+Sans:wght@100..800&family=Playwrite+DE+Grund:wght@100..400&family=Righteous&family=Sacramento&family=Varela+Round&family=Yatra+One&display=swap"
        rel="stylesheet">
    <style>
    body {
        background-image: url(./assets/images/backgrounds/5.png);
        background-size: cover;
        background-repeat: no-repeat;
    }

    .img-login {
        width: 100px;
        height: auto;
        display: block;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 15px;
    }

    .btn-primary {
        background: #4d769a;
    }

    .rowdies-light {
        font-family: "Rowdies", sans-serif;
        font-weight: 300;
        font-style: normal;
    }

    .rowdies-regular {
        font-family: "Rowdies", sans-serif;
        font-weight: 400;
        font-style: normal;
    }

    .rowdies-bold {
        font-family: "Rowdies", sans-serif;
        font-weight: 700;
        font-style: normal;
    }

    .varela-round-regular {
        font-family: "Varela Round", sans-serif;
        font-weight: 400;
        font-style: normal;
    }

    .judul {
        font-family: 'Varela Round', sans-serif;
        font-weight: bold;
        font-size: 35px;
        color: #07303f;
    }

    .sub-judul {
        font-family: 'Varela Round', sans-serif;
        font-weight: bold;
        color: #07303f;
    }

    .page-wrapper {
        position: relative;
        min-height: 100vh;
        overflow: hidden;
    }

    .btn-custom-eye {
        background-color: #11475e !important;
        color: white !important;
    }

    .btn-custom-eye:hover {
        background-color: #609fb2 !important;
        color: white !important;
    }

    .btn-custom-upload {
        background-color: #eb9009 !important;
        color: white !important;
    }

    .btn-custom-upload:hover {
        background-color: #eb900970 !important;
        color: white !important;
    }

    .btn-custom-edit {
        background-color: #7c1919 !important;
        color: white !important;
    }

    .btn-custom-edit:hover {
        background-color: #b27373 !important;
        color: white !important;
    }

    .form-container {
        background-color: #bdd7d9;
        padding: 20px;
        border-radius: 10px;
    }

    .right-column {
        position: relative;
    }

    .right-column img {
        position: absolute;
    }

    .latar {
        width: 200%;
        height: 270%;
        left: 5%;
        z-index: -1;
    }

    .login {
        width: 100%;
        height: auto;
        right: -15%;
        z-index: 2;
    }

    @media (max-width:576px) {
        .login {
            display: none;
        }
    }
    </style>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center">
            <div class="container">
                <div class="row w-100">
                    <div class="col-md-6">
                        <h3 class="text-center judul">WELCOME BACK!</h3>
                        <p class="text-center sub-judul">Please enter your details</p>
                        <img src="./assets/images/logos/logo.png" alt="Logo" class="img-login">
                        <div id="notification" class="text-danger text-center"></div>
                        <form action="index_aksi.php" method="post" id="loginForm">
                            <div class="mb-3">
                                <label for="username" class="form-label sub-judul">Username</label>
                                <input type="text" class="form-control" placeholder="Username" required="required"
                                    autocomplete="off" name="username" id="username">
                            </div>
                            <div class="mb-1">
                                <label for="password" class="form-label sub-judul">Password</label>
                                <input type="password" placeholder="Password" required="required" autocomplete="off"
                                    name="password" id="password" class="form-control">
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="form-check">
                                    <input class="form-check-input primary" type="checkbox" value="" id="showPassword">
                                    <label class="form-check-label sub-judul" for="showPassword">
                                        Show Password
                                    </label>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="hak" class="form-label sub-judul">Hak Akses</label>
                                <select class="form-select" name="akses" id="akses" required>
                                    <option selected disabled>Hak Akses</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">Pengawas</option>
                                    <option value="kontraktor">Kontraktor</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between">
                                <input type="submit" value="Login"
                                    class="btn btn-custom-eye fs-4 mb-4 rounded-2 flex-grow-1 sub-judul">
                            </div>
                        </form>

                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-center right-column">
                        <!-- <img src="./assets/images/logos/latar3.png" class="latar"> -->
                        <img src="./assets/images/logos/login.png" class="login">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    const urlParams = new URLSearchParams(window.location.search);
    const alertMessage = urlParams.get('message');
    if (alertMessage) {
        console.error(alertMessage); // Tampilkan pesan kesalahan di konsol
        document.getElementById('notification').innerText = alertMessage; // Tampilkan di halaman
    }

    document.getElementById('showPassword').addEventListener('change', function() {
        var passwordInput = document.getElementById('password');
        if (this.checked) {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    });
    </script>
    <script src="./assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/sidebarmenu.js"></script>
    <script src="./assets/js/app.min.js"></script>
    <script src="./assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="./assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="./assets/js/dashboard.js"></script>
</body>

</html>