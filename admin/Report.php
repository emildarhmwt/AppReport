<?php
include '../Koneksi.php';

$query = "SELECT * FROM operation_report";
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
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css">
    <link rel=" stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
                        <h5 class="card-title fw-semibold mb-4">Operation Report</h5>
                        <div class="row mt-3 mb-3">
                            <div class="col-lg-6 border-end text-center">
                                <a href="Report.php"> Produksi </a>
                            </div>
                            <div class="col-lg-6 text-center">
                                <a href="Report_hourmeter.php"> Jam Jalan </a>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <form id="form-operation" onSubmit="return handleSubmit(event)">
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
                                    <!-- <div class="mb-3">
                                        <label for="status" class="form-label">Status :</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="" selected disabled>PRODUKSI / JAM JALAN </option>
                                            <option value="Produksi">Produksi</option>
                                            <option value="Jam Jalan">Jam Jalan</option>
                                        </select>
                                    </div> -->
                                    <div class="d-flex justify-content-center mt-3">
                                        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i>
                                            Search Data</button>
                                        <button type="button" class="btn btn-primary mx-3" onclick="fetchAllData()">All
                                            Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
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
                        <div class="d-flex align-items-stretch">
                            <div class="card w-100 overflow-hidden">
                                <div data-simplebar class="position-relative">
                                    <div class="table-responsive products-tabel" data-simplebar>
                                        <table class="table table-bordered text-nowrap mb-0 align-middle table-hover">
                                            <thead class="fs-4">
                                                <tr>
                                                    <th class="fs-3">No</th>
                                                    <th class="fs-3">Hari / Tanggal</th>
                                                    <th class="fs-3">Shift</th>
                                                    <th class="fs-3">Giliran / Group</th>
                                                    <th class="fs-3">Pengawas</th>
                                                    <th class="fs-3">Lokasi Kerja</th>
                                                    <th class="fs-3">Status</th>
                                                    <th class="fs-3">PIC</th>
                                                    <th class="fs-3"> </th>
                                                </tr>
                                            </thead>
                                            <tbody id="operationTableBody">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
        renderTable(allData);
    }

    function handleSubmit(event) {
        event.preventDefault(); // Prevent form submission
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        const status = "Produksi";

        const filteredData = allData.filter(report => {
            const reportDate = new Date(report.tanggal);
            const start = new Date(startDate);
            const end = new Date(endDate);
            const isDateInRange = (!startDate || reportDate >= start) && (!endDate || reportDate <= end);
            const isStatusMatch = report.status === status;

            return isDateInRange && isStatusMatch;
        });

        currentPage = 1; // Reset to the first page
        renderTable(filteredData);
    }

    function fetchAllData() {
        document.getElementById('startDate').value = '';
        document.getElementById('endDate').value = '';
        currentPage = 1; // Reset to the first page
        allData.sort((a, b) => new Date(b.tanggal) - new Date(a.tanggal));
        renderTable(allData);
    }

    function formatDate(dateString) {
        const options = {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        };
        return new Date(dateString).toLocaleDateString('id-ID', options); // Format date to d M Y
    }

    function renderTable(data) {
        const filteredData = data
            .filter(report => report.status === "Produksi")
            .sort((a, b) => new Date(b.tanggal) - new Date(a.tanggal));
        const tbody = document.getElementById('operationTableBody');
        tbody.innerHTML = '';
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const paginatedData = filteredData.slice(start, end);

        if (paginatedData.length === 0) {
            tbody.innerHTML =
                '<tr><td colspan="8" class="text-center">Tidak ada data yang ditemukan</td></tr>';
        } else {
            paginatedData.forEach((report, index) => {
                const row = `
                <tr>
                    <td>${start + index + 1}</td>
                    <td>${formatDate(report.tanggal)}</td>
                    <td>${report.shift}</td>
                    <td>${report.grup}</td>
                    <td>${report.pengawas}</td>
                    <td>${report.lokasi}</td>
                    <td>${report.status}</td>
                    <td>${report.pic}</td>
                    <td>
                     <button onclick="window.location.href='Preview.php?id=${report.id}'" class="btn btn-primary btn-sm" title="Edit">
                        <i class="bi bi-eye"></i>
                    </button>
                    </td>
                </tr>`;
                tbody.innerHTML += row;
            });
        }
        renderPagination(filteredData.length);
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