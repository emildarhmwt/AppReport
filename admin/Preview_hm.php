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

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM hourmeter_report WHERE id = $1";
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
                            <div class=" card-header" style="background-color: #092c43;; width: 100%; color:white;">
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
                                        <div class=" col-lg-4 mb-3">
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
                        <!-- </div> -->
                        <!-- <div class="row text-center justify-content-center align-items-center mt-4">
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
                        </div> -->

                        <div class="row mb-4 mt-4">
                            <div class="col-md-12 d-flex justify-content-between align-items-center">
                                <a target="_blank"
                                    class="btn btn-primary d-flex justify-content-start align-items-center me-2"
                                    href="./hourmeter_create.php?id=<?php echo $id; ?>">Tambah
                                </a>
                                <div class="d-flex justify-content-end">
                                    <a target="_blank"
                                        class="btn btn-warning d-flex justify-content-end align-items-center me-2"
                                        href="./export_hm.php?id=<?php echo $id; ?>&action=review">Review Dokumen
                                    </a>
                                    <a target="_blank"
                                        class="btn btn-warning d-flex justify-content-end align-items-center me-2"
                                        href="./export_hm.php?id=<?php echo $id; ?>&action=download">Export PDF
                                    </a>
                                    <a class="btn btn-danger d-flex justify-content-end align-items-center"
                                        href="Report_hourmeter.php">Kembali
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
                                        <th class="fs-3">Proses</th>
                                        <th class="fs-3">Opsi</th>
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
                                            <button class="btn btn-primary btn-sm" title="Edit"
                                                onclick="window.location.href='editHourmeter.php?id=<?php echo $report['id']; ?>';">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <form method="post" action="approve_hm.php" style="display:inline;">
                                                <input type="hidden" name="id" value="<?php echo $report['id']; ?>">
                                                <input type="hidden" name="operation_report_id"
                                                    value="<?php echo $report['operation_report_id']; ?>">
                                                <input type="hidden" name="proses_pengawas"
                                                    value="<?php echo $report['proses_pengawas']; ?>">
                                                <input type="hidden" name="proses_kontraktor"
                                                    value="<?php echo $report['proses_kontraktor']; ?>">
                                                <input type="hidden" name="alasan_reject"
                                                    value="<?php echo $report['alasan_reject']; ?>">
                                                <input type="hidden" name="kontraktor"
                                                    value="<?php echo $report['kontraktor']; ?>">
                                                <input type="hidden" name="name_pengawas"
                                                    value="<?php echo $report['name_pengawas']; ?>">
                                                <input type="hidden" name="file_pengawas"
                                                    value="<?php echo $report['file_pengawas']; ?>">
                                                <input type="hidden" name="name_kontraktor"
                                                    value="<?php echo $report['name_kontraktor']; ?>">
                                                <input type="hidden" name="file_kontraktor"
                                                    value="<?php echo $report['file_kontraktor']; ?>">
                                                <button type="submit" class="btn btn-warning btn-sm" title="Selesai">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                        </td>
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