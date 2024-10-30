<?php
include '../Koneksi.php';

$query = "SELECT * FROM kontraktor_report";
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
                        <h5 class="card-title fw-semibold mb-4">Data User</h5>
                        <div class="row mt-3 mb-3">
                            <div class="col-lg-4 border-end text-center">
                                <a href="Admin.php"> Admin </a>
                            </div>
                            <div class="col-lg-4 border-end text-center">
                                <a href="User.php"> Pengawas </a>
                            </div>
                            <div class="col-lg-4 text-center">
                                <a href="Kontraktor.php"> Kontraktor </a>
                            </div>
                        </div>
                        <!-- Search-->
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
                                            onclick="window.location.href='TambahKontraktor.php'"><i
                                                class="bi bi-plus-lg"></i>
                                            Create</button>
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
                                                <th class="fs-3" style="width: 10%">Foto</th>
                                                <th class="fs-3" style="width: 40%">Nama</th>
                                                <th class="fs-3" style="width: 40%">Username</th>
                                                <th class="fs-3" style="width: 5%">Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="kontraktorTableBody">
                                            <?php foreach ($data as $index => $report): ?>
                                            <tr>
                                                <td class="text-center"><?php echo $index + 1; ?></td>
                                                <td>
                                                    <img src="<?php echo $report['file_admin']; ?>" alt="Image"
                                                        style="width: 50px; height: auto;">
                                                </td>
                                                <td><?php echo $report['nama']; ?></td>
                                                <td><?php echo $report['username']; ?></td>
                                                <td>
                                                    <button
                                                        onclick="window.location.href='editKontraktor.php?id=${report.id}'"
                                                        class="btn btn-primary btn-sm" title="Edit">
                                                        <i class="bi bi-pen"></i>
                                                    </button>
                                                    <button onclick="deleteKontraktor(<?php echo $report['id']; ?>)"
                                                        class="btn btn-danger btn-sm" title="Hapus">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination justify-content-center mt-3" id="Pagination">
                                            <!-- Pagination items will be added here by JavaScript -->
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

            function deleteKontraktor(id) {
                console.log('Deleting kontraktor with ID:', id); // Debugging: Log the ID being deleted
                if (confirm('Apakah Anda yakin ingin menghapus kontraktor ini?')) {
                    fetch('deleteKontraktor.php', {
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

            const rowsPerPage = document.getElementById('rowsPerPageSelect');
            const searchInput = document.getElementById('searchInput'); // Add search input reference
            let currentPage = 1;

            function renderTable(data) {
                const tbody = document.getElementById('kontraktorTableBody');
                tbody.innerHTML = '';
                const filteredData = data.filter(report =>
                    report.nama.toLowerCase().includes(searchInput.value.toLowerCase()) ||
                    report.username.toLowerCase().includes(searchInput.value.toLowerCase())
                ); // Filter data based on search input
                const start = (currentPage - 1) * rowsPerPage.value;
                const end = start + parseInt(rowsPerPage.value);
                const paginatedData = filteredData.slice(start, end); // Use filtered data for pagination

                paginatedData.forEach((report, index) => {
                    const row = `
            <tr>
                <td class="text-center";>${start + index + 1}</td>
                 <td>
                    <img src="${report.file_admin}" alt="Image" style="width: 50px; height: auto;">
                </td>
                <td>${report.nama}</td>
                <td>${report.username}</td>
                <td>
                    <button onclick="window.location.href='editKontraktor.php?id=${report.id}'" class="btn btn-primary btn-sm" title="Edit">
                        <i class="bi bi-pen"></i>
                    </button>
                    <button onclick="deleteKontraktor(${report.id})" class="btn btn-danger btn-sm" title="Hapus">
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
                const pagination = document.getElementById('Pagination');
                pagination.innerHTML = '';
                const totalPages = Math.ceil(totalItems / rowsPerPage.value);

                for (let i = 1; i <= totalPages; i++) {
                    const pageItem = document.createElement('li');
                    pageItem.className = 'page-item' + (i === currentPage ? ' active' :
                        ''); // Add 'active' class for the current page
                    pageItem.innerHTML = `<a class="page-link" href="#" onclick="changePage(${i})">${i}</a>`;
                    pagination.appendChild(pageItem);
                }
            }

            searchInput.addEventListener('input', () => {
                currentPage = 1; // Reset to first page on search
                const data = <?php echo json_encode($data); ?>;
                renderTable(data); // Render table with search results
            });

            rowsPerPage.addEventListener('change', () => {
                currentPage = 1; // Reset to first page
                const data = <?php echo json_encode($data); ?>;
                renderTable(data); // Render table with new rows per page
            });

            document.addEventListener('DOMContentLoaded', () => {
                const data = <?php echo json_encode($data); ?>;
                renderTable(data); // Initial render
            });

            function changePage(page) {
                currentPage = page;
                const data = <?php echo json_encode($data); ?>;
                renderTable(data);
            }

            rowsPerPage.addEventListener('change', () => {
                currentPage = 1; // Reset to first page
                const data = <?php echo json_encode($data); ?>;
                renderTable(data);
            });

            document.addEventListener('DOMContentLoaded', () => {
                const data = <?php echo json_encode($data); ?>;
                renderTable(data);
            });
            </script>
            <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
            <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
            <script src="../assets/js/sidebarmenu.js"></script>
            <script src="../assets/js/app.min.js"></script>
            <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>