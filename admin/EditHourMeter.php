<?php
include '../Koneksi.php';

// Fetch admin data based on ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM hourmeter_report WHERE id = $id"; // Adjust the query as needed
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

$equipmentQuery = "SELECT equipment, tipe_unit FROM equipment";
$equipmentResult = pg_query($conn, $equipmentQuery);

$equipmentData = [];
while ($row = pg_fetch_assoc($equipmentResult)) {
    $equipmentData[] = $row;
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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Acme&family=Coiny&family=Concert+One&family=Fredoka:wght@300..700&family=Outfit:wght@100..900&family=Pacifico&family=Playpen+Sans:wght@100..800&family=Playwrite+DE+Grund:wght@100..400&family=Righteous&family=Sacramento&family=Varela+Round&family=Yatra+One&display=swap"
        rel="stylesheet">
</head>
<style>
.body-wrapper {
    background-image: url(../assets/images/backgrounds/4.png);
    background-size: cover;
    background-repeat: no-repeat;
}

.suggestions {
    border: 1px solid #ccc;
    max-height: 150px;
    overflow-y: auto;
    display: none;
    position: absolute;
    background: white;
    z-index: 1000;
    width: 46.5%;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    border-radius: 10px;
}

.suggestions div {
    padding: 8px;
    cursor: pointer;
}

.suggestions div:hover {
    background-color: #f0f0f0;
}

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
    color: #0f3f61;
}

.sub-judul {
    font-family: "Varela Round", serif;
    color: #0f3f61;
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
                            <h5 class="judul fw-semibold">Edit Jam Jalan</h5>
                            <form method="post" action="hourmeter_update.php" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="equipment" class="sub-judul mb-2"><span
                                                    class="wajib_isi">*</span>
                                                Equipment :</label>
                                            <input type="text" class="form-control text-white" id="equipment"
                                                name="equipment"
                                                value="<?php echo htmlspecialchars($adminData['equipment']); ?>"
                                                required>
                                            <div class="suggestions" id="suggestions"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="hm_awal" class="sub-judul mb-2">Tipe Unit :</label>
                                            <input type="text" class="form-control text-white" id="tipe_unit"
                                                name="tipe_unit"
                                                value="<?php echo htmlspecialchars($adminData['tipe_unit']); ?>"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="hm_awal" class="sub-judul mb-2"><span
                                                    class="wajib_isi">*</span>Hour
                                                Meter Awal
                                                :</label>
                                            <input type="number" class="form-control text-white" id="hm_awal"
                                                name="hm_awal"
                                                value="<?php echo htmlspecialchars($adminData['hm_awal']); ?>"
                                                oninput="calculateTotalHM()" required step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="hm_akhir" class="sub-judul mb-2"><span
                                                    class="wajib_isi">*</span>
                                                Hour Meter Akhir
                                                :</label>
                                            <input type="number" class="form-control text-white" id="hm_akhir"
                                                name="hm_akhir"
                                                value="<?php echo htmlspecialchars($adminData['hm_akhir']); ?>"
                                                oninput="calculateTotalHM()" required step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="total_hm" class="sub-judul mb-2">Total HM :</label>
                                            <input type="number" class="form-control text-white" id="total_hm"
                                                name="total_hm"
                                                value="<?php echo htmlspecialchars($adminData['total_hm']); ?>"
                                                oninput="calculateTotalHM()" readonly>
                                            <div id="error-message" class="text-danger notif" style="display: none;">
                                                Total HM tidak boleh minus (-)</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="jam_lain" class="sub-judul mb-2"><span
                                                    class="wajib_isi">*</span>
                                                Jam Lain :</label>
                                            <input type="number" class="form-control text-white" id="jam_lain"
                                                name="jam_lain"
                                                value="<?php echo htmlspecialchars($adminData['jam_lain']); ?>"
                                                oninput="calculateJamOperasi()" required step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="jam_lain" class="sub-judul mb-2">Jam Operasi :</label>
                                            <input type="number" class="form-control text-white" id="jam_operasi"
                                                name="jam_operasi"
                                                value="<?php echo htmlspecialchars($adminData['jam_operasi']); ?>"
                                                oninput="calculateJamOperasi()" readonly>
                                            <div id="jam-operasi-error" class="text-danger" style="display: none;">
                                                Jam Operasi tidak boleh minus (-)</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="breakdown" class="sub-judul mb-2"><span
                                                    class="wajib_isi">*</span>
                                                Breakdown :</label>
                                            <input type="number" class="form-control text-white" id="breakdown"
                                                name="breakdown"
                                                value="<?php echo htmlspecialchars($adminData['breakdown']); ?>"
                                                oninput="calculateNoOrder()" required step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="no_operator" class="sub-judul mb-2"><span
                                                    class="wajib_isi">*</span>
                                                No Operator :</label>
                                            <input type="number" class="form-control text-white" id="no_operator"
                                                name="no_operator"
                                                value="<?php echo htmlspecialchars($adminData['no_operator']); ?>"
                                                oninput="calculateNoOrder()" required step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="hujan" class="sub-judul mb-2"><span class="wajib_isi">*</span>
                                                Hujan :</label>
                                            <input type="number" class="form-control text-white" id="hujan" name="hujan"
                                                value="<?php echo htmlspecialchars($adminData['hujan']); ?>"
                                                oninput="calculateNoOrder()" required step="0.01">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="hujan" class="sub-judul mb-2">No Order :</label>
                                    <input type="number" class="form-control text-white" id="no_order" name="no_order"
                                        value="<?php echo htmlspecialchars($adminData['no_order']); ?>"" oninput="
                                        calculateNoOrder()" readonly>
                                    <div id="no-order-error" class="text-danger" style="display: none;">
                                        No order tidak boleh minus (-)</div>
                                </div>
                                <div class="mb-3">
                                    <label for="ket" class="sub-judul mb-2"><span class="wajib_isi">*</span>
                                        Keterangan
                                        :</label>
                                    <input type="text" class="form-control text-white" id="ket" name="ket"
                                        value="<?php echo htmlspecialchars($adminData['ket']); ?>" required>
                                </div>
                                <input type="hidden" id="id" name="id"
                                    value="<?php echo htmlspecialchars($adminData['id']); ?>">
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
                                <button type="submit" class="btn btn-primary me-2">Edit</button>
                                <button type="button" class="btn btn-danger" onclick="goBack()">Kembali</button>
                            </form>
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
        window.location.href = 'Preview_hm.php?id=' +
            operationReportId; // Redirect to Preview.php with operation_report_id
    }

    const equipmentData = <?php echo json_encode($equipmentData); ?>;

    const equipmentInput = document.getElementById('equipment');
    const suggestionsDiv = document.getElementById('suggestions');
    const tipeUnitInput = document.getElementById('tipe_unit');

    equipmentInput.addEventListener('input', function() {
        const inputValue = this.value.toLowerCase();
        suggestionsDiv.innerHTML = '';
        suggestionsDiv.style.display = 'none';

        if (inputValue) {
            const filteredData = equipmentData.filter(e => e.equipment.toLowerCase().includes(inputValue));
            if (filteredData.length > 0) {
                filteredData.forEach(item => {
                    const suggestionItem = document.createElement('div');
                    suggestionItem.textContent = item.equipment;
                    suggestionItem.addEventListener('click', function() {
                        equipmentInput.value = item.equipment;
                        tipeUnitInput.value = item.tipe_unit;
                        suggestionsDiv.style.display = 'none';
                    });
                    suggestionsDiv.appendChild(suggestionItem);
                });
                suggestionsDiv.style.display = 'block';
            }
        }
    });

    document.addEventListener('click', function(event) {
        if (!equipmentInput.contains(event.target)) {
            suggestionsDiv.style.display = 'none';
        }
    });

    document.getElementById('hm_awal').addEventListener('input', calculateTotalHM);
    document.getElementById('hm_akhir').addEventListener('input', calculateTotalHM);
    document.getElementById('jam_lain').addEventListener('input', calculateJamOperasi);
    document.getElementById('breakdown').addEventListener('input', calculateNoOrder);
    document.getElementById('no_operator').addEventListener('input', calculateNoOrder);
    document.getElementById('hujan').addEventListener('input', calculateNoOrder);

    function calculateTotalHM() {
        const hmAwal = parseFloat(document.getElementById('hm_awal').value) || 0;
        const hmAkhir = parseFloat(document.getElementById('hm_akhir').value) || 0;
        const totalHM = (hmAkhir - hmAwal).toFixed(2);

        document.getElementById('total_hm').value = totalHM;

        // Check if total HM is negative
        const errorMessage = document.getElementById('error-message');
        if (totalHM < 0) {
            errorMessage.style.display = 'block'; // Show error message
        } else {
            errorMessage.style.display = 'none'; // Hide error message
        }

        // Recalculate Jam Operasi whenever Total HM changes
        calculateJamOperasi();
        calculateNoOrder();
    }

    function calculateJamOperasi() {
        const totalHM = parseFloat(document.getElementById('total_hm').value) || 0;
        const jamLain = parseFloat(document.getElementById('jam_lain').value) || 0;
        const jamOperasi = (totalHM - jamLain).toFixed(2);

        document.getElementById('jam_operasi').value = jamOperasi;

        // Check if Jam Operasi is negative
        const jamOperasiError = document.getElementById('jam-operasi-error');
        if (jamOperasi < 0) {
            jamOperasiError.style.display = 'block'; // Show error message
        } else {
            jamOperasiError.style.display = 'none'; // Hide error message
        }

        calculateNoOrder();
    }

    function calculateNoOrder() {
        const jamOperasi = parseFloat(document.getElementById('jam_operasi').value) || 0;
        const breakdown = parseFloat(document.getElementById('breakdown').value) || 0;
        const noOperator = parseFloat(document.getElementById('no_operator').value) || 0;
        const hujan = parseFloat(document.getElementById('hujan').value) || 0;
        const noOrder = (8 - jamOperasi - breakdown - noOperator - hujan).toFixed(2);

        document.getElementById('no_order').value = noOrder;

        // Check if Jam Operasi is negative
        const noOrderError = document.getElementById('no-order-error');
        if (noOrder < 0) {
            noOrderError.style.display = 'block'; // Show error message
        } else {
            noOrderError.style.display = 'none'; // Hide error message
        }

    }
    </script>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>