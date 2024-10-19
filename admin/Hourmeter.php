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
                        <h5 class="card-title fw-semibold mb-4">Form Hour Meter</h5>
                        <div class="card">
                            <div class="card-body">
                                <form id="form-hourmeter" method="POST" action="hourmeter_aksi.php">
                                    <div class="mb-3">
                                        <label for="equipment" class="form-label">Equipment :</label>
                                        <select class="form-select" id="equipment" name="equipment" required>
                                            <option selected disabled>Equipment</option>
                                            <option value="Equipment1">Equipment 1 </option>
                                            <option value="Equipment2">Equipment 2</option>
                                            <option value="Equipment3">Equipment 3</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="hm_awal" class="form-label">Hour Meter Awal :</label>
                                        <input type="text" class="form-control" id="hm_awal" name="hm_awal"
                                            placeholder="Input Data (gunakan titik untuk desimal)" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="hm_akhir" class="form-label">Hour Meter Akhir :</label>
                                        <input type="text" class="form-control" id="hm_akhir" name="hm_akhir"
                                            placeholder="Input Data (gunakan titik untuk desimal)" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jam_lain" class="form-label">Jam Lain :</label>
                                        <input type="text" class="form-control" id="jam_lain" name="jam_lain"
                                            placeholder="Input Data (gunakan titik untuk desimal)" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="breakdown" class="form-label">Breakdown :</label>
                                        <input type="text" class="form-control" id="breakdown" name="breakdown"
                                            placeholder="Input Data (gunakan titik untuk desimal)" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_operator" class="form-label">No Operator :</label>
                                        <input type="text" class="form-control" id="no_operator" name="no_operator"
                                            placeholder="Input Data (gunakan titik untuk desimal)" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="hujan" class="form-label">Hujan :</label>
                                        <input type="text" class="form-control" id="hujan" name="hujan"
                                            placeholder="Input Data (gunakan titik untuk desimal)" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ket" class="form-label">Keterangan :</label>
                                        <input type="text" class="form-control" id="ket" name="ket"
                                            placeholder="Input Data" required>
                                    </div>
                                    <input type="hidden" id="operation_report_id" name="operation_report_id"
                                        value="<?php echo $_GET['id']; ?>">
                                    <input type="hidden" id="proses_admin" name="proses_admin" value="Uploaded">
                                    <input type="hidden" id="proses_pengawas" name="proses_pengawas" value="">
                                    <input type="hidden" id="proses_kontraktor" name="proses_kontraktor" value="">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i>
                                        Submit</button>
                                    <button type="button" class="btn btn-warning mx-3" onclick="goBack()"><i
                                            class="bi bi-back"></i> Back</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.getElementById('form-hourmeter').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah pengiriman form default
        const formData = new FormData(this);

        fetch('hourmeter_aksi.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    console.log(data.message); // Tampilkan pesan sukses di konsol
                    this.reset(); // Hapus data form setelah berhasil disimpan
                } else {
                    console.error(data.error); // Tampilkan pesan error di konsol
                }
            })
            .catch(error => console.error('Error:', error));
    });

    fetch('Navbar.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('navbar').innerHTML = data;
        });

    function goBack() {
        window.location.href = 'operation.php';
    }
    </script>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>