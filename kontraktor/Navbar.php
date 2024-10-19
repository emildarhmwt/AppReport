<?php
include '../Koneksi.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report Application</title>
    <link rel="shortcut icon" type="image/png" href="./assets/images/logos/logo.png" />
    <link rel="stylesheet" href="./assets/css/styles.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Acme&family=Coiny&family=Concert+One&family=Fredoka:wght@300..700&family=Outfit:wght@100..900&family=Pacifico&family=Playpen+Sans:wght@100..800&family=Playwrite+DE+Grund:wght@100..400&family=Righteous&family=Sacramento&family=Varela+Round&family=Yatra+One&display=swap"
        rel="stylesheet">
    <style>
    .logo-report {
        width: 40px;
        height: auto;
        margin-right: 10px;
    }

    .tulisanlogo {
        font-family: "Righteous", serif;
        color: #780d0d;
        font-size: 30px;
        margin-top: 10px;
    }

    .righteous-regular {
        font-family: "Righteous", serif;
        font-weight: 400;
        font-style: normal;
    }

    .varela-round-regular {
        font-family: "Varela Round", serif;
        font-weight: 400;
        font-style: normal;
    }

    .dashboard {
        font-family: "Varela Round", serif;
        color: #061a32;
        font-weight: bold;
        font-size: 20px;
    }

    .operation {
        font-family: "Varela Round", serif;
        font-weight: bold;
        color: #061a32;
        font-size: 20px;
    }

    .report {
        font-family: "Varela Round", serif;
        font-weight: bold;
        color: #061a32;
        font-size: 20px;
    }

    .profile {
        font-family: "Varela Round", serif;
        color: #df7a15;
        font-weight: bold;
        margin-top: 10px;
    }

    .active {
        text-decoration: underline;
        color: #061a32;
    }

    .inactive {
        color: grey;
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
        <!--  Header Start -->
        <header class="app-header">
            <nav class="navbar navbar-expand-lg navbar-light">
                <!-- <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                                <i class="ti ti-bell-ringing"></i>
                                <div class="notification bg-primary rounded-circle"></div>
                            </a>
                        </li>
                    </ul> -->
                <ul class="navbar-nav flex-row ms-4 align-items-center">
                    <li>
                        <img src="../assets/images/logos/logo.png" class="logo-report">
                    </li>
                    <li class="text-center">
                        <!-- <img src="./assets/images/logos/tulisan-logo.png" class="tulisanlogo"> -->
                        <h3 class="tulisanlogo"> REPORT APP</h3>
                    </li>
                </ul>

                <ul class="navbar-nav me-auto flex-row align-items-center"
                    style="flex-grow: 40; justify-content: center;">
                    <li class="nav-item mx-5">
                        <a class="dashboard nav-link" aria-current="page" href="Dashboard_pengawas.php">Dashboard</a>
                    </li>
                    <li class="nav-item mx-5">
                        <a class="operation nav-link" href="Operation.php">Operation</a>
                    </li>
                    <li class="nav-item mx-5">
                        <a class="operation nav-link" href="Production.php">Produksi</a>
                    </li>
                    <li class="nav-item mx-5">
                        <a class="operation nav-link" href="HourMeter.php">Jam Jalan</a>
                    </li>
                </ul>

                <div class="navbar-collapse justify-content-end px-4" id="navbarNav">
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <div>
                                    <h5 class="profile" id="adminNameDisplay"> Emilda Rahmawati [Kontraktor]</h5>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                aria-labelledby="drop2">
                                <div class="message-body">
                                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                        <i class="ti ti-user fs-6"></i>
                                        <p class="mb-0 fs-3">Profil Saya</p>
                                    </a>
                                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                        <i class="ti ti-logout fs-6"></i>
                                        <p class="mb-0 fs-3">Ganti Password</p>
                                    </a>
                                    <a href="../Logout.php"
                                        class="btn btn-outline-primary mx-3 mt-2 d-block shadow-none">Logout</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>


        <!--  Header End -->
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const adminName = "<?php echo $_SESSION['nama']; ?>";
        document.getElementById('adminNameDisplay').innerText = adminName;
    });
    </script>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="../assets/js/dashboard.js"></script>
</body>

</html>