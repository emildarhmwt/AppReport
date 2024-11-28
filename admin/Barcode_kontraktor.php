<?php
include '../Koneksi.php';

$query = "SELECT * FROM barcode_kontraktor";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Acme&family=Coiny&family=Concert+One&family=Fredoka:wght@300..700&family=Outfit:wght@100..900&family=Pacifico&family=Playpen+Sans:wght@100..800&family=Playwrite+DE+Grund:wght@100..400&family=Righteous&family=Sacramento&family=Varela+Round&family=Yatra+One&display=swap"
        rel="stylesheet">
    <style>
    .body-wrapper {
        background-image: url(../assets/images/backgrounds/4.png);
        background-size: cover;
        background-repeat: no-repeat;
    }

    .varela-round-regular {
        font-family: "Varela Round", serif;
        font-weight: 400;
        font-style: normal;
    }

    .judul {
        font-family: "Varela Round", serif;
        text-align: center;
        font-size: 30px;
        margin-bottom: 50px;
        margin-top: 10px;
        color: #0f3f61;
    }

    .sub-judul {
        font-family: "Varela Round", serif;
        color: #0f3f61;
    }

    .form-select.text-white option {
        color: black;
    }

    .form-select.text-white {
        color: #0f3f61;
    }

    .form-control::placeholder {
        color: #0f3f61;
    }

    .card-preview {
        background-color: #b37219 !important;
    }

    .produksi {
        color: #0f3f61;
        font-family: "Varela Round", serif;
        font-size: 17px;
    }

    .produksi:hover {
        color: black;
    }

    @media (max-width: 768px) {
        .sub-judul {
            display: none;
        }
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
                        <h5 class="judul fw-semibold">Data Barcode Kontraktor</h5>
                        <div class="row mt-3 mb-3">
                            <div class="col-lg-6 col-6 border-end text-center">
                                <a href="Barcode.php" class="produksi"> Pengawas </a>
                            </div>
                            <div class="col-lg-6 col-6 text-center">
                                <a href="Barcode_kontraktor.php" class="produksi"> Kontraktor </a>
                            </div>
                        </div>
                        <!-- Search-->
                        <!-- table -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="rowsPerPageSelect" class="sub-judul">Tampilkan:</label>
                                        <select id="rowsPerPageSelect" class="form-select text-white"
                                            style="width: auto; display: inline-block;">
                                            <option value="5">5</option>
                                            <option value="10" selected>10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                        </select>
                                        <span class="sub-judul"> data per halaman</span>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary mx-3"
                                            onclick="window.location.href='tambahBarcodeKontraktor.php'">
                                            Tambah</button>
                                        <input type="text" class="form-control text-white me-2" id="searchInput"
                                            placeholder="Cari..."
                                            style="max-width: 200px; height: 40px; font-size: .95rem;">
                                    </div>
                                </div>
                                <div class="table-responsive products-table" data-simplebar>
                                    <table class="table table-bordered text-nowrap mb-0 align-middle table-hover">
                                        <thead class="fs-4">
                                            <tr class="text-center">
                                                <th class="fs-3" style="width: 5%">No</th>
                                                <th class="fs-3" style="width: 28%">Nama</th>
                                                <th class="fs-3" style="width: 28%">Jabatan</th>
                                                <th class="fs-3" style="width: 28%">NIP</th>
                                                <th class="fs-3" style="width: 6%">TTD</th>
                                                <th class="fs-3" style="width: 5%">Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="barcodeTableBody">
                                            <?php foreach ($data as $index => $report): ?>
                                            <tr class="text-center">
                                                <td class="text-center"><?php echo $index + 1; ?></td>
                                                <td><?php echo $report['nama']; ?></td>
                                                <td><?php echo $report['jabatan']; ?></td>
                                                <td><?php echo $report['nip']; ?></td>
                                                <td>
                                                    <img src="<?php echo $report['file_path']; ?>" alt="Image"
                                                        style="width: 50px; height: auto;">
                                                </td>
                                                <td>
                                                    <button
                                                        onclick="window.location.href='editBarcodeKontraktor.php?id=<?php echo $report['id']; ?>'"
                                                        class="btn btn-primary btn-sm" title="Edit">
                                                        <i class="bi bi-pen"></i>
                                                    </button>
                                                    <button
                                                        onclick="deleteBarcodeKontraktor(<?php echo $report['id']; ?>)"
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

            function deleteBarcodeKontraktor(id) {
                console.log('Deleting barcode with ID:', id); // Debugging: Log the ID being deleted
                if (confirm('Apakah Anda yakin ingin menghapus barcode ini?')) {
                    fetch('deleteBarcodeKontraktor.php', {
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
            const searchInput = document.getElementById('searchInput');
            let currentPage = 1;
            let filteredData = <?php echo json_encode($data); ?>; // Simpan data asli untuk pencarian

            function displayPagination(totalRows) {
                const paginationElement = document.getElementById('Pagination');
                const totalPages = Math.ceil(totalRows / rowsPerPage.value);
                paginationElement.innerHTML = '';

                for (let i = 1; i <= totalPages; i++) {
                    const li = document.createElement('li');
                    li.className = 'page-item';
                    li.innerHTML = `<a class="page-link" href="#" onclick="changePage(${i})">${i}</a>`;
                    paginationElement.appendChild(li);
                }
                highlightCurrentPage();
            }

            function changePage(page) {
                currentPage = page;
                updateTable();
            }

            function updateTable() {
                const start = (currentPage - 1) * rowsPerPage.value;
                const end = start + parseInt(rowsPerPage.value);
                const displayedData = filteredData.slice(start, end);

                const tableBody = document.getElementById('barcodeTableBody');
                tableBody.innerHTML = '';

                displayedData.forEach((report, index) => {
                    const row = `<tr class="text-center">
                                    <td class="text-center">${start + index + 1}</td>
                                    <td>${report.nama}</td>
                                    <td>${report.jabatan}</td>
                                    <td>${report.nip}</td>
                                    <td>
                                        <img src="${report.file_path}" alt="Image" style="width: 50px; height: auto;">
                                    </td>
                                    <td>
                                        <button
                                            onclick="window.location.href='editBarcodeKontraktor.php?id=<?php echo $report['id']; ?>'"
                                            class="btn btn-primary btn-sm" title="Edit">
                                            <i class="bi bi-pen"></i>
                                        </button>
                                        <button
                                            onclick="deleteBarcodeKontraktor(<?php echo $report['id']; ?>)"
                                            class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </td>
                                    </tr>`;
                    tableBody.innerHTML += row;
                });

                displayPagination(filteredData.length);
            }

            function highlightCurrentPage() {
                const pageLinks = document.querySelectorAll('.page-link');
                pageLinks.forEach(link => {
                    link.classList.remove('active');
                });
                pageLinks[currentPage - 1].classList.add('active', '#052d47', ' #ffffff');
            }

            rowsPerPage.addEventListener('change', () => {
                currentPage = 1; // Reset ke halaman pertama saat jumlah baris per halaman berubah
                updateTable(); // Panggil fungsi untuk memperbarui tampilan tabel
            });

            searchInput.addEventListener('input', () => {
                const searchTerm = searchInput.value.toLowerCase();
                filteredData = <?php echo json_encode($data); ?>.filter(report =>
                    report.nama.toLowerCase().includes(searchTerm) ||
                    report.jabatan.toLowerCase().includes(searchTerm) ||
                    report.nip.toLowerCase().includes(searchTerm)
                );
                currentPage = 1; // Reset ke halaman pertama saat melakukan pencarian
                updateTable(); // Panggil fungsi untuk memperbarui tampilan tabel
            });

            // Panggil fungsi untuk menampilkan pagination setelah data diambil
            displayPagination(filteredData.length);
            updateTable(); // Tampilkan tabel awal
            </script>
            <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
            <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
            <script src="../assets/js/sidebarmenu.js"></script>
            <script src="../assets/js/app.min.js"></script>
            <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>