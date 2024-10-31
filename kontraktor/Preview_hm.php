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

    $sql_hourmeter = "SELECT * FROM hourmeter_report WHERE operation_report_id = $1";
    $result_hourmeter = pg_query_params($conn, $sql_hourmeter, array($id));

    if ($result_hourmeter) {
        $hourmeter_reports = pg_fetch_all($result_hourmeter);
    } else {
        $hourmeter_reports = [];
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
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo3.png" />
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
        background-color: #b37219 !important;
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
                            <div class=" card-header" style="background-color: #b95b10; width: 100%; color:white;">
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

                                        foreach ($hourmeter_reports as $index => $report) {
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
                                </div>

                                <div class="d-flex justify-content-end align-items-center">
                                    <a target="_blank"
                                        class="btn btn-warning d-flex justify-content-end align-items-center me-2"
                                        href="./export_hm.php?id=<?php echo $id; ?>&action=review">
                                        Review Dokumen
                                    </a>
                                    <a target="_blank"
                                        class="btn btn-warning d-flex justify-content-end align-items-center me-2"
                                        href="./export_hm.php?id=<?php echo $id; ?>&action=download">
                                        Export PDF
                                    </a>
                                    <a class="btn btn-danger d-flex justify-content-end align-items-center"
                                        href="Report_hourmeter.php">
                                        Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive products-table" data-simplebar>
                            <table class="table table-bordered text-nowrap mb-0 align-middle table-hover">
                                <thead class="fs-4">
                                    <tr class="text-center" style="vertical-align: middle;">
                                        <!-- <th class="fs-3" style="width: 5%;"></th> -->
                                        <th class="fs-3" style="width: 5%;">No</th>
                                        <th class="fs-3">Equipment</th>
                                        <th class="fs-3">Tipe Unit</th>
                                        <th class="fs-3">HM <br> Awal</th>
                                        <th class="fs-3">HM <br> Akhir</th>
                                        <th class="fs-3">Total <br> HM</th>
                                        <th class="fs-3">Jam <br> Lain</th>
                                        <th class="fs-3">Jam <br> Operasi</th>
                                        <th class="fs-3">BD</th>
                                        <th class="fs-3">NO <br> OPRT</th>
                                        <th class="fs-3">Hujan</th>
                                        <th class="fs-3">No <br> Order</th>
                                        <th class="fs-3">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($hourmeter_reports)): ?>
                                    <?php foreach ($hourmeter_reports as $index => $report): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars($report['equipment']); ?></td>
                                        <td><?php echo htmlspecialchars($report['tipe_unit']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($report['hm_awal']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($report['hm_akhir']); ?>
                                        </td>
                                        <td class="text-center"><?php echo htmlspecialchars($report['total_hm']); ?>
                                        </td>
                                        <td class="text-center"><?php echo htmlspecialchars($report['jam_lain']); ?>
                                        </td>
                                        <td class="text-center"><?php echo htmlspecialchars($report['jam_operasi']); ?>
                                        </td>
                                        <td class="text-center"><?php echo htmlspecialchars($report['breakdown']); ?>
                                        </td>
                                        <td class="text-center"><?php echo htmlspecialchars($report['no_operator']); ?>
                                        </td>
                                        <td class="text-center"><?php echo htmlspecialchars($report['hujan']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($report['no_order']); ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($report['ket']); ?></td>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No hourmeter reports found.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-primary me-2" title="Approve"
                                onclick="showApproveModal(<?php echo $id; ?>)">
                                Approve
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
                                                <label for="approveProduction" class="form-label">Nama Kontraktor
                                                    :</label>
                                                <select class="form-select" aria-label="Default select example"
                                                    id="nama" name="nama" required>
                                                    <option value="" selected disabled>Kontraktor</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="approveProduction" class="form-label">Jabatan Kontraktor
                                                    :</label>
                                                <input type="text" class="form-control" id="jabatan" name="jabatan"
                                                    placeholder="Jabatan" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="approveProduction" class="form-label">NIP Kontraktor
                                                    :</label>
                                                <input type="text" class="form-control" id="nip" name="nip"
                                                    placeholder="NIP" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="approveProduction" class="form-label">TTD Kontraktor
                                                    :</label>
                                                <img id="file_kontraktor" name="file_kontraktor" src="" alt="TTD"
                                                    style="max-width: 200px; display: none;">
                                            </div>
                                            <input type="hidden" class="form-control" id="name_kontraktor"
                                                name="name_kontraktor" placeholder="NIP" readonly>
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

                            <button class="btn btn-danger" title="Reject" onclick="showRejectModal(<?php echo $id; ?>)">
                                Reject
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
                const namaSelect = document.getElementById('nama');

                // Populate nama options
                data.kontraktor.forEach(kontraktor => {
                    const option = document.createElement('option');
                    option.value = kontraktor.nama;
                    option.textContent = kontraktor.nama;
                    namaSelect.appendChild(option);
                });

                // Handle nama change
                namaSelect.addEventListener('change', function() {
                    const selectedKontraktor = data.kontraktor.find(p => p.nama === this.value);
                    if (selectedKontraktor) {
                        document.getElementById('jabatan').value = selectedKontraktor.jabatan;
                        document.getElementById('nip').value = selectedKontraktor.nip;
                        document.getElementById('name_kontraktor').src = selectedKontraktor.name;
                        document.getElementById('file_kontraktor').src =
                            selectedKontraktor.file_path;
                        document.getElementById('file_kontraktor').style.display = 'block';
                    }
                });
            });
    });

    function submitApprove() {
        const operationReportId = document.getElementById('barcodeReportId').value;
        const name_kontraktor = document.getElementById('name_kontraktor').src;
        const file_kontraktor = document.getElementById('file_kontraktor').src;

        fetch('Approve_hm.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'operation_report_id': operationReportId,
                    'name_kontraktor': name_kontraktor,
                    'file_kontraktor': file_kontraktor
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

        fetch('reject_hm.php', {
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
    </script>
    <script src=" ../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>