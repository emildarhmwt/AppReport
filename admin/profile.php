<?php
session_start();
include '../Koneksi.php';
$admin_id = $_SESSION['id'];

// Fetch admin data using PostgreSQL
$sql = "SELECT nama, username, file_admin FROM admin_report WHERE id = $1";
$result = pg_query_params($conn, $sql, array($admin_id));

if ($result) {
    $admin = pg_fetch_assoc($result);
    if (!$admin) {
        echo "No admin data found.";
        exit; // Stop execution if no data is found
    }
} else {
    echo "Error fetching admin data.";
    exit; // Stop execution on error
}

pg_close($conn);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report Application</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo3.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
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

    .password {
        font-size: 10px;
        margin-top: 5px;
        color: #8b0707;
    }

    .card-preview {
        background-color: #5ea1b5 !important;
    }

    .varela-round-regular {
        font-family: "Varela Round", sans-serif;
        font-weight: 400;
        font-style: normal;
    }

    .card-subtitle {
        color: #0f3f61;
        font-family: "Varela Round", sans-serif;
        font-size: 20px;
    }

    .sub-judul {
        font-family: "Varela Round", serif;
        color: #0f3f61;
    }
    </style>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <div id="navbar"></div>
            <!--  Header End -->
            <div class="container-fluid">
                <div class="card" style="border-radius: 10px 10px 10px 10px;">
                    <div class=" card-header" style="background-color: #092c43; width: 100%; font-size: 25px; color:white; font-family:
                        Varela Round;">
                        Profil
                    </div>
                    <div class=" card-body">
                        <div class="row">
                            <!-- Column -->
                            <div class="col-lg-4 col-xlg-3 col-md-5">
                                <div class="card card-preview">
                                    <div class="card-body">
                                        <center class="m-t-30">
                                            <h4 class="card-title m-t-10"><img
                                                    src="<?php echo isset($admin['file_admin']) ? htmlspecialchars($admin['file_admin']) : 'default.png'; ?>"
                                                    alt="Image" style="width: 150px; height: auto;"></h4>
                                            <h6 class="card-subtitle">Admin</h6>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-xlg-9 col-md-7">
                                <div class="card card-preview">
                                    <div class="card-body">
                                        <form class="form-horizontal form-material mx-2" method="post"
                                            action="profile_act.php" enctype="multipart/form-data">
                                            <div class="form-group mb-3">
                                                <label class="col-md-12 sub-judul mb-2">Nama</label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control text-white"
                                                        value="<?php echo htmlspecialchars($admin['nama']); ?>"
                                                        id="nama" name="nama" required="required">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="example-email"
                                                    class="col-md-12 sub-judul mb-2">Username</label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control text-white"
                                                        value="<?php echo htmlspecialchars($admin['username']); ?>"
                                                        id="username" name="username" required="required">
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <label for="jam_lain" class="sub-judul mb-2">Password :</label>
                                                <input type="password" class="form-control text-white" id="password"
                                                    name="password">
                                                <h5 class="password"> Kosongkan jika tidak ingin mengubah password</h5>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckDefault" onclick="togglePasswordVisibility()"
                                                    style="border: 1px solid #0f3f61;">
                                                <label class="form-check-label sub-judul" for="flexCheckDefault">
                                                    Show Password
                                                </label>
                                            </div>
                                            <div class="form-group mb-3">
                                                <div class="mb-3">
                                                    <label for="foto" class="sub-judul mb-2">Foto</label>
                                                    <input class="form-control text-white" type="file" id="file_path"
                                                        name="file_path">
                                                    <h5 class="password">Kosongkan jika tidak ingin mengubah foto</h5>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn btn-primary">
                                                        Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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
    <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="../assets/js/dashboard.js"></script>
</body>

</html>