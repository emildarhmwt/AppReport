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
                        <h5 class="card-title fw-semibold mb-4">Form Barcode Kontraktor</h5>
                        <div class="card">
                            <div class="card-body">
                                <form action="barcodeKontraktor_aksi.php" method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Nama :</label>
                                        <input type="text" class="form-control" name="nama" id="nama"
                                            placeholder="Input Data" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="shift" class="form-label">Jabatan : </label>
                                        <input type="text" class="form-control" name="jabatan" id="jabatan"
                                            placeholder="Input Data" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="grup" class="form-label">NIP :</label>
                                        <input type="text" class="form-control" id="nip" name="nip"
                                            placeholder="Input Data" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Barcode</label>
                                        <input class="form-control" type="file" id="ttd" name="ttd">
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i>
                                        Submit</button>
                                    <button type="button" class="btn btn-primary mx-3"
                                        onclick="window.location.href='Barcode_kontraktor.php'"><i
                                            class="bi bi-arrow-left"></i>
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
    </script>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>