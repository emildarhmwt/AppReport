<?php
include '../Koneksi.php'; // Ensure the database connection is included

// Fetch admin data based on ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM user_report WHERE id = $id"; // Adjust the query as needed
    $result = pg_query($conn, $query);
    $userData = pg_fetch_assoc($result);

    // Check if admin data was found
    if (!$userData) {
        echo "Admin not found.";
        exit;
    }
} else {
    echo "ID not provided.";
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report Application</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <style>
    .password {
        font-size: 10px;
        margin-top: 5px;
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
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold mb-4">Form Edit User</h5>
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" action="user_update.php" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label"> Nama :</label>
                                            <input type="text" class="form-control" id="nama" name="nama"
                                                value="<?php echo htmlspecialchars($userData['nama']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username :
                                            </label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                value="<?php echo htmlspecialchars($userData['username']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="jam_lain" class="form-label">Password :</label>
                                            <input type="password" class="form-control" id="password" name="password">
                                            <h5 class="password"> Kosongkan jika tidak ingin mengubah password</h5>
                                        </div>
                                        <div class="form-check mb-5">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault" onclick="togglePasswordVisibility()">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Show Password
                                            </label>
                                        </div>
                                        <input type="hidden" id="id" name="id"
                                            value="<?php echo htmlspecialchars($userData['id']); ?>">
                                        <input type="hidden" id="current_password" name="current_password"
                                            value="<?php echo htmlspecialchars($userData['password']); ?>">
                                        <button type="submit" class="btn btn-primary">Edit</button>
                                        <button type="button" class="btn btn-warning" onclick="goBack()">Back</button>
                                    </form>
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

    function goBack() {
        window.location.href = 'User.php';
    }

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