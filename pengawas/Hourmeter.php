<?php
include '../Koneksi.php';

$query = "SELECT * FROM hourmeter_report";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
    <style>
    #grup,
    #lokasi {
        word-wrap: break-word;
        word-break: break-all;
        white-space: normal;
    }
    </style>
</head>
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
                    <h5 class="card-title fw-semibold mb-4">Hour Meter Report</h5>
                    <!-- Search-->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form id="form-hourmeter" onSubmit="return handleSubmit(event)">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="startDate" class="form-label">Tanggal Awal :</label>
                                        <input type="date" class="form-control" id="startDate"
                                            aria-describedby="startDateHelp">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="endDate" class="form-label">Tanggal Akhir :</label>
                                        <input type="date" class="form-control" id="endDate"
                                            aria-describedby="endDateHelp">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="grupSearch" class="form-label">Giliran / Group :</label>
                                    <input type="text" class="form-control" id="grup" placeholder="Input Data">
                                </div>
                                <div class="mb-3">
                                    <label for="lokasiSearch" class="form-label">Lokasi Kerja :</label>
                                    <input type="text" class="form-control" id="lokasi" placeholder="Input Data">
                                </div>
                                <div class="mb-3">
                                    <label for="shiftSearch" class="form-label">Shift :</label>
                                    <input type="text" class="form-control" id="shift" placeholder="Input Data">
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    <button type="submit" class="btn btn-primary mx-3"><i class="bi bi-search"></i>
                                        Search Data</button>
                                    <button type="button" class="btn btn-primary mx-3" onclick="fetchAllData()">All
                                        Data</button>
                                    <!-- <button type="button" class="btn btn-primary mx-3"
                                            onclick="exportToExcel()">Export Excel</button>
                                        <button type="button" class="btn btn-primary mx-3"
                                            onclick="exportToPDF()">Export PDF</button> -->
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
                                            <div class="col-9"><span id="grupInfo" class="text-break">-</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <div class="d-flex">
                                            <div class="col-2"><strong>Lokasi Kerja</strong></div>
                                            <div class="col-1">:</div>
                                            <div class="col-9"><span id="lokasiInfo" class="text-break">-</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex">
                                            <div class="col-2"><strong>Shift</strong></div>
                                            <div class="col-1">:</div>
                                            <div class="col-9"><span id="shiftInfo" class="text-break">-</span>
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
                                        style="width: auto; display: inline-block;" onchange="updateRowsPerPage()">
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
                                </div>
                            </div>

                            <div class="table-responsive products-table" data-simplebar>
                                <table class="table table-bordered text-nowrap mb-0 align-middle table-hover">
                                    <thead class="fs-4">
                                        <tr>
                                            <th class="fs-3">No</th>
                                            <th class="fs-3">Equipment</th>
                                            <th class="fs-3">HM Awal</th>
                                            <th class="fs-3">HM Akhir</th>
                                            <th class="fs-3">Jam Lain</th>
                                            <th class="fs-3">Breakdown</th>
                                            <th class="fs-3">No Operator</th>
                                            <th class="fs-3">Hujan</th>
                                            <th class="fs-3">Keterangan</th>
                                            <th class="fs-3">Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="hourmeterTableBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center" id="pagination">
                                <!-- Pagination items will be dynamically added here -->
                            </ul>
                        </nav>
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

let rowsPerPage = 10; // Set the default number of rows per page
let currentPage = 1;
let allData = [];

function updateRowsPerPage() {
    const select = document.getElementById('rowsPerPageSelect');
    rowsPerPage = parseInt(select.value);
    currentPage = 1; // Reset to the first page
    renderTable(allData); // Render the table with the updated rows per page
}

function handleSubmit(event) {
    event.preventDefault(); // Prevent form submission
    const grup = document.getElementById('grup').value;

    const filteredData = allData.filter(report => {
        const isGrupMatch = !grup || report.grup === status;

        return isGrupMatch;
    });

    currentPage = 1; // Reset to the first page
    renderTable(filteredData);
}

function fetchAllData() {
    document.getElementById('grup').value = '';
    currentPage = 1; // Reset to the first page
    renderTable(allData); // Render all data
}

function renderTable(data) {
    const tbody = document.getElementById('hourmeterTableBody');
    tbody.innerHTML = '';
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedData = data.slice(start, end);

    if (paginatedData.length === 0) {
        tbody.innerHTML =
            '<tr><td colspan="8" class="text-center">Tidak ada data yang ditemukan</td></tr>';
    } else {
        paginatedData.forEach((report, index) => {
            const row = `
                <tr>
                    <td>${start + index + 1}</td>
                    <td>${report.equipment}</td>
                    <td>${report.hm_awal}</td>
                    <td>${report.hm_akhir}</td>
                    <td>${report.jam_lain}</td>
                    <td>${report.breakdown}</td>
                    <td>${report.no_operator}</td>
                    <td>${report.hujan}</td>
                    <td>${report.ket}</td>
                    <td></td>
                </tr>`;
            tbody.innerHTML += row;
        });
    }
    renderPagination(data.length);
}

function renderPagination(totalRows) {
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = '';
    const pageCount = Math.ceil(totalRows / rowsPerPage);

    for (let i = 1; i <= pageCount; i++) {
        const li = document.createElement('li');
        li.className = 'page-item' + (i === currentPage ? ' active' : '');
        li.innerHTML = `<a class="page-link" href="#" onclick="changePage(${i})">${i}</a>`;
        pagination.appendChild(li);
    }
}

function changePage(page) {
    currentPage = page;
    const data = <?php echo json_encode($data); ?>;
    renderTable(data);
}

document.addEventListener('DOMContentLoaded', () => {
    allData = <?php echo json_encode($data); ?>; // Store all data for reference
    renderTable(allData); // Render the initial table
});
</script>
<script src="../assets/libs/jquery/dist/jquery.min.js"></script>
<script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/sidebarmenu.js"></script>
<script src="../assets/js/app.min.js"></script>
<script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>