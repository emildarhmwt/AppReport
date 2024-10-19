<?php
include '../Koneksi.php';

$query = "SELECT * FROM admin_report";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
                        <h5 class="card-title fw-semibold mb-4">Data Admin</h5>
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
                                            onclick="window.location.href='tambahadmin.php'"><i
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
                                            <tr>
                                                <th class="fs-3" style="width: 5%">No</th>
                                                <th class="fs-3" style="width: 45%">Nama</th>
                                                <th class="fs-3" style="width: 45%">Username</th>
                                                <th class="fs-3" style="width: 5%">Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="adminTableBody">
                                            <!-- Data will be populated here -->
                                        </tbody>
                                    </table>
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

            function deleteAdmin(id) {
                console.log('Deleting admin with ID:', id); // Debugging: Log the ID being deleted
                if (confirm('Apakah Anda yakin ingin menghapus admin ini?')) {
                    fetch('deleteAdmin.php', {
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

            document.addEventListener('DOMContentLoaded', () => {
                const data = <?php echo json_encode($data); ?>;
                const tbody = document.getElementById('adminTableBody');
                tbody.innerHTML = '';

                if (data.length === 0) {
                    tbody.innerHTML =
                        '<tr><td colspan="8" class="text-center">Tidak ada data yang ditemukan</td></tr>';
                } else {
                    data.forEach((report, index) => {
                        const row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${report.nama}</td>
                    <td>${report.username}</td>
                    <td>
                        <button onclick="window.location.href='editadmin.php?id=${report.id}'" class="btn btn-primary btn-sm" title="Edit">
                            <i class="bi bi-pen"></i>
                        </button>
                        <button onclick="deleteAdmin(${report.id})" class="btn btn-danger btn-sm" title="Hapus">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </td>
                </tr>
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