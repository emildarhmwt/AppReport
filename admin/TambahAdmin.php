<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report Application</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
                        <h5 class="card-title fw-semibold mb-4">Form Admin</h5>
                        <div class="card">
                            <div class="card-body">
                                <form action="admin_aksi.php" method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Nama :</label>
                                        <input type="text" class="form-control" name="nama" id="nama"
                                            placeholder="Input Data" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="shift" class="form-label">Username : </label>
                                        <input type="text" class="form-control" name="username" id="username"
                                            placeholder="Input Data" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="grup" class="form-label">Password :</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Input Data" required>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                                            onclick="togglePasswordVisibility()">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Show Password
                                        </label>
                                    </div>
                                    <div class="mb-5">
                                        <label for="formFile" class="form-label">Foto</label>
                                        <input class="form-control" type="file" name="image" id="image"
                                            accept="image/png, image/jpeg">
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i>
                                        Submit</button>
                                    <button type="button" class="btn btn-primary mx-3"
                                        onclick="window.location.href='admin.php'"><i class="bi bi-arrow-left"></i>
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