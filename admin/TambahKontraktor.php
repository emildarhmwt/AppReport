<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report Application</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Acme&family=Coiny&family=Concert+One&family=Fredoka:wght@300..700&family=Outfit:wght@100..900&family=Pacifico&family=Playpen+Sans:wght@100..800&family=Playwrite+DE+Grund:wght@100..400&family=Righteous&family=Sacramento&family=Varela+Round&family=Yatra+One&display=swap"
        rel="stylesheet">
    <style>
    .body-wrapper {
        background-image: url(../assets/images/backgrounds/4.png);
        background-size: cover;
        background-repeat: no-repeat;
    }

    .notif {
        font-size: 12px;
        margin-top: 5px;
        margin-left: 5px;
        color: #6a0707;
    }

    .wajib_isi {
        color: #8b0707;
        font-size: 15px;
    }

    .varela-round-regular {
        font-family: "Varela Round", serif;
        font-weight: 400;
        font-style: normal;
    }

    .judul {
        font-family: "Varela Round", serif;
        text-align: center;
        font-size: 30px;
        margin-bottom: 50px;
        margin-top: 10px;
        color: #0f3f61;
    }

    .sub-judul {
        font-family: "Varela Round", serif;
        color: #0f3f61;
    }

    .form-select.text-white option {
        color: black;
    }

    .form-select.text-white {
        color: #0f3f61;
    }

    .form-control::placeholder {
        color: #0f3f61;
    }
    </style>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <!-- <div id="sidebar"></div> -->
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <div id="navbar"></div>
            <!--  Header End -->
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <h5 class="judul fw-semibold">Form Kontraktor</h5>
                        <form action="kontraktor_aksi.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="tanggal" class="sub-judul mb-2">Nama :</label>
                                <input type="text" class="form-control text-white" name="nama" id="nama"
                                    placeholder="Input Data" required>
                            </div>
                            <div class="mb-3">
                                <label for="shift" class="sub-judul mb-2">Username : </label>
                                <input type="text" class="form-control text-white" name="username" id="username"
                                    placeholder="Input Data" required>
                            </div>
                            <div class="mb-3">
                                <label for="grup" class="sub-judul mb-2">Password :</label>
                                <input type="password" class="form-control text-white" id="password" name="password"
                                    placeholder="Input Data" required>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                                    onclick="togglePasswordVisibility()" style="border: 1px solid #0f3f61;">
                                <label class="form-check-label sub-judul" for="flexCheckDefault">
                                    Show Password
                                </label>
                            </div>
                            <div class="mb-5">
                                <label for="formFile" class="sub-judul mb-2">Foto</label>
                                <input class="form-control text-white" type="file" name="image" id="image"
                                    accept="image/png, image/jpeg">
                            </div>
                            <button type="submit" class="btn btn-primary me-2"> Submit</button>
                            <button type="button" class="btn btn-danger"
                                onclick="window.location.href='kontraktor.php'">
                                Kembali</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <script>
    fetch('Navbar.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('navbar').innerHTML = data;
        });

    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const checkbox = document.getElementById('flexCheckDefault');
        passwordInput.type = checkbox.checked ? 'text' : 'password';
    }
    </script>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>