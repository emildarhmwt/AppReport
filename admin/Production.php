<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report Application</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
    .notif {
        font-size: 10px;
        margin-top: 5px;
        margin-left: 5px;
        color: red;
    }

    .wajib_isi {
        color: red;
    }
    </style>
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
                        <h5 class="card-title fw-semibold mb-4">Form Production</h5>
                        <div class="card">
                            <div class="card-body">
                                <form id="form-production" method="POST" action="production_aksi.php">
                                    <div class="mb-3">
                                        <label for="executor" class="form-label"><span class="wajib_isi">*</span>
                                            Executor :</label>
                                        <select class="form-select" id="excecutor" name="excecutor" required>
                                            <option value="" selected disabled>Executor</option>
                                            <option value="SPPH 95 - PT PUTRA PERKASA ABADI">
                                                SPPH 95 - PT PUTRA PERKASA ABADI
                                            </option>
                                            <option value="SPPH 17518 - PT PUTRA PERKASA ABADI">
                                                SPPH 17518 - PT PUTRA PERKASA ABADI
                                            </option>
                                            <option value="SPPH 17443 - PT PUTRA PERKASA ABADI">
                                                SPPH 17443 - PT PUTRA PERKASA ABADI
                                            </option>
                                            <option value="ELEKTRIFIKASI - PT BUKIT ASAM TBK">
                                                ELEKTRIFIKASI - PT BUKIT ASAM TBK
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alat" class="form-label"><span class="wajib_isi">*</span> Alat Gali
                                            / Muat :</label>
                                        <select class="form-select" id="alat" name="alat" required>
                                            <option value="" selected disabled>Alat Gali / Muat</option>
                                            <option value="E2043 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                                E2043 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                            </option>
                                            <option value="E2044 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                                E2044 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                            </option>
                                            <option value="E2045 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                                E2045 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                            </option>
                                            <option value="E1226 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                                E1226 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                            </option>
                                            <option value="E1227 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                                E1227 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                            </option>
                                            <option value="E1228 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                                E1228 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                            </option>
                                            <option value="E1229 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                                E1229 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                            </option>
                                            <option value="E1230 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                                E1230 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                            </option>
                                            <option value="E6101 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                                E6101 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                            </option>
                                            <option value="E6102 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                                E6102 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                            </option>
                                            <option value="E6103 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                                E6103 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                            </option>
                                            <option value="E6104 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                                E6104 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                            </option>
                                            <option value="E6105 - PT PUTRA PERKASA ABADI ( SPPH 17443 )">
                                                E6105 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                            </option>
                                            <option value="E52007 - PT PUTRA PERKASA ABADI">
                                                E52007 - PT PUTRA PERKASA ABADI
                                            </option>
                                            <option value="E52009 - PT PUTRA PERKASA ABADI">
                                                E52009 - PT PUTRA PERKASA ABADI
                                            </option>
                                            <option value="SE-3001 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )">
                                                SE-3001 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )
                                            </option>
                                            <option value="SE-3002 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )">
                                                SE-3002 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )
                                            </option>
                                            <option value="SE-3003 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )">
                                                SE-3003 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )
                                            </option>
                                            <option value="SE-3004 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )">
                                                SE-3004 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )
                                            </option>
                                            <option value="SE-3005 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )">
                                                SE-3005 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )
                                            </option>
                                            <option value="SE-3006 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )">
                                                SE-3006 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )
                                            </option>
                                            <option value="SE-3007 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )">
                                                SE-3007 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="timbunan" class="form-label"><span class="wajib_isi">*</span>
                                            Timbunan :</label>
                                        <select class="form-select" id="timbunan" name="timbunan" required>
                                            <option value="" selected disabled>Timbunan</option>
                                            <option value="Banko Barat - Disposal Backfill Pit 1 Utara">
                                                Banko Barat - Disposal Backfill Pit 1 Utara
                                            </option>
                                            <option value="Banko Tengah - Disposal Utara Pit 3 Timur">
                                                Banko Tengah - Disposal Utara Pit 3 Timur
                                            </option>
                                            <option value="Banko Tengah - Disposal Selatan Pit 3 Timur">
                                                Banko Tengah - Disposal Selatan Pit 3 Timur
                                            </option>
                                            <option value="Banko Barat - Disposal Selatan Timur Pit 2">
                                                Banko Barat - Disposal Selatan Timur Pit 2
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="material" class="form-label"><span class="wajib_isi">*</span>
                                            Material :</label>
                                        <select class="form-select" id="material" name="material" required>
                                            <option value="" selected disabled>Material</option>
                                            <option value="OB A1">OB A1</option>
                                            <option value="OB A2">OB A2</option>
                                            <option value="OB B1">OB B1</option>
                                            <option value="OB B2">OB B2</option>
                                            <option value="OB BC">OB BC</option>
                                            <option value="OB C">OB C</option>
                                            <option value="Overburden">Overburden</option>
                                            <option value="Lumpur">Lumpur</option>
                                            <option value="Lumpur C">Lumpur C</option>
                                            <option value="Interburden">Interburden</option>
                                            <option value="Topsoil">Topsoil</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jarak" class="form-label"><span class="wajib_isi">*</span> Jarak
                                            :</label>
                                        <input type="text" class="form-control" id="jarak" name="jarak"
                                            placeholder="Input Data (gunakan titik untuk desimal)" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="tipe" class="form-label"><span class="wajib_isi">*</span>
                                                    Tipe Hauler 1 :</label>
                                                <select class="form-select" id="tipe" name="tipe" required
                                                    onchange="updateMuatan()">
                                                    <option value="" selected disabled>Tipe Hauler</option>
                                                    <!-- Populate options from muatan table -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="ritase" class="form-label"><span class="wajib_isi">*</span>
                                                    Ritase 1 :</label>
                                                <input type="number" class="form-control" id="ritase" name="ritase"
                                                    placeholder="Input Data" required>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="text" class="form-control" id="muatan" name="muatan"
                                        placeholder="Muatan" readonly>
                                    <input type="text" class="form-control" id="volume" name="volume"
                                        placeholder="Volume" readonly>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="tipe" class="form-label">Tipe Hauler 2 :</label>
                                                <select class="form-select" id="tipe2" name="tipe2"
                                                    onchange="updateMuatan2()">
                                                    <option value="" selected disabled>Tipe Hauler</option>
                                                    <option value="none">Tidak Ada</option> <!-- Added option -->
                                                    <!-- Populate options from muatan table -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="ritase" class="form-label">Ritase 2 :</label>
                                                <input type="number" class="form-control" id="ritase2" name="ritase2"
                                                    placeholder="Input Data" required>
                                                <h5 class="notif"> Jika tidak ada nilai ritase, isikan 0
                                                </h5>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="text" class="form-control" id="muatan2" name="muatan2"
                                        placeholder="Muatan" readonly>
                                    <input type="text" class="form-control" id="volume2" name="volume2"
                                        placeholder="Volume" readonly>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="total_ritase" class="form-label">
                                                    Total Ritase :</label>
                                                <input type="number" class="form-control" id="total_ritase"
                                                    name="ritase" placeholder="Total Ritase" required>
                                            </div>
                                        </div>
                                        <!-- <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="muatan" class="form-label"><span class="wajib_isi">*</span>
                                                    Muatan :</label>
                                                <input type="number" class="form-control" id="muatan" name="muatan"
                                                    placeholder="Input Data" required>
                                            </div>
                                        </div> -->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="volume" class="form-label">Volume :</label>
                                                <input type="number" class="form-control" id="total_volume"
                                                    name="total_volume" placeholder="Total Volume" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="operation_report_id" name="operation_report_id"
                                        value="<?php echo $_GET['id']; ?>">
                                    <input type="hidden" id="proses_admin" name="proses_admin" value="Uploaded">
                                    <input type="hidden" id="proses_pengawas" name="proses_pengawas" value="">
                                    <input type="hidden" id="proses_kontraktor" name="proses_kontraktor" value="">
                                    <input type="hidden" id="alasan_reject" name="alasan_reject" value="">
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
    fetch('Navbar.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('navbar').innerHTML = data;
        });

    function goBack() {
        window.location.href = 'operation.php';
    }

    function updateMuatan() {
        const tipe = document.getElementById('tipe').value;
        // Fetch muatan based on tipe
        fetch(`getMuatan.php?tipe=${tipe}`)
            .then(response => response.json())
            .then(data => {
                const muatan = data.jumlah; // Assuming data returns jumlah
                document.getElementById('muatan').value = muatan;
                updateVolume();
            });
    }

    function updateMuatan2() {
        const tipe2 = document.getElementById('tipe2').value;
        if (tipe2 === 'none') {
            document.getElementById('ritase2').value = 0;
            document.getElementById('muatan2').value = 0;
            document.getElementById('volume2').value = 0;
        } else {
            // Fetch muatan based on tipe2
            fetch(`getMuatan.php?tipe=${tipe2}`)
                .then(response => response.json())
                .then(data => {
                    const muatan2 = data.jumlah; // Assuming data returns jumlah
                    document.getElementById('muatan2').value = muatan2;
                    updateVolume2();
                });
        }
    }

    function updateVolume() {
        const ritase = document.getElementById('ritase').value;
        const muatan = document.getElementById('muatan').value;
        document.getElementById('volume').value = ritase * muatan;
        updateTotal();
    }

    function updateVolume2() {
        const ritase2 = document.getElementById('ritase2').value;
        const muatan2 = document.getElementById('muatan2').value;
        document.getElementById('volume2').value = ritase2 * muatan2;
        updateTotal();
    }

    function updateTotal() {
        const volume = document.getElementById('volume').value;
        const volume2 = document.getElementById('volume2').value;
        const ritase = document.getElementById('ritase').value;
        const ritase2 = document.getElementById('ritase2').value;
        document.getElementById('total_ritase').value = parseInt(ritase) + parseInt(ritase2);
        document.getElementById('total_volume').value = parseInt(volume) + parseInt(volume2);
    }

    document.getElementById('form-production').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah pengiriman form default
        const formData = new FormData(this);

        fetch('production_aksi.php', {
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
    </script>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>