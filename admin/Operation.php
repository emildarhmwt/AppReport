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
        <div class="body-wrapper">
            <div id="navbar"></div>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-4">Form Operation</h5>
                        <div class="card">
                            <div class="card-body">
                                <form id="form-operation" method="POST" action="operation_aksi.php">
                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Hari / Tanggal :</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="shift" class="form-label">Shift :</label>
                                        <select class="form-select" id="shift" name="shift" required>
                                            <option value="" selected disabled>Shift</option>
                                            <option value="Shift 1 (23.00 s/d 07.00)">Shift 1 (23.00 s/d 07.00)</option>
                                            <option value="Shift 2 (07.00 s/d 15.00)">Shift 2 (07.00 s/d 15.00)</option>
                                            <option value="Shift 3 (15.00 s/d 23.00)">Shift 3 (15.00 s/d 23.00)</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="grup" class="form-label">Giliran / Group :</label>
                                        <select class="form-select" id="grup" name="grup" required>
                                            <option value="" selected disabled>Giliran / Grup</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>
                                            <option value="F">F</option>
                                            <option value="G">G</option>
                                            <option value="H">H</option>
                                            <option value="I">I</option>
                                            <option value="J">J</option>
                                            <option value="K">K</option>
                                            <option value="L">L</option>
                                            <option value="M">M</option>
                                            <option value="N">N</option>
                                            <option value="O">O</option>
                                            <option value="P">P</option>
                                            <option value="Q">Q</option>
                                            <option value="R">R</option>
                                            <option value="S">S</option>
                                            <option value="T">T</option>
                                            <option value="U">U</option>
                                            <option value="V">V</option>
                                            <option value="W">W</option>
                                            <option value="X">X</option>
                                            <option value="Y">Y</option>
                                            <option value="Z">Z</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengawas" class="form-label">Pengawas :</label>
                                        <input type="text" class="form-control" id="pengawas" name="pengawas"
                                            placeholder="Input Data" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lokasi" class="form-label">Lokasi Kerja:</label>
                                        <input type="text" class="form-control" id="lokasi" name="lokasi"
                                            placeholder="Input Data" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status :</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="" selected disabled>PRODUKSI / JAM JALAN </option>
                                            <option value="Produksi">Produksi</option>
                                            <option value="Jam Jalan">Jam Jalan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pic" class="form-label">PIC :</label>
                                        <select class="form-select" id="pic" name="pic" required>
                                            <option value="" selected disabled>PIC</option>
                                            <option value="Supervisor 1">Supervisor 1</option>
                                            <option value="Supervisor 2">Supervisor 2</option>
                                            <option value="Supervisor 3">Supervisor 3</option>
                                            <option value="Supervisor 4">Supervisor 4</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i>
                                        Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.getElementById('form-operation').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah pengiriman form default
        const formData = new FormData(this);

        fetch('operation_aksi.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                // Periksa apakah response valid JSON
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log("Operation report created successfully");
                    if (data.status === 'Produksi') {
                        window.location.href = 'production.php?id=' + data
                            .operationReportId; // Arahkan ke production.php
                    } else if (data.status === 'Jam Jalan') {
                        window.location.href = 'hourmeter.php?id=' + data
                            .operationReportId; // Arahkan ke hourmeter.php
                    }
                } else {
                    console.error(data.error);
                }
            })
            .catch(error => console.error('Error:', error));
    });

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