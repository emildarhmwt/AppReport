<?php
include '../Koneksi.php';

$query = "SELECT equipment, tipe_unit FROM equipment";
$result = pg_query($conn, $query);

$equipmentData = [];
while ($row = pg_fetch_assoc($result)) {
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
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
        color: #0f3f61;
    }

    .form-control::placeholder {
        color: #0f3f61;
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
                        <h5 class="judul fw-semibold">Form Jam Jalan</h5>
                        <form id="form-hourmeter" method="POST" action="hourmeter_aksi.php">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="equipment" class="sub-judul mb-2"><span class="wajib_isi">*</span>
                                            Equipment :</label>
                                        <input type="text" class="form-control text-white" id="equipment"
                                            name="equipment" placeholder="Type Equipment" required>
                                        <div class="suggestions" id="suggestions"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="hm_awal" class="sub-judul mb-2">Tipe Unit :</label>
                                        <input type="text" class="form-control text-white" id="tipe_unit"
                                            name="tipe_unit" placeholder="Tipe Unit" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="hm_awal" class="sub-judul mb-2"><span class="wajib_isi">*</span>Hour
                                            Meter Awal :</label>
                                        <input type="number" class="form-control text-white" id="hm_awal" name="hm_awal"
                                            placeholder="Input Data (gunakan titik untuk desimal)"
                                            oninput="calculateTotalHM()" required step="0.01">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="hm_akhir" class="sub-judul mb-2"><span class="wajib_isi">*</span>
                                            Hour Meter Akhir :</label>
                                        <input type="number" class="form-control text-white" id="hm_akhir"
                                            name="hm_akhir" placeholder="Input Data (gunakan titik untuk desimal)"
                                            oninput="calculateTotalHM()" required step="0.01">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="total_hm" class="sub-judul mb-2">Total HM :</label>
                                        <input type="number" class="form-control text-white" id="total_hm"
                                            name="total_hm" placeholder="Total HM" oninput="calculateTotalHM()"
                                            readonly>
                                        <div id="error-message" class="notif" style="display: none;">Total
                                            HM tidak boleh minus (-)</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="jam_lain" class="sub-judul mb-2"><span class="wajib_isi">*</span>
                                            Jam Lain :</label>
                                        <input type="number" class="form-control text-white" id="jam_lain"
                                            name="jam_lain" placeholder="Input Data (gunakan titik untuk desimal)"
                                            oninput="calculateJamOperasi()" required step="0.01">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="jam_lain" class="sub-judul mb-2">Jam Operasi :</label>
                                        <input type="number" class="form-control text-white" id="jam_operasi"
                                            name="jam_operasi" placeholder="Jam Operasi" oninput="calculateJamOperasi()"
                                            readonly>
                                        <div id="jam-operasi-error" class="notif" style="display: none;">
                                            Jam Operasi tidak boleh minus (-)</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="breakdown" class="sub-judul mb-2"><span class="wajib_isi">*</span>
                                            Breakdown :</label>
                                        <input type="number" class="form-control text-white" id="breakdown"
                                            name="breakdown" placeholder="Input Data (gunakan titik untuk desimal)"
                                            oninput="calculateNoOrder()" required step="0.01">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="no_operator" class="sub-judul mb-2"><span class="wajib_isi">*</span>
                                            No Operator :</label>
                                        <input type="number" class="form-control text-white" id="no_operator"
                                            name="no_operator" placeholder="Input Data (gunakan titik untuk desimal)"
                                            oninput="calculateNoOrder()" required step="0.01">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="hujan" class="sub-judul mb-2"><span class="wajib_isi">*</span>
                                            Hujan :</label>
                                        <input type="number" class="form-control text-white" id="hujan" name="hujan"
                                            placeholder="Input Data (gunakan titik untuk desimal)"
                                            oninput="calculateNoOrder()" required step="0.01">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="hujan" class="sub-judul mb-2">No Order :</label>
                                <input type="number" class="form-control text-white" id="no_order" name="no_order"
                                    placeholder="No Order" oninput="calculateNoOrder()" readonly>
                                <div id="no-order-error" class="notif" style="display: none;">
                                    No order tidak boleh minus (-)</div>
                            </div>
                            <div class="mb-3">
                                <label for="ket" class="sub-judul mb-2"><span class="wajib_isi">*</span> Keterangan
                                    :</label>
                                <input type="text" class="form-control text-white" id="ket" name="ket"
                                    placeholder="Input Data" required>
                            </div>
                            <input type="hidden" id="operation_report_id" name="operation_report_id"
                                value="<?php echo $_GET['id']; ?>">
                            <input type="hidden" id="proses_admin" name="proses_admin" value="Uploaded">
                            <input type="hidden" id="proses_pengawas" name="proses_pengawas" value="">
                            <input type="hidden" id="proses_kontraktor" name="proses_kontraktor" value="">
                            <input type="hidden" id="alasan_reject" name="alasan_reject" value="">
                            <button type="submit" class="btn btn-primary me-2"> Submit</button>
                            <button type="button" class="btn btn-danger" onclick="goBack()">Kembali</button>
                        </form>
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

    // $(document).ready(function() {
    //     $('#equipment').selectpicker(); // Initialize Bootstrap Select
    // });

    // Equipment dan tipe unit
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

    //Total HM
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

    // Navbar
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
    </script>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>