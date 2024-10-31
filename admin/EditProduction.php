<?php
include '../Koneksi.php';

// Fetch admin data based on ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM production_report WHERE id = $id"; // Adjust the query as needed
    $result = pg_query($conn, $query);
    $adminData = pg_fetch_assoc($result);

    // Check if admin data was found
    if (!$adminData) {
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
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo3.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Acme&family=Coiny&family=Concert+One&family=Fredoka:wght@300..700&family=Outfit:wght@100..900&family=Pacifico&family=Playpen+Sans:wght@100..800&family=Playwrite+DE+Grund:wght@100..400&family=Righteous&family=Sacramento&family=Varela+Round&family=Yatra+One&display=swap"
        rel="stylesheet">
    <style>
    .notif {
        font-size: 12px;
        margin-top: 5px;
        margin-left: 5px;
        color: #6a0707;
    }

    .wajib_isi {
        color: #8b0707;
        font-size: 15px;
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
                            <h5 class="judul fw-semibold">Edit Produksi</h5>
                            <form method="post" action="production_update.php" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="executor" class="sub-judul mb-2">
                                        Executor :</label>
                                    <select class="form-select text-white" id="excecutor" name="excecutor" required>
                                        <option value="" disabled>Executor</option>
                                        <option value="SPPH 95 - PT PUTRA PERKASA ABADI"
                                            <?php echo ($adminData['excecutor'] == 'SPPH 95 - PT PUTRA PERKASA ABADI') ? 'selected' : ''; ?>>
                                            SPPH 95 - PT PUTRA PERKASA ABADI
                                        </option>
                                        <option value="SPPH 17518 - PT PUTRA PERKASA ABADI"
                                            <?php echo ($adminData['excecutor'] == 'SPPH 17518 - PT PUTRA PERKASA ABADI') ? 'selected' : ''; ?>>
                                            SPPH 17518 - PT PUTRA PERKASA ABADI
                                        </option>
                                        <option value="SPPH 17443 - PT PUTRA PERKASA ABADI"
                                            <?php echo ($adminData['excecutor'] == 'SPPH 17443 - PT PUTRA PERKASA ABADI') ? 'selected' : ''; ?>>
                                            SPPH 17443 - PT PUTRA PERKASA ABADI
                                        </option>
                                        <option value="ELEKTRIFIKASI - PT BUKIT ASAM TBK"
                                            <?php echo ($adminData['excecutor'] == 'ELEKTRIFIKASI - PT BUKIT ASAM TBK') ? 'selected' : ''; ?>>
                                            ELEKTRIFIKASI - PT BUKIT ASAM TBK
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="alat" class="sub-judul mb-2"> Alat Gali/ Muat :</label>
                                    <select class="form-select text-white" id="alat" name="alat" required>
                                        <option value="" selected disabled>Alat Gali / Muat</option>
                                        <option value="E2043 - PT PUTRA PERKASA ABADI ( SPPH 17443 )"
                                            <?php echo ($adminData['alat'] == 'E2043 - PT PUTRA PERKASA ABADI ( SPPH 17443 )') ? 'selected' : ''; ?>>
                                            E2043 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                        </option>
                                        <option value="E2044 - PT PUTRA PERKASA ABADI ( SPPH 17443 )"
                                            <?php echo ($adminData['alat'] == 'E2044 - PT PUTRA PERKASA ABADI ( SPPH 17443 )') ? 'selected' : ''; ?>>
                                            E2044 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                        </option>
                                        <option value="E2045 - PT PUTRA PERKASA ABADI ( SPPH 17443 )"
                                            <?php echo ($adminData['alat'] == 'E2045 - PT PUTRA PERKASA ABADI ( SPPH 17443 )') ? 'selected' : ''; ?>>
                                            E2045 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                        </option>
                                        <option value="E1226 - PT PUTRA PERKASA ABADI ( SPPH 17443 )"
                                            <?php echo ($adminData['alat'] == 'E1226 - PT PUTRA PERKASA ABADI ( SPPH 17443 )') ? 'selected' : ''; ?>>
                                            E1226 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                        </option>
                                        <option value="E1227 - PT PUTRA PERKASA ABADI ( SPPH 17443 )"
                                            <?php echo ($adminData['alat'] == 'E1227 - PT PUTRA PERKASA ABADI ( SPPH 17443 )') ? 'selected' : ''; ?>>
                                            E1227 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                        </option>
                                        <option value="E1228 - PT PUTRA PERKASA ABADI ( SPPH 17443 )"
                                            <?php echo ($adminData['alat'] == 'E1228 - PT PUTRA PERKASA ABADI ( SPPH 17443 )') ? 'selected' : ''; ?>>
                                            E1228 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                        </option>
                                        <option value="E1229 - PT PUTRA PERKASA ABADI ( SPPH 17443 )"
                                            <?php echo ($adminData['alat'] == 'E1229 - PT PUTRA PERKASA ABADI ( SPPH 17443 )') ? 'selected' : ''; ?>>
                                            E1229 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                        </option>
                                        <option value="E1230 - PT PUTRA PERKASA ABADI ( SPPH 17443 )"
                                            <?php echo ($adminData['alat'] == 'E1230 - PT PUTRA PERKASA ABADI ( SPPH 17443 )') ? 'selected' : ''; ?>>
                                            E1230 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                        </option>
                                        <option value="E6101 - PT PUTRA PERKASA ABADI ( SPPH 17443 )"
                                            <?php echo ($adminData['alat'] == 'E6101 - PT PUTRA PERKASA ABADI ( SPPH 17443 )') ? 'selected' : ''; ?>>
                                            E6101 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                        </option>
                                        <option value="E6102 - PT PUTRA PERKASA ABADI ( SPPH 17443 )"
                                            <?php echo ($adminData['alat'] == 'E6102 - PT PUTRA PERKASA ABADI ( SPPH 17443 )') ? 'selected' : ''; ?>>
                                            E6102 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                        </option>
                                        <option value="E6103 - PT PUTRA PERKASA ABADI ( SPPH 17443 )"
                                            <?php echo ($adminData['alat'] == 'E6103 - PT PUTRA PERKASA ABADI ( SPPH 17443 )') ? 'selected' : ''; ?>>
                                            E6103 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                        </option>
                                        <option value="E6104 - PT PUTRA PERKASA ABADI ( SPPH 17443 )"
                                            <?php echo ($adminData['alat'] == 'E6104 - PT PUTRA PERKASA ABADI ( SPPH 17443 )') ? 'selected' : ''; ?>>
                                            E6104 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                        </option>
                                        <option value="E6105 - PT PUTRA PERKASA ABADI ( SPPH 17443 )"
                                            <?php echo ($adminData['alat'] == 'E6105 - PT PUTRA PERKASA ABADI ( SPPH 17443 )') ? 'selected' : ''; ?>>
                                            E6105 - PT PUTRA PERKASA ABADI ( SPPH 17443 )
                                        </option>
                                        <option value="E52007 - PT PUTRA PERKASA ABADI"
                                            <?php echo ($adminData['alat'] == 'E52007 - PT PUTRA PERKASA ABADI') ? 'selected' : ''; ?>>
                                            E52007 - PT PUTRA PERKASA ABADI
                                        </option>
                                        <option value="E52009 - PT PUTRA PERKASA ABADI"
                                            <?php echo ($adminData['alat'] == 'E52009 - PT PUTRA PERKASA ABADI') ? 'selected' : ''; ?>>
                                            E52009 - PT PUTRA PERKASA ABADI
                                        </option>
                                        <option value="SE-3001 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )"
                                            <?php echo ($adminData['alat'] == 'SE-3001 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )') ? 'selected' : ''; ?>>
                                            SE-3001 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )
                                        </option>
                                        <option value="SE-3002 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )"
                                            <?php echo ($adminData['alat'] == 'SE-3002 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )') ? 'selected' : ''; ?>>
                                            SE-3002 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )
                                        </option>
                                        <option value="SE-3003 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )"
                                            <?php echo ($adminData['alat'] == 'SE-3003 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )') ? 'selected' : ''; ?>>
                                            SE-3003 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )
                                        </option>
                                        <option value="SE-3004 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )"
                                            <?php echo ($adminData['alat'] == 'SE-3004 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )') ? 'selected' : ''; ?>>
                                            SE-3004 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )
                                        </option>
                                        <option value="SE-3005 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )"
                                            <?php echo ($adminData['alat'] == 'SE-3005 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )') ? 'selected' : ''; ?>>
                                            SE-3005 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )
                                        </option>
                                        <option value="SE-3006 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )"
                                            <?php echo ($adminData['alat'] == 'SE-3006 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )') ? 'selected' : ''; ?>>
                                            SE-3006 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )
                                        </option>
                                        <option value="SE-3007 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )"
                                            <?php echo ($adminData['alat'] == 'SE-3007 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )') ? 'selected' : ''; ?>>
                                            SE-3007 - PT BUKIT ASAM TBK ( Penambangan Swakelola 1 )
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="timbunan" class="sub-judul mb-2"> Timbunan :</label>
                                    <select class="form-select text-white" id="timbunan" name="timbunan" required>
                                        <option value="" selected disabled>Timbunan</option>
                                        <option value="Banko Barat - Disposal Backfill Pit 1 Utara"
                                            <?php echo ($adminData['timbunan'] == 'Banko Barat - Disposal Backfill Pit 1 Utara') ? 'selected' : ''; ?>>
                                            Banko Barat - Disposal Backfill Pit 1 Utara
                                        </option>
                                        <option value="Banko Tengah - Disposal Utara Pit 3 Timur"
                                            <?php echo ($adminData['timbunan'] == 'Banko Tengah - Disposal Utara Pit 3 Timur') ? 'selected' : ''; ?>>
                                            Banko Tengah - Disposal Utara Pit 3 Timur
                                        </option>
                                        <option value="Banko Tengah - Disposal Selatan Pit 3 Timur"
                                            <?php echo ($adminData['timbunan'] == 'Banko Tengah - Disposal Selatan Pit 3 Timur') ? 'selected' : ''; ?>>
                                            Banko Tengah - Disposal Selatan Pit 3 Timur
                                        </option>
                                        <option value="Banko Barat - Disposal Selatan Timur Pit 2"
                                            <?php echo ($adminData['timbunan'] == 'Banko Barat - Disposal Selatan Timur Pit 2') ? 'selected' : ''; ?>>
                                            Banko Barat - Disposal Selatan Timur Pit 2
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="material" class="sub-judul mb-2">
                                        Material :</label>
                                    <select class="form-select text-white" id="material" name="material" required>
                                        <option value="" selected disabled>Material</option>
                                        <option value="OB A1"
                                            <?php echo ($adminData['material'] == 'OB A1') ? 'selected' : ''; ?>>
                                            OB A1
                                        </option>
                                        <option value="OB A2"
                                            <?php echo ($adminData['material'] == 'OB A2') ? 'selected' : ''; ?>>
                                            OB A2
                                        </option>
                                        <option value="OB B1"
                                            <?php echo ($adminData['material'] == 'OB B1') ? 'selected' : ''; ?>>
                                            OB B1
                                        </option>
                                        <option value="OB B2"
                                            <?php echo ($adminData['material'] == 'OB B2') ? 'selected' : ''; ?>>
                                            OB B2
                                        </option>
                                        <option value="OB BC"
                                            <?php echo ($adminData['material'] == 'OB BC') ? 'selected' : ''; ?>>
                                            OB BC
                                        </option>
                                        <option value="OB C"
                                            <?php echo ($adminData['material'] == 'OB C') ? 'selected' : ''; ?>>
                                            OB C
                                        </option>
                                        <option value="Overburden"
                                            <?php echo ($adminData['material'] == 'Overburden') ? 'selected' : ''; ?>>
                                            Overburden
                                        </option>
                                        <option value="Lumpur"
                                            <?php echo ($adminData['material'] == 'Lumpur') ? 'selected' : ''; ?>>
                                            Lumpur
                                        </option>
                                        <option value="Lumpur C"
                                            <?php echo ($adminData['material'] == 'Lumpur C') ? 'selected' : ''; ?>>
                                            Lumpur C
                                        </option>
                                        <option value="Interburden"
                                            <?php echo ($adminData['material'] == 'Interburden') ? 'selected' : ''; ?>>
                                            Interburden
                                        </option>
                                        <option value="Topsoil"
                                            <?php echo ($adminData['material'] == 'Topsoil') ? 'selected' : ''; ?>>
                                            Topsoil
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="jarak" class="sub-judul mb-2"> Jarak
                                        :</label>
                                    <input type="text" class="form-control text-white" id="jarak" name="jarak"
                                        value="<?php echo htmlspecialchars($adminData['jarak']); ?>" required>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="tipe" class="sub-judul mb-2">
                                                Tipe Hauler 1 :</label>
                                            <select class="form-select text-white" id="tipe" name="tipe" required>
                                                <option value="" selected disabled>Tipe Hauler</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="ritase" class="sub-judul mb-2">
                                                Ritase 1 :</label>
                                            <input type="number" class="form-control text-white" id="ritase"
                                                name="ritase"
                                                value="<?php echo htmlspecialchars($adminData['ritase']); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="tipe" class="sub-judul mb-2">
                                                Tipe Hauler 2 :</label>
                                            <select class="form-select text-white" id="tipe2" name="tipe2" required>
                                                <option value="" selected disabled>Tipe Hauler</option>
                                                value="<?php echo htmlspecialchars($adminData['tipe2']); ?>">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="ritase" class="sub-judul mb-2">
                                                Ritase 2 :</label>
                                            <input type="number" class="form-control text-white" id="ritase2"
                                                name="ritase2" placeholder="Input Data"
                                                value="<?php echo htmlspecialchars($adminData['ritase2']); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="total_ritase" class="sub-judul mb-2">
                                                Total Ritase :</label>
                                            <input type="number" class="form-control text-white" id="total_ritase"
                                                name="total_ritase"
                                                value="<?php echo htmlspecialchars($adminData['total_ritase']); ?>"
                                                readonly oninput="calculateTotalRitase()">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="volume" class="sub-judul mb-2">Volume :</label>
                                            <input type="number" class="form-control text-white" id="total_volume"
                                                name="total_volume"
                                                value="<?php echo htmlspecialchars($adminData['total_volume']); ?>"
                                                readonly oninput="calculateVolumes()">
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" id="id" name="id" value="<?php echo $_GET['id']; ?>">
                                <input type="hidden" id="operation_report_id" name="operation_report_id"
                                    value="<?php echo htmlspecialchars($adminData['operation_report_id']); ?>">
                                <input type="hidden" id="proses_admin" name="proses_admin"
                                    value="<?php echo htmlspecialchars($adminData['proses_admin']); ?>">
                                <input type="hidden" id="proses_pengawas" name="proses_pengawas"
                                    value="<?php echo htmlspecialchars($adminData['proses_pengawas']); ?>">
                                <input type="hidden" id="proses_kontraktor" name="proses_kontraktor"
                                    value="<?php echo htmlspecialchars($adminData['proses_kontraktor']); ?>">
                                <input type="hidden" id="alasan_reject" name="alasan_reject"
                                    value="<?php echo htmlspecialchars($adminData['alasan_reject']); ?>">
                                <input type="hidden" id="kontraktor" name="kontraktor"
                                    value="<?php echo htmlspecialchars($adminData['kontraktor']); ?>">
                                <input type="hidden" id="name_pengawas" name="name_pengawas"
                                    value="<?php echo htmlspecialchars($adminData['name_pengawas']); ?>">
                                <input type="hidden" id="file_pengawas" name="file_pengawas"
                                    value="<?php echo htmlspecialchars($adminData['file_pengawas']); ?>">
                                <input type="hidden" id="name_kontraktor" name="name_kontraktor"
                                    value="<?php echo htmlspecialchars($adminData['name_kontraktor']); ?>">
                                <input type="hidden" id="file_kontraktor" name="file_kontraktor"
                                    value="<?php echo htmlspecialchars($adminData['file_kontraktor']); ?>">
                                <input type="hidden" class="form-control" id="muatan" name="muatan"
                                    value="<?php echo htmlspecialchars($adminData['muatan']); ?>" readonly>
                                <input type="hidden" class="form-control" id="volume" name="volume"
                                    value="<?php echo htmlspecialchars($adminData['volume']); ?>" readonly
                                    oninput="calculateVolumes()">
                                <input type="hidden" class="form-control" id="muatan2" name="muatan2"
                                    value="<?php echo htmlspecialchars($adminData['muatan2']); ?>" readonly>
                                <input type="hidden" class="form-control" id="volume2" name="volume2"
                                    value="<?php echo htmlspecialchars($adminData['volume2']); ?>" readonly
                                    oninput="calculateVolumes()">

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
        const operationReportId = document.getElementById('operation_report_id').value;
        window.location.href = 'Preview.php?id=' +
            operationReportId; // Redirect to Preview.php with operation_report_id
    }

    let muatanData = {};

    // Fetch muatan data from server
    fetch('getMuatan.php')
        .then(response => response.json())
        .then(data => {
            muatanData = data.reduce((acc, item) => {
                acc[item.tipe] = item.jumlah;
                return acc;
            }, {});

            // Populate select options for tipe
            const tipeSelect = document.getElementById('tipe');
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.tipe;
                option.textContent = item.tipe;
                // Set selected if it matches the existing value
                if (option.value === "<?php echo htmlspecialchars($adminData['tipe']); ?>") {
                    option.selected = true;
                }
                tipeSelect.appendChild(option);
            });

            // Populate select options for tipe2
            const tipe2Select = document.getElementById('tipe2');
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.tipe;
                option.textContent = item.tipe;
                // Set selected if it matches the existing value
                if (option.value === "<?php echo htmlspecialchars($adminData['tipe2']); ?>") {
                    option.selected = true;
                }
                tipe2Select.appendChild(option);
            });
        });

    // Update muatan value based on selected tipe
    document.getElementById('tipe').addEventListener('change', function() {
        const selectedTipe = this.value;
        document.getElementById('muatan').value = muatanData[selectedTipe] || 0;
        calculateTotalRitase();
    });

    document.getElementById('tipe2').addEventListener('change', function() {
        const selectedTipe = this.value;
        document.getElementById('muatan2').value = muatanData[selectedTipe] || 0;
        calculateTotalRitase();
    });

    document.getElementById('ritase').addEventListener('input', function() {
        calculateVolumes();
        calculateTotalRitase();
    });
    document.getElementById('ritase2').addEventListener('input', function() {
        calculateVolumes();
        calculateTotalRitase();
    });


    function calculateTotalRitase() {
        const ritase = parseFloat(document.getElementById('ritase').value) || 0;
        const ritase2 = parseFloat(document.getElementById('ritase2').value) || 0;

        const totalRitase = ritase + ritase2;
        document.getElementById('total_ritase').value = totalRitase;
    }

    function calculateVolumes() {
        const ritase = parseFloat(document.getElementById('ritase').value) || 0;
        const muatan = parseFloat(document.getElementById('muatan').value) || 0;
        const volume = ritase * muatan;
        document.getElementById('volume').value = volume;

        const ritase2 = parseFloat(document.getElementById('ritase2').value) || 0;
        const muatan2 = parseFloat(document.getElementById('muatan2').value) || 0;
        const volume2 = ritase2 * muatan2;
        document.getElementById('volume2').value = volume2;

        const totalVolume = volume + volume2;
        document.getElementById('total_volume').value = totalVolume;
    }
    </script>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>