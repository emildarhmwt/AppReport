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

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM production_report WHERE id = $1";
    pg_query_params($conn, $delete_sql, array($delete_id));
    header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $id); // Redirect to the same page
    exit();
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

    .btn-custom2 {
        background-color: #ede0a0 !important;
        color: black !important;
        cursor: pointer;
    }

    .btn-custom2:hover {
        background-color: #bdb57b !important;
        color: white !important;
    }

    .timeline {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        margin-top: 20px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #ccc;
        z-index: 1;
    }

    .timeline-item {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .timeline-dot {
        width: 10px;
        height: 10px;
        background-color: #00bfff;
        border-radius: 50%;
        margin: 0 auto;
    }

    .timeline-item p {
        margin: 0;
        font-size: 14px;
        color: black;
    }

    .bg-blue {
        background-color: #0e4551;
        ;
    }

    .bg-gray {
        background-color: #ccc;
    }

    /* .card-preview {
        background-color: #0e45515c !important;
        color: white !important;
    } */

    .btn-custom-review {
        background-color: #11475e !important;
        color: white !important;
    }

    .btn-custom-review:hover {
        background-color: #609fb2 !important;
        color: white !important;
    }

    .btn-custom-back {
        background-color: #7c1919 !important;
        color: white !important;
    }

    .btn-custom-back:hover {
        background-color: #b27373 !important;
        color: white !important;
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
                            <div class=" card-header" style="background-color: black; width: 100%; color:white;">
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
                                            <label for="shift" class="form-label">Hari / Tanggal :</label>
                                            <p>
                                                <td><?php echo date('d M Y', strtotime($operation_report['tanggal'])); ?>
                                                </td>
                                            </p>
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <label for="shift" class="form-label">Shift :</label>
                                            <p>
                                                <td><?php echo $operation_report['shift']; ?></td>
                                            </p>
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <label for="shift" class="form-label">Giliran / Group :</label>
                                            <p>
                                                <td><?php echo $operation_report['grup']; ?></td>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 mb-3">
                                            <label for="shift" class="form-label">Pengawas :</label>
                                            <p>
                                                <td><?php echo $operation_report['pengawas']; ?></td>
                                            </p>
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <label for="shift" class="form-label">Lokasi Kerja :</label>
                                            <p>
                                                <td><?php echo $operation_report['lokasi']; ?></td>
                                            </p>
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <label for="shift" class="form-label">Status :</label>
                                            <p>
                                                <td><?php echo $operation_report['status']; ?></td>
                                            </p>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 mb-3">
                                                <label for="shift" class="form-label">PIC :</label>
                                                <p>
                                                    <td><?php echo $operation_report['pic']; ?></td>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- </div> -->
                        <div class="row text-center justify-content-center align-items-center mt-4">
                            <div class="col-lg-12">
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <div class="timeline-dot">
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-dot">
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-dot">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-center">
                                        <p>Uploaded</p>
                                    </div>
                                    <div class="text-center">
                                        <p>Approve (Pengawas)</p>
                                    </div>
                                    <div class="text-center">
                                        <p>Done </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4 mt-4">
                            <div class="col-md-12 d-flex justify-content-end align-items-center">
                                <a target="_blank"
                                    class="btn btn-custom-review btn-sm d-flex justify-content-end align-items-center  me-2"
                                    href="./export_pdf.php?id=<?php echo $id; ?>">
                                    <i class="ti ti-eye fs-7 mx-1"></i> Review Dokumen
                                </a>
                                <a target="_blank"
                                    class="btn btn-custom-review btn-sm d-flex justify-content-end align-items-center"
                                    href="./export_pdf.php?id=<?php echo $id; ?>" download>
                                    <i class="bi bi-filetype-pdf fs-4 mx-1"></i> Export PDF
                                </a>
                                <a class="btn btn-custom-back btn-sm d-flex justify-content-end align-items-center mx-2"
                                    href="Report.php">
                                    <i class="ti ti-arrow-narrow-left fs-7 mx-1"></i></i> Kembali
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive products-table" data-simplebar>
                            <table class="table table-bordered text-nowrap mb-0 align-middle table-hover">
                                <thead class="fs-4">
                                    <tr class="text-center">
                                        <!-- <th class="fs-3" style="width: 5%;"></th> -->
                                        <th class="fs-3" style="width: 3%;">No</th>
                                        <th class="fs-3">Executor</th>
                                        <th class="fs-3">Alat Gali / Muat</th>
                                        <th class="fs-3">Timbunan</th>
                                        <th class="fs-3">Material Tanah</th>
                                        <th class="fs-3">Jarak Angkut</th>
                                        <th class="fs-3">Tipe Hauler </th>
                                        <th class="fs-3">Ritase </th>
                                        <th class="fs-3">Tipe Hauler 2</th>
                                        <th class="fs-3">Ritase 2</th>
                                        <th class="fs-3">Muatan</th>
                                        <th class="fs-3">Volume</th>
                                        <th class="fs-3">Proses</th>
                                        <th class="fs-3" style="width: 5%;">Opsi</th>
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
                                        <td><?php echo htmlspecialchars($report['jarak']); ?></td>
                                        <td><?php echo htmlspecialchars($report['tipe']); ?></td>
                                        <td><?php echo htmlspecialchars($report['ritase']); ?></td>
                                        <td><?php echo !empty($report['tipe2']) ? htmlspecialchars($report['tipe2']) : '-'; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($report['ritase2']); ?></td>
                                        <td><?php echo htmlspecialchars($report['muatan']); ?></td>
                                        <td><?php echo htmlspecialchars($report['volume']); ?></td>
                                        <td>
                                            <?php
                                                    if (isset($report['proses_kontraktor']) && !empty($report['proses_kontraktor'])) {
                                                        echo $report['proses_kontraktor'];
                                                    } elseif (isset($report['proses_pengawas']) && !empty($report['proses_pengawas'])) {
                                                        echo $report['proses_pengawas'];
                                                    } elseif (isset($report['proses_admin']) && !empty($report['proses_admin'])) {
                                                        echo $report['proses_admin'];
                                                    } else {
                                                        echo 'No data available';
                                                    }
                                                    ?>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm" title="Hapus"
                                                onclick="if(confirm('Are you sure you want to delete this report?')) { window.location.href='?id=<?php echo $id; ?>&delete_id=<?php echo $report['id']; ?>'; }">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                            <?php if (isset($report['proses_pengawas']) && $report['proses_pengawas'] === 'Rejected Pengawas'): ?>
                                            <button class="btn btn-primary btn-sm" title="Edit">
                                                <i class="bi bi-pen"></i>
                                            </button>
                                            <?php endif; ?>
                                        </td>
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
    </script>
    <script src=" ../assets/libs/jquery/dist/jquery.min.js">
    </script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>