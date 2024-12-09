<?php
include '../Koneksi.php';
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    $sql = "SELECT * FROM operation_report WHERE id = $1";
    $result = pg_query_params($conn, $sql, array($id));

    if ($result) {
        $operation_report = pg_fetch_assoc($result);
    } else {
        $operation_report = [];
    }

    $sql_production = "SELECT * FROM production_report WHERE operation_report_id = $1";
    $result_production = pg_query_params($conn, $sql_production, array($id));

    if ($result_production) {
        $production_reports = pg_fetch_all($result_production);
    } else {
        $production_reports = [];
    }
} else {
    die("Operation report ID not provided.");
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report Application</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css">
    <link rel=" stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Pacifico&family=Playwrite+DE+Grund:wght@100..400&family=Rowdies:wght@300;400;700&family=Varela+Round&display=swap"
        rel="stylesheet">
    <style>
    .body-wrapper {
        background-image: url(../assets/images/backgrounds/4.png);
        background-size: cover;
        background-repeat: no-repeat;
    }

    .pacifico-regular {
        font-family: "Pacifico", cursive;
        font-weight: 400;
        font-style: normal;
    }

    .varela-round-regular {
        font-family: "Varela Round", sans-serif;
        font-weight: 400;
        font-style: normal;
    }

    .playwrite-de-grund {
        font-family: "Playwrite DE Grund", cursive;
        font-optical-sizing: auto;
        font-style: normal;
        font-weight: 400;
    }

    .card-preview {
        background-color: #5ea1b5 !important;
    }

    .sub-judul {
        font-family: "Varela Round", serif;
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
                <div class="card">
                    <div class="card-body">
                        <!-- <div class="row"> -->
                        <div class="card card-preview" style="border-radius: 10px 10px 10px 10px;">
                            <div class=" card-header" style="background-color: #092c43; width: 100%; color:white;">
                                Header
                            </div>
                            <?php
                            include '../Koneksi.php';
                            $id = $_GET['id'];
                            $sql = "SELECT * FROM operation_report WHERE id = $1";
                            $result = pg_query_params($conn, $sql, array($id));
                            if ($result) {
                                $operation_report = pg_fetch_assoc($result);
                            } else {
                                $operation_report = [];
                            }
                            ?>
                            <div class="card-body">
                                <form method="get" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-lg-4 mb-3">
                                            <label for="shift" class="sub-judul">Hari / Tanggal :</label>
                                            <p class="sub-judul mt-2">
                                                <td><?php echo date('d M Y', strtotime($operation_report['tanggal'])); ?>
                                                </td>
                                            </p>
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <label for="shift" class="sub-judul">Shift :</label>
                                            <p class="sub-judul mt-2">
                                                <td><?php echo $operation_report['shift']; ?></td>
                                            </p>
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <label for="shift" class="sub-judul">Giliran / Group :</label>
                                            <p class="sub-judul mt-2">
                                                <td><?php echo $operation_report['grup']; ?></td>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 mb-3">
                                            <label for="shift" class="sub-judul">Pengawas :</label>
                                            <p class="sub-judul mt-2">
                                                <td><?php echo $operation_report['pengawas']; ?></td>
                                            </p>
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <label for="shift" class="sub-judul">Lokasi Kerja :</label>
                                            <p class="sub-judul mt-2">
                                                <td><?php echo $operation_report['lokasi']; ?></td>
                                            </p>
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <label for="shift" class="sub-judul">Status :</label>
                                            <p class="sub-judul mt-2">
                                                <td><?php echo $operation_report['status']; ?></td>
                                            </p>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 mb-3">
                                                <label for="shift" class="sub-judul">PIC :</label>
                                                <p class="sub-judul mt-2">
                                                    <td><?php echo $operation_report['pic']; ?></td>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row mb-4 mt-4">
                            <div class="col-md-12 d-flex justify-content-between align-items-center">
                                <div class="d-flex justify-content-start align-items-center">
                                    <a target="_blank"
                                        class="btn btn-primary d-flex justify-content-start align-items-center me-2"
                                        href="#" onclick="return false;">
                                        Proses :
                                        <?php
                                    $processDisplay = ''; // Variable to hold the process display string
                                    $rejectedPengawasReasons = []; // Array to hold reasons for Rejected (Pengawas)

                                    foreach ($production_reports as $index => $report) {
                                        // Collect reasons for Rejected (Pengawas)
                                        if (isset($report['proses_pengawas']) && $report['proses_pengawas'] === 'Rejected Pengawas') {
                                            $rejectedPengawasReasons[] = htmlspecialchars($report['alasan_reject']);
                                        }
                                        // Check conditions based on the provided rules
                                        if (
                                            !empty($report['proses_kontraktor']) && $report['proses_kontraktor'] === 'Approved Kontraktor' &&
                                            !empty($report['proses_pengawas']) && $report['proses_pengawas'] === 'Approved Pengawas' &&
                                            !empty($report['proses_admin']) && $report['proses_admin'] === 'Uploaded'
                                        ) {
                                            $processDisplay = 'Approved Kontraktor';
                                            break; // Exit loop once the condition is met
                                        }
                                        if (
                                            !empty($report['proses_kontraktor']) && $report['proses_kontraktor'] === 'Rejected Kontraktor' &&
                                            !empty($report['proses_pengawas']) && $report['proses_pengawas'] === 'Approved Pengawas' &&
                                            !empty($report['proses_admin']) && $report['proses_admin'] === 'Uploaded'
                                        ) {
                                            $processDisplay = 'Rejected Kontraktor';
                                            if (!empty($rejectedPengawasReasons)) {
                                                $processDisplay .= ' (' . implode(', ', array_unique($rejectedPengawasReasons)) . ')';
                                            }
                                            if (!empty($report['alasan_reject'])) {
                                                $processDisplay .= ' ( ' . htmlspecialchars($report['alasan_reject'] . ' ) ');
                                            }
                                            break; // Exit loop once the condition is met
                                        }
                                        if (
                                            empty($report['proses_kontraktor']) &&
                                            !empty($report['proses_pengawas']) && $report['proses_pengawas'] === 'Approved Pengawas' &&
                                            !empty($report['proses_admin']) && $report['proses_admin'] === 'Uploaded'
                                        ) {
                                            $processDisplay = 'Approved Pengawas';
                                            break; // Exit loop once the condition is met
                                        }
                                         if (
                                            empty($report['proses_kontraktor']) &&
                                            !empty($report['proses_pengawas']) && $report['proses_pengawas'] === 'Pending' &&
                                            !empty($report['proses_admin']) && $report['proses_admin'] === 'Uploaded'
                                        ) {
                                            $processDisplay = 'Pending';
                                            break; // Exit loop once the condition is met
                                        }
                                        if (
                                            empty($report['proses_kontraktor']) &&
                                            !empty($report['proses_pengawas']) && $report['proses_pengawas'] === 'Rejected Pengawas' &&
                                            !empty($report['proses_admin']) && $report['proses_admin'] === 'Uploaded'
                                        ) {
                                            $processDisplay = 'Rejected Pengawas';
                                            if (!empty($rejectedPengawasReasons)) {
                                                $processDisplay .= ' (' . implode(', ', array_unique($rejectedPengawasReasons)) . ')';
                                            }
                                            break; // Exit loop once the condition is met
                                        }
                                        if (
                                            empty($report['proses_kontraktor']) &&
                                            empty($report['proses_pengawas']) &&
                                            !empty($report['proses_admin']) && $report['proses_admin'] === 'Uploaded'
                                        ) {
                                            $processDisplay = 'Uploaded';
                                            break; // Exit loop once the condition is met
                                        }
                                    }
                                    // Display the process status
                                    echo $processDisplay ? $processDisplay : 'No data available';
                                    ?>
                                    </a>

                                    <?php if (isset($report['proses_kontraktor']) && $report['proses_kontraktor'] === 'Rejected Kontraktor'): ?>
                                    <form method="post" action="ProduksiApprove.php" style="display:inline;">
                                        <input type="hidden" name="operation_report_id"
                                            value="<?php echo $report['operation_report_id']; ?>">
                                        <input type="hidden" name="proses_kontraktor"
                                            value="<?php echo $report['proses_kontraktor']; ?>">
                                        <input type="hidden" name="alasan_reject"
                                            value="<?php echo $report['alasan_reject']; ?>">
                                        <button
                                            class="btn btn-primary d-flex justify-content-start align-items-center me-2"
                                            title="Approve"> Approve
                                        </button>
                                    </form>

                                    <button class="btn btn-danger d-flex justify-content-start align-items-center me-2"
                                        title="Reject" onclick="showRejectProduksiModal(<?php echo $id; ?>)"> Reject
                                    </button>

                                    <div id="rejectProduksiModal" class="modal" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Alasan Reject</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" id="operationReportProduksiId"
                                                        value="<?php echo $report['operation_report_id']; ?>">
                                                    <input type="hidden" id="prosesPengawas"
                                                        value="<?php echo $report['proses_pengawas']; ?>">
                                                    <input type="hidden" id="prosesKontraktor"
                                                        value="<?php echo $report['proses_kontraktor']; ?>">
                                                    <input type="hidden" id="kontraktor"
                                                        value="<?php echo $report['kontraktor']; ?>">
                                                    <input type="hidden" id="namePengawas"
                                                        value="<?php echo $report['name_pengawas']; ?>">
                                                    <input type="hidden" id="filePengawas"
                                                        value="<?php echo $report['file_pengawas']; ?>">
                                                    <div class="mb-3">
                                                        <label for="alasanReject" class="form-label">Alasan:</label>
                                                        <textarea class="form-control" id="alasanRejectProduksi"
                                                            rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="submitRejectProduksi()">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>

                                <div class="d-flex justify-content-end align-items-center">
                                    <a target="_blank"
                                        class="btn btn-warning d-flex justify-content-end align-items-center me-2"
                                        href="./export_pdf.php?id=<?php echo $id; ?>&action=review"> Review Dokumen
                                    </a>
                                    <a target="_blank"
                                        class="btn btn-warning d-flex justify-content-end align-items-center me-2"
                                        href="./export_pdf.php?id=<?php echo $id; ?>&action=download"> Export PDF
                                    </a>
                                    <a class="btn btn-danger d-flex justify-content-end align-items-center"
                                        href="Report.php"> Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive products-table" data-simplebar>
                            <table class="table table-bordered text-nowrap mb-0 align-middle table-hover">
                                <thead class="fs-4">
                                    <tr class="text-center justify-content-center" style="vertical-align: middle;">
                                        <!-- <th class="fs-3" style="width: 5%;"></th> -->
                                        <th class="fs-3" style="width: 1%;">No</th>
                                        <th class="fs-3" style="width: 15%;">Executor</th>
                                        <th class="fs-3" style="width: 15%;">Alat Gali / Muat</th>
                                        <th class="fs-3" style="width: 15%;">Timbunan</th>
                                        <th class="fs-3" style="width: 5%;">Material <br> Tanah</th>
                                        <th class="fs-3" style="width: 5%;">Jarak <br> Angkut</th>
                                        <th class="fs-3" style="width: 15%;">Tipe <br> Hauler </th>
                                        <th class="fs-3" style="width: 5%;">Ritase </th>
                                        <th class="fs-3" style="width: 15%;">Tipe <br> Hauler 2</th>
                                        <th class="fs-3" style="width: 5%;">Ritase 2</th>
                                        <th class="fs-3" style="width: 5%;">Total <br> Ritase</th>
                                        <th class="fs-3" style="width: 5%;">Volume</th>
                                        <!-- <th class="fs-3"> </th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($production_reports)): ?>
                                    <?php foreach ($production_reports as $index => $report): ?>
                                    <tr>
                                        <td class="text-center"><?php echo $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars($report['excecutor']); ?></td>
                                        <td><?php echo htmlspecialchars($report['alat']); ?></td>
                                        <td><?php echo htmlspecialchars($report['timbunan']); ?></td>
                                        <td><?php echo htmlspecialchars($report['material']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($report['jarak']); ?></td>
                                        <td><?php echo htmlspecialchars($report['tipe']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($report['ritase']); ?></td>
                                        <td><?php echo htmlspecialchars($report['tipe2']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($report['ritase2']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($report['total_ritase']); ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo number_format(htmlspecialchars($report['volume']), 2); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No production reports found.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-primary me-2" title="Approve"
                                onclick="showApproveModal(<?php echo $id; ?>)">Approve
                            </button>

                            <div id="approveModal" class="modal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Lengkapi data berikut</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" id="barcodeReportId">
                                            <div class="mb-3">
                                                <label for="approveProduction" class="form-label">Ditujukan kepada
                                                    :</label>
                                                <select class="form-select" aria-label="Default select example"
                                                    id="kontraktor" name="kontraktor" required>
                                                    <option value="" selected disabled>Kontraktor</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="approveProduction" class="form-label">Nama Pengawas
                                                    :</label>
                                                <select class="form-select" aria-label="Default select example"
                                                    id="nama" name="nama" required>
                                                    <option value="" selected disabled>Pengawas</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="approveProduction" class="form-label">Jabatan Pengawas
                                                    :</label>
                                                <input type="text" class="form-control" id="jabatan" name="jabatan"
                                                    placeholder="Jabatan" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="approveProduction" class="form-label">NIP Pengawas :</label>
                                                <input type="text" class="form-control" id="nip" name="nip"
                                                    placeholder="NIP" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="approveProduction" class="form-label">TTD Pengawas :</label>
                                                <img id="file_pengawas" name="file_pengawas" src="" alt="TTD"
                                                    style="max-width: 200px; display: none;">
                                            </div>
                                            <input type="hidden" class="form-control" id="name_pengawas"
                                                name="name_pengawas" placeholder="NIP" readonly>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Kembali</button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="submitApprove()">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-danger" title="Reject"
                                onclick="showRejectModal(<?php echo $id; ?>)">Reject
                            </button>

                            <div id="rejectModal" class="modal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Alasan Reject</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" id="operationReportId">
                                            <div class="mb-3">
                                                <label for="alasanReject" class="form-label">Alasan:</label>
                                                <textarea class="form-control" id="alasanReject" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="submitReject()">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <nav aria-label="Page navdivtion">
                            <ul class="pagination justify-content-center mt-3" id="paginationContainer">
                                <!-- Pagination items will be added here by JavaScript -->
                            </ul>
                        </nav>
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

    function showApproveModal(barcodeReportId) {
        document.getElementById('barcodeReportId').value = barcodeReportId;
        new bootstrap.Modal(document.getElementById('approveModal')).show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        fetch('fetch_pengawas_data.php')
            .then(response => response.json())
            .then(data => {
                const kontraktorSelect = document.getElementById('kontraktor');
                const namaSelect = document.getElementById('nama');

                // Populate kontraktor options
                data.kontraktor.forEach(kontraktor => {
                    const option = document.createElement('option');
                    option.value = kontraktor.username;
                    option.textContent = kontraktor.username;
                    kontraktorSelect.appendChild(option);
                });

                // Populate nama options
                data.pengawas.forEach(pengawas => {
                    const option = document.createElement('option');
                    option.value = pengawas.nama;
                    option.textContent = pengawas.nama;
                    namaSelect.appendChild(option);
                });

                // Handle nama change
                namaSelect.addEventListener('change', function() {
                    const selectedPengawas = data.pengawas.find(p => p.nama === this.value);
                    if (selectedPengawas) {
                        document.getElementById('jabatan').value = selectedPengawas.jabatan;
                        document.getElementById('nip').value = selectedPengawas.nip;
                        document.getElementById('name_pengawas').src = selectedPengawas.name;
                        document.getElementById('file_pengawas').src = selectedPengawas.file_path;
                        document.getElementById('file_pengawas').style.display = 'block';
                    }
                });
            });
    });

    function submitApprove() {
        const operationReportId = document.getElementById('barcodeReportId').value;
        const kontraktor = document.getElementById('kontraktor').value;
        const name_pengawas = document.getElementById('name_pengawas').src;
        const file_pengawas = document.getElementById('file_pengawas').src;

        fetch('Approve.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'operation_report_id': operationReportId,
                    'kontraktor': kontraktor,
                    'name_pengawas': name_pengawas,
                    'file_pengawas': file_pengawas
                })
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload(); // Reload the page to see the changes
            })
            .catch(error => console.error('Error:', error));
    }

    function showRejectModal(operationReportId) {
        document.getElementById('operationReportId').value = operationReportId;
        new bootstrap.Modal(document.getElementById('rejectModal')).show();
    }

    function submitReject() {
        const operationReportId = document.getElementById('operationReportId').value;
        const alasanReject = document.getElementById('alasanReject').value;

        fetch('reject.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'operation_report_id': operationReportId,
                    'alasan_reject': alasanReject
                })
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload(); // Reload the page to see the changes
            })
            .catch(error => console.error('Error:', error));
    }

    function showRejectProduksiModal(operationReportProduksiId) {
        document.getElementById('operationReportProduksiId').value = operationReportProduksiId;
        new bootstrap.Modal(document.getElementById('rejectProduksiModal')).show();
    }

    function submitRejectProduksi() {
        const operationReportProduksiId = document.getElementById('operationReportProduksiId').value;
        const alasanReject = document.getElementById('alasanRejectProduksi').value;

        fetch('ProduksiRejected.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'operation_report_id': operationReportProduksiId,
                    'alasan_reject': alasanReject,
                    'proses_pengawas': prosesPengawas,
                    'proses_kontraktor': prosesKontraktor,
                    'kontraktor': kontraktor,
                    'name_pengawas': namePengawas,
                    'file_pengawas': filePengawas
                })
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload(); // Reload the page to see the changes
            })
            .catch(error => console.error('Error:', error));
    }
    </script>
    <script src=" ../assets/libs/jquery/dist/jquery.min.js">
    </script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>