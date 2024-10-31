<?php
include '../Koneksi.php'; // Ensure the database connection is included

// Fetch admin data based on ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM barcode_kontraktor WHERE id = $id"; // Adjust the query as needed
    $result = pg_query($conn, $query);
    $adminData = pg_fetch_assoc($result);

    // Check if admin data was found
    if (!$adminData) {
        echo "Barcode not found.";
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
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo3.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Acme&family=Coiny&family=Concert+One&family=Fredoka:wght@300..700&family=Outfit:wght@100..900&family=Pacifico&family=Playpen+Sans:wght@100..800&family=Playwrite+DE+Grund:wght@100..400&family=Righteous&family=Sacramento&family=Varela+Round&family=Yatra+One&display=swap"
        rel="stylesheet">
    <style>
    .password {
        font-size: 10px;
        margin-top: 5px;
        color: #8b0707;
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
        color: white;
    }

    .sub-judul {
        font-family: "Varela Round", serif;
        color: white;
    }

    .form-select.text-white option {
        color: black;
    }

    .form-select.text-white {
        color: white;
    }

    .form-control::placeholder {
        color: white;
    }

    .card-preview {
        background-color: #b37219 !important;
    }

    .produksi {
        color: white;
        font-family: "Varela Round", serif;
        font-size: 17px;
    }

    .produksi:hover {
        color: black;
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
                            <h5 class="judul fw-semibold">Form Edit Barcode Kontraktor</h5>
                            <form method="post" action="barcodeKontraktor_update.php" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="nama" class="sub-judul mb-2"> Nama :</label>
                                    <input type="text" class="form-control text-white" id="nama" name="nama"
                                        value="<?php echo htmlspecialchars($adminData['nama']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jabatan" class="sub-judul mb-2">Jabatan : </label>
                                    <input type="text" class="form-control text-white" id="jabatan" name="jabatan"
                                        value="<?php echo htmlspecialchars($adminData['jabatan']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nip" class="sub-judul mb-2">NIP :</label>
                                    <input type="text" class="form-control text-white" id="nip" name="nip"
                                        value="<?php echo htmlspecialchars($adminData['nip']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="file_path" class="sub-judul mb-2">TTD :</label>
                                    <input type="file" class="form-control text-white" id="file_path" name="file_path">
                                    <h5 class="password"> Kosongkan jika tidak ingin mengubah ttd</h5>
                                    <?php if ($adminData['file_path']): ?>
                                    <img src="<?php echo htmlspecialchars($adminData['file_path']); ?>"
                                        alt="Current Image" style="width: 100px; height: auto;">
                                    <?php endif; ?>
                                </div>

                                <input type="hidden" id="id" name="id"
                                    value="<?php echo htmlspecialchars($adminData['id']); ?>">
                                <button type="submit" class="btn btn-primary me-2">Edit</button>
                                <button type="button" class="btn btn-danger" onclick="goBack()">Kembali</button>
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
        window.location.href = 'barcode_Kontraktor.php';
    }
    </script>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>