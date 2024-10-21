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
                                    href=" #">
                                    <i class="ti ti-eye fs-7 mx-1"></i> Review Dokumen
                                </a>
                                <a target="_blank"
                                    class="btn btn-custom-review btn-sm d-flex justify-content-end align-items-center"
                                    href=" #">
                                    <i class="bi bi-filetype-pdf fs-4 mx-1"></i> Export PDF
                                </a>
                                <a class="btn btn-custom-back btn-sm d-flex justify-content-end align-items-center mx-2"
                                    href="Report_hourmeter.php">
                                    <i class="ti ti-arrow-narrow-left fs-7 mx-1"></i></i> Kembali
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive products-table" data-simplebar>
                            <table class="table table-bordered text-nowrap mb-0 align-middle table-hover">
                                <thead class="fs-4">
                                    <tr class="text-center">
                                        <!-- <th class="fs-3" style="width: 5%;"></th> -->
                                        <th class="fs-3" style="width: 5%;">No</th>
                                        <th class="fs-3">Equipment</th>
                                        <th class="fs-3">HM Awal</th>
                                        <th class="fs-3">HM Akhir</th>
                                        <th class="fs-3">Jam Lain</th>
                                        <th class="fs-3">Breakdown</th>
                                        <th class="fs-3">No Operator</th>
                                        <th class="fs-3">Hujan</th>
                                        <th class="fs-3">Keterangan</th>
                                        <th class="fs-3">Proses</th>
                                        <!-- <th class="fs-3"> </th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($hourmeter_reports)): ?>
                                    <?php foreach ($hourmeter_reports as $index => $report): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars($report['equipment']); ?></td>
                                        <td><?php echo htmlspecialchars($report['hm_awal']); ?></td>
                                        <td><?php echo htmlspecialchars($report['hm_akhir']); ?></td>
                                        <td><?php echo htmlspecialchars($report['jam_lain']); ?></td>
                                        <td><?php echo htmlspecialchars($report['breakdown']); ?></td>
                                        <td><?php echo htmlspecialchars($report['no_operator']); ?></td>
                                        <td><?php echo htmlspecialchars($report['hujan']); ?></td>
                                        <td><?php echo htmlspecialchars($report['ket']); ?></td>
                                        <td></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No hourmeter reports found.</td>
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