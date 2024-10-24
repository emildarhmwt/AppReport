<?php
include '../Koneksi.php';

$query = "SELECT * FROM muatan";
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
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div class="body-wrapper">
            <div id="navbar"></div>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-4">Data Muatan</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="rowsPerPageSelect" class="form-label">Tampilkan:</label>
                                        <select id="rowsPerPageSelect" class="form-select"
                                            style="width: auto; display: inline-block;">
                                            <option value="10" selected>10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                        <span> data per halaman</span>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        <button class="btn btn-primary btn-sm me-3" title="Reject"
                                            onclick="showImportModal()">
                                            <i class="bi bi-file-spreadsheet"></i> Import excel
                                        </button>

                                        <div id="importModal" class="modal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Import Excel Muatan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" id="MuatanId">
                                                        <div class="mb-3">
                                                            <label for="importExcel" class="form-label">Excel :</label>
                                                            <input class="form-control" type="file" id="importExcel"
                                                                name="excelFile">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="submitImport()">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control text-black me-2" id="searchInput"
                                            placeholder="Cari..."
                                            style="max-width: 200px; height: 40px; font-size: .95rem;">
                                    </div>
                                </div>
                                <div class="table-responsive products-table" data-simplebar>
                                    <table class="table table-bordered text-nowrap mb-0 align-middle table-hover">
                                        <thead class="fs-4">
                                            <tr class="text-center">
                                                <th class="fs-3" style="width: 5%">No</th>
                                                <th class="fs-3" style="width: 45%">Tipe Hauler</th>
                                                <th class="fs-3" style="width: 45%">Jumlah</th>
                                                <th class="fs-3" style="width: 5%">Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="muatanTableBody">
                                            <!-- Data will be populated here -->
                                        </tbody>
                                    </table>
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination justify-content-center mt-3" id="Pagination">
                                            <li class="page-item" id="prevPage">
                                                <a class="page-link" href="#"
                                                    onclick="changePage(currentPage - 1)">Previous</a>
                                            </li>
                                            <!-- Page numbers will be added here -->
                                            <li class="page-item" id="nextPage">
                                                <a class="page-link" href="#"
                                                    onclick="changePage(currentPage + 1)">Next</a>
                                            </li>
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

            function deleteMuatan(id) {
                console.log('Deleting muatan with ID:', id); // Debugging: Log the ID being deleted
                if (confirm('Apakah Anda yakin ingin menghapus muatan ini?')) {
                    fetch('deleteMuatan.php', {
                            method: 'DELETE',
                            body: JSON.stringify({
                                id: id
                            }), // Send ID in the request body
                            headers: {
                                'Content-Type': 'application/json' // Set content type to JSON
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.text().then(text => {
                                    throw new Error(text);
                                });
                            }
                            return response.json(); // Parse the JSON response
                        })
                        .then(data => {
                            alert(data.message); // Show success message
                            location.reload(); // Reload the page to see the changes
                        })
                        .catch(error => {
                            console.error('Error:', error); // Log any errors
                            alert('Error: ' + error.message); // Show error message
                        });
                }
            }

            function showImportModal(MuatanId) {
                document.getElementById('MuatanId').value = MuatanId;
                new bootstrap.Modal(document.getElementById('importModal')).show();
            }

            function submitImport() {
                const MuatanId = document.getElementById('MuatanId').value;
                const importExcel = document.getElementById('importExcel').files[0];

                const formData = new FormData();
                formData.append('excelFile', importExcel);
                formData.append('id', MuatanId);

                fetch('import_muatan.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        location.reload();
                    })
                    .catch(error => console.error('Error:', error));
            }

            const rowsPerPage = document.getElementById('rowsPerPageSelect');
            const searchInput = document.getElementById('searchInput');
            let currentPage = 1;
            const maxPageNumbers = 10; // Maximum number of page numbers to display

            function renderTable(data) {
                const tbody = document.getElementById('muatanTableBody');
                tbody.innerHTML = '';

                const sortedData = data.sort((a, b) => a.tipe.localeCompare(b.tipe));

                const filteredData = sortedData.filter(report =>
                    report.tipe.toLowerCase().includes(searchInput.value.toLowerCase()) ||
                    report.jumlah.toLowerCase().includes(searchInput.value.toLowerCase())
                );
                const start = (currentPage - 1) * rowsPerPage.value;
                const end = start + parseInt(rowsPerPage.value);
                const paginatedData = filteredData.slice(start, end);

                paginatedData.forEach((report, index) => {
                    const row = `
            <tr>
                <td class="text-center">${start + index + 1}</td>
                <td>${report.tipe}</td>
                <td>${report.jumlah}</td>
                <td>
                    <button onclick="window.location.href='editMuatan.php?id=${report.id}'" class="btn btn-primary btn-sm" title="Edit">
                        <i class="bi bi-pen"></i>
                    </button>
                    <button onclick="deleteMuatan(${report.id})" class="btn btn-danger btn-sm" title="Hapus">
                        <i class="bi bi-trash3"></i>
                    </button>
                </td>
            </tr>
        `;
                    tbody.innerHTML += row;
                });

                renderPagination(filteredData.length);
            }

            function renderPagination(totalItems) {
                const totalPages = Math.ceil(totalItems / rowsPerPage.value);
                const pagination = document.getElementById('Pagination');

                // Clear existing page numbers
                pagination.querySelectorAll('.page-number').forEach(item => item.remove());

                // Show/hide Previous button
                document.getElementById('prevPage').style.display = currentPage === 1 ? 'none' : 'block';
                // Show/hide Next button
                document.getElementById('nextPage').style.display = currentPage === totalPages ? 'none' : 'block';

                // Calculate start and end page numbers
                let startPage = Math.max(1, currentPage - Math.floor(maxPageNumbers / 2));
                let endPage = Math.min(totalPages, startPage + maxPageNumbers - 1);

                if (endPage - startPage < maxPageNumbers - 1) {
                    startPage = Math.max(1, endPage - maxPageNumbers + 1);
                }

                // Add page numbers
                for (let i = startPage; i <= endPage; i++) {
                    const pageItem = document.createElement('li');
                    pageItem.className = 'page-item' + (i === currentPage ? ' active' : '');
                    pageItem.innerHTML =
                        `<a class="page-link page-number" href="#" onclick="changePage(${i})">${i}</a>`;
                    pagination.insertBefore(pageItem, document.getElementById('nextPage'));
                }
            }

            searchInput.addEventListener('input', () => {
                currentPage = 1;
                const data = <?php echo json_encode($data); ?>;
                renderTable(data);
            });

            rowsPerPage.addEventListener('change', () => {
                currentPage = 1;
                const data = <?php echo json_encode($data); ?>;
                renderTable(data);
            });

            document.addEventListener('DOMContentLoaded', () => {
                const data = <?php echo json_encode($data); ?>;
                renderTable(data);
            });

            function changePage(page) {
                const totalPages = Math.ceil(<?php echo count($data); ?> / rowsPerPage.value);
                if (page < 1 || page > totalPages) return; // Prevent going out of bounds
                currentPage = page;
                const data = <?php echo json_encode($data); ?>;
                renderTable(data);
            }
            </script>
            <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
            <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
            <script src="../assets/js/sidebarmenu.js"></script>
            <script src="../assets/js/app.min.js"></script>
            <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>