<?php
session_start();
include '../Koneksi.php';

$admin_id = $_SESSION['id'];

// Fetch admin data using PostgreSQL
$sql = "SELECT nama, username, file_admin FROM user_report WHERE id = $1";
$result = pg_query_params($conn, $sql, array($admin_id));

if ($result) {
    $admin = pg_fetch_assoc($result);
    if (!$admin) {
        echo "No supervisor data found.";
        exit; // Stop execution if no data is found
    }
} else {
    echo "Error fetching supervisor data.";
    exit; // Stop execution on error
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report Application</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo.png" />
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

    .text-white {
        color: #0f3c61 !important;
    }

    .tulisanlogo {
        font-family: "Righteous", serif;
        color: #5b1313;
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
        color: #0f3c61;
        font-weight: bold;
        font-size: 20px;
    }

    .operation {
        font-family: "Varela Round", serif;
        font-weight: bold;
        color: #0f3c61;
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

    .notification-dropdown {
        width: 280px;
        right: 0;
        left: auto;
        max-height: 400px;
        overflow-y: auto;
        z-index: 1050;
        /* Tambahkan z-index yang lebih tinggi */
    }

    .notification-dropdown .message-body {
        padding: 10px;
    }

    .notification-dropdown .message-title {
        font-size: 14px;
    }

    .notification-dropdown .dropdown-item {
        padding: 8px 10px;
    }

    .notification-dropdown .notification-content h6 {
        font-size: 12px;
        margin-bottom: 2px;
    }

    .notification-dropdown .notification-content p {
        font-size: 11px;
        margin-bottom: 2px;
    }

    .notification-dropdown .notification-content small {
        font-size: 10px;
    }

    .notification-dropdown .btn-sm {
        font-size: 12px;
        padding: 4px 8px;
    }

    .bg-danger {
        background-color: #b90808 !important;
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
                        <a class="operation nav-link" href="Report.php">Report</a>
                    </li>
                    <li class="nav-item mx-5">
                        <a class="operation nav-link" href="../Logout.php">Logout</a>
                    </li>
                    <!-- <li class="nav-item mx-5">
                        <a class="operation nav-link" href="Production.php">Produksi</a>
                    </li>
                    <li class="nav-item mx-5">
                        <a class="operation nav-link" href="HourMeter.php">Jam Jalan</a>
                    </li> -->
                </ul>

                <div class="navbar-collapse justify-content-end px-4" id="navbarNav">
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <div>
                                    <h5 class="profile" id="adminNameDisplay">
                                        <img src="<?php echo isset($admin['file_admin']) && file_exists($admin['file_admin']) ? htmlspecialchars($admin['file_admin']) : '../assets/images/default.png'; ?>"
                                            alt="Image" style="width: 50px; height: auto; border-radius: 50%;">
                                        <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?>
                                        [Pengawas]
                                    </h5>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                aria-labelledby="drop2">
                                <div class="message-body">
                                    <a href="profile.php" class="d-flex align-items-center gap-2 dropdown-item">
                                        <i class="ti ti-user fs-6"></i>
                                        <p class="mb-0 fs-3">Profil Saya</p>
                                    </a>
                                    <!-- <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                        <i class="ti ti-logout fs-6"></i>
                                        <p class="mb-0 fs-3">Ganti Password</p>
                                    </a> -->
                                    <a href="../Logout.php"
                                        class="btn btn-outline-primary mx-3 mt-2 d-block shadow-none">Logout</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-bell-ringing text-white"></i>
                                <div class="notification bg-danger rounded-circle"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up notification-dropdown"
                                aria-labelledby="drop2">
                                <div class="message-body">
                                    <h5 class="message-title mb-3 text-center">Notifikasi</h5>
                                    <div class="message-list">

                                        <?php
                                            $arsip_sql = "SELECT DISTINCT ON (op.id) op.tanggal
                                                          FROM operation_report op 
                                                          JOIN production_report pr ON op.id = pr.operation_report_id 
                                                          WHERE pr.proses_admin = 'Uploaded' AND pr.proses_pengawas IS NULL
                                                          AND op.pic = $1 
                                                          ORDER BY op.id";
                                            $arsip = pg_query_params($conn, $arsip_sql, array($_SESSION['username']));
                                            if (!$arsip) {
                                                echo "Error executing query: " . pg_last_error($conn);
                                                exit; // Stop execution if the query fails
                                            }

                                            while ($p = pg_fetch_assoc($arsip)) {
                                        ?>
                                        <a href="report.php" class="dropdown-item py-2 border-bottom">
                                            <div class="notification-content"
                                                style="white-space: normal; max-width: 200px;">
                                                <h6 class="mb-0 fs-1">
                                                    Laporan produksi
                                                    <?php echo date('d M Y', strtotime($p['tanggal'])); ?> menunggu
                                                    persetujuan
                                                </h6>
                                            </div>
                                        </a>
                                        <?php
                                            }
                                        ?>

                                        <?php
                                            $arsip_sql = "SELECT DISTINCT ON (op.id) op.tanggal, pr.kontraktor, pr.alasan_reject 
                                                          FROM operation_report op 
                                                          JOIN production_report pr ON op.id = pr.operation_report_id 
                                                          WHERE pr.proses_kontraktor = 'Rejected Kontraktor'
                                                          AND op.pic = $1 
                                                          ORDER BY op.id";
                                            $arsip = pg_query_params($conn, $arsip_sql, array($_SESSION['username']));
                                            if (!$arsip) {
                                                echo "Error executing query: " . pg_last_error($conn);
                                                exit; // Stop execution if the query fails
                                            }

                                            while ($p = pg_fetch_assoc($arsip)) {
                                        ?>
                                        <a href="report.php" class="dropdown-item py-2 border-bottom">
                                            <div class="notification-content"
                                                style="white-space: normal; max-width: 200px;">
                                                <h6 class="mb-0 fs-1">
                                                    Laporan produksi
                                                    <?php echo date('d M Y', strtotime($p['tanggal'])); ?> ditolak
                                                    <?php echo htmlspecialchars($p['kontraktor']); ?> karena
                                                    <?php echo htmlspecialchars($p['alasan_reject']); ?>. Mohon periksa
                                                    dan tentukan tindakan selanjutnya.
                                                </h6>
                                            </div>
                                        </a>
                                        <?php
                                            }
                                        ?>

                                        <?php
                                            $arsip_sql = "SELECT DISTINCT ON (op.id) op.tanggal
                                                          FROM operation_report op 
                                                          JOIN hourmeter_report hr ON op.id = hr.operation_report_id 
                                                          WHERE hr.proses_admin = 'Uploaded' AND hr.proses_pengawas IS NULL
                                                          AND op.pic = $1 
                                                          ORDER BY op.id";
                                            $arsip = pg_query_params($conn, $arsip_sql, array($_SESSION['username']));
                                            if (!$arsip) {
                                                echo "Error executing query: " . pg_last_error($conn);
                                                exit; // Stop execution if the query fails
                                            }

                                            while ($p = pg_fetch_assoc($arsip)) {
                                        ?>
                                        <a href="report_hourmeter.php" class="dropdown-item py-2 border-bottom">
                                            <div class="notification-content"
                                                style="white-space: normal; max-width: 200px;">
                                                <h6 class="mb-0 fs-1">
                                                    Laporan jam jalan
                                                    <?php echo date('d M Y', strtotime($p['tanggal'])); ?> menunggu
                                                    persetujuan
                                                </h6>
                                            </div>
                                        </a>
                                        <?php
                                            }
                                        ?>

                                        <?php
                                            $arsip_sql = "SELECT DISTINCT ON (op.id) op.tanggal, hr.kontraktor, hr.alasan_reject 
                                                          FROM operation_report op 
                                                          JOIN hourmeter_report hr ON op.id = hr.operation_report_id 
                                                          WHERE hr.proses_kontraktor = 'Rejected Kontraktor'
                                                          AND op.pic = $1 
                                                          ORDER BY op.id";
                                            $arsip = pg_query_params($conn, $arsip_sql, array($_SESSION['username']));
                                            if (!$arsip) {
                                                echo "Error executing query: " . pg_last_error($conn);
                                                exit; // Stop execution if the query fails
                                            }

                                            while ($p = pg_fetch_assoc($arsip)) {
                                        ?>
                                        <a href="report_hourmeter.php" class="dropdown-item py-2 border-bottom">
                                            <div class="notification-content"
                                                style="white-space: normal; max-width: 200px;">
                                                <h6 class="mb-0 fs-1">
                                                    Laporan jam jalan
                                                    <?php echo date('d M Y', strtotime($p['tanggal'])); ?> ditolak
                                                    <?php echo htmlspecialchars($p['kontraktor']); ?> karena
                                                    <?php echo htmlspecialchars($p['alasan_reject']); ?>. Mohon periksa
                                                    dan tentukan tindakan selanjutnya.
                                                </h6>
                                            </div>
                                        </a>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <!-- <a href="riwayat_unduh.php"
                                        class="btn btn-outline-primary btn-sm mt-2 d-block">Lihat Semua</a> -->
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