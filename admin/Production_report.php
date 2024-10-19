<?php
include '../Koneksi.php';

$query = "SELECT * FROM production_report";
$result = pg_query($conn, $query);

if (!$result) {
    echo "Terjadi kesalahan saat mengambil data.";
    exit;
}

$data = pg_fetch_all($result);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report Application</title>
    <link rel="shortcut icon" type="image/png" href="./assets/images/logos/logo2.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
                        <h5 class="card-title fw-semibold mb-4">Production Report</h5>
                        <!-- Search-->
                        <div class="card mb-4">
                            <div class="card-body">
                                <form id="form-production" onSubmit="return handleSubmit(event)">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="startDate" class="form-label">Tanggal Mulai:</label>
                                            <input type="date" class="form-control" id="startDate"
                                                aria-describedby="startDateHelp">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="endDate" class="form-label">Tanggal Selesai:</label>
                                            <input type="date" class="form-control" id="endDate"
                                                aria-describedby="endDateHelp">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="grupSearch" class="form-label">Giliran / Group:</label>
                                        <input type="text" class="form-control" id="grupSearch"
                                            placeholder="Input Data">
                                    </div>
                                    <div class="mb-3">
                                        <label for="lokasiSearch" class="form-label">Lokasi Kerja:</label>
                                        <input type="text" class="form-control" id="lokasiSearch"
                                            placeholder="Input Data">
                                    </div>
                                    <div class="d-flex justify-content-center mt-3">
                                        <button type="submit" class="btn btn-primary mx-3"><i class="bi bi-search"></i>
                                            Search Data</button>
                                        <button type="button" class="btn btn-primary mx-3" onclick="fetchAllData()">All
                                            Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <!-- header info-->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-4">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="d-flex">
                                                <div class="col-4"><strong>Tanggal Awal</strong></div>
                                                <div class="col-2">:</div>
                                                <div class="col-6"><span id="tanggalAwal">-</span></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex">
                                                <div class="col-4"><strong>Tanggal Akhir</strong></div>
                                                <div class="col-2">:</div>
                                                <div class="col-6"><span id="tanggalAkhir">-</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <div class="d-flex">
                                                <div class="col-2"><strong>Giliran / Group</strong></div>
                                                <div class="col-1">:</div>
                                                <div class="col-9"><span id="grupInfo" class="text-break">-</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="d-flex">
                                                <div class="col-2"><strong>Lokasi Kerja</strong></div>
                                                <div class="col-1">:</div>
                                                <div class="col-9"><span id="lokasiInfo" class="text-break">-</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- table -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="rowsPerPageSelect" class="form-label">Tampilkan:</label>
                                        <select id="rowsPerPageSelect" class="form-select"
                                            style="width: auto; display: inline-block;">
                                            <option value="5">5</option>
                                            <option value="10" selected>10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                        </select>
                                        <span> data per halaman</span>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary mx-3"
                                            style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .80rem;"
                                            onclick="exportToPDF()"><i class="bi bi-download"></i> Export PDF</button>
                                        <button type="button" class="btn btn-primary"
                                            style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .80rem;"
                                            onclick="exportToExcel()"><i class="bi bi-download"></i> Export
                                            Excel</button>
                                    </div>
                                </div>
                                <div class="table-responsive products-table" data-simplebar>
                                    <table class="table table-bordered text-nowrap mb-0 align-middle table-hover">
                                        <thead class="fs-4">
                                            <tr>
                                                <th class="fs-3">No</th>
                                                <th class="fs-3">Alat Gali / Muat</th>
                                                <th class="fs-3">Timbunan</th>
                                                <th class="fs-3">Material Tanah</th>
                                                <th class="fs-3">Jarak Angkut </th>
                                                <th class="fs-3">Tipe Hauler</th>
                                                <th class="fs-3">Ritase</th>
                                                <th class="fs-3">Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productionTableBody">
                                        </tbody>
                                    </table>
                                </div>
                                <nav aria-label="Page navigation">
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

            document.addEventListener('DOMContentLoaded', () => {
                const data = <?php echo json_encode($data); ?>;
                const tbody = document.getElementById('productionTableBody');
                tbody.innerHTML = '';

                if (data.length === 0) {
                    tbody.innerHTML =
                        '<tr><td colspan="8" class="text-center">Tidak ada data yang ditemukan</td></tr>';
                } else {
                    data.forEach((report, index) => {
                        const row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${report.alat}</td>
                    <td>${report.timbunan}</td>
                    <td>${report.material}</td>
                    <td>${report.jarak}</td>
                    <td>${report.tipe}</td>
                    <td>${report.ritase}</td>
                    <td></td>
                </tr
            `;
                        tbody.innerHTML += row;
                    });
                }
            });
            </script>
            <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
            <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
            <script src="../assets/js/sidebarmenu.js"></script>
            <script src="../assets/js/app.min.js"></script>
            <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>